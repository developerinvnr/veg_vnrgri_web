<?php session_start();

include 'sidemenu.php';

?>



<style type="text/css">

	.pagethings{

		position: absolute;

		left: 200px;

		padding: 20px;

	}

  .ftable thead th,.ftable tbody th,.ftable tbody td{

    font-size: 13px !important;

    font-weight: bold;

    border:2px solid #ccc;

    margin:0px;

    /*padding: 10px !important;*/

  }

  

  .ftable tbody th{

    padding: 10px !important;

  }

  .ftable tbody td{

    background-color: #fff !important;

    /*padding: 10px !important;*/

  }

  input{

    width: 250px;

    padding:5px;

  }

</style>



<div class="pagethings" style="width:85%;">

 <div class="card-deck" style="padding-right:50px;padding-left:50px;padding-top:50px;">

 

 <?php 

   $qry=mysql_query("select * from users where uId=".$_SESSION['uId']);

   $udata=mysql_fetch_assoc($qry);

 ?>

 

 <div style="background-color:#D3E4EF;padding: 10px;">

  <table class="ftable">

    <tr>

      <th colspan="2">User Details

        <span style="float: right;">

          <img id="peditimg" src="image/edit.png" onclick="editprofile()" style="width:18px;height:15px;cursor:pointer;"/>

           <button id="psavebtn" onclick="saveprofile()" style="display: none;" class="btn btn-sm btn-primary frmbtn">Save</button>

           <button id="pcanbtn" onclick="cancel()" style="display: none;" class="btn btn-sm btn-danger frmbtn">Cancel</button>

        </span>

      </th>

      

    </tr>

    <tr>

      <th>Name</th>

      <td><input id="name" value="<?=$udata['uName']?>" readonly style="background-color:#e6e6e6;"></td>

    </tr>

    <tr>

      <th>Username</th>

      <td><input id="uname" value="<?=$udata['uUsername']?>" readonly style="background-color:#e6e6e6;"></td>

    </tr>

    <tr>

      <th>User Type</th>

      <td><input value="<?=$udata['uType']?>" readonly style="background-color:#e6e6e6;"></td>

    </tr>

    <tr>

      <th>Contact</th>

      <td><input id="contact" value="<?=$udata['uContact']?>" readonly style="background-color:#e6e6e6;"></td>

    </tr>

    <tr>

      <th>Email</th>

      <td><input id="email" value="<?=$udata['uEmail']?>" readonly style="background-color:#e6e6e6;"></td>

    </tr>

    <tr>

      <th>Status</th>

      <td><input value="<?=$udata['uStatus']?>" readonly style="background-color:#e6e6e6;"></td>

    </tr>

    <tr>

      <th>Password</th>

      <td>

        <span id="chnpw" style="color:blue;cursor: pointer;" onclick="$('#chngpwddiv').show(500);$('#chnpw').hide(500);">Change Password</span>

        <div id="chngpwddiv" style="display: none;">

          <input type="password" id="curpass" placeholder="Current Password"><br>

          <input type="password" id="newpass" placeholder="New Password"><br>

          <input type="password" id="cnewpass" placeholder="Confirm New Password"><br>

          

          <button class="btn btn-sm btn-primary frmbtn" onclick="savepass()">Save</button>

          <button class="btn btn-sm btn-danger frmbtn" onclick="$('#chngpwddiv').hide(500);$('#curpass').val('');$('#newpass').val('');$('#cnewpass').val('');$('#chnpw').show(500);">Cancel</button>

        </div>

      </td>

    </tr>



  </table>

 </div>

 



 





 </div>

</div>



<script type="text/javascript">





function cancel(){

  $('#peditimg').show(500);

  $('#psavebtn').hide(500);

  $('#pcanbtn').hide(500);



  $('#name').attr('readonly',true);

  $('#uname').attr('readonly',true);

  $('#contact').attr('readonly',true);

  $('#email').attr('readonly',true);



  $('#name').css('background-color','#e6e6e6');

  $('#uname').css('background-color','#e6e6e6');

  $('#contact').css('background-color','#e6e6e6');

  $('#email').css('background-color','#e6e6e6');

}  





function editprofile(){

  $('#name').attr('readonly',false);

  $('#uname').attr('readonly',false);

  $('#contact').attr('readonly',false);

  $('#email').attr('readonly',false);



  $('#name').css('background-color','#fff');

  $('#uname').css('background-color','#fff');

  $('#contact').css('background-color','#fff');

  $('#email').css('background-color','#fff');



  $('#peditimg').hide(500);

  $('#psavebtn').show(500);

  $('#pcanbtn').show(500);

}



function saveprofile(){

  $('#name').attr('readonly',true);

  $('#uname').attr('readonly',true);

  $('#contact').attr('readonly',true);

  $('#email').attr('readonly',true);



  $('#name').css('background-color','#e6e6e6');

  $('#uname').css('background-color','#e6e6e6');

  $('#contact').css('background-color','#e6e6e6');

  $('#email').css('background-color','#e6e6e6');





  var name = $('#name').val();

  var uname = $('#uname').val();

  var contact = $('#contact').val();

  var email = $('#email').val();





  $.post("profileAjax.php",{ act:'saveProfile',name:name,uname:uname,contact:contact,email:email},function(data) {

        // console.log(data);



      if(data.includes("updated")){

        alert(' Updated Successfully! \n\n\n');

        $('#peditimg').show(500);

        $('#psavebtn').hide(500);

        $('#pcanbtn').hide(500);

      }else if(data.includes("error")){

        alert(' Something went wrong! \n Please try again after sometime. \n\n\n');

      }

  });



}





function savepass(){



  var curpass = $('#curpass').val();

  var newpass = $('#newpass').val();

  var cnewpass = $('#cnewpass').val();



  if(newpass==cnewpass){



    $.post("profileAjax.php",{ act:'savePass',curpass:curpass,newpass:newpass},function(data) {

        // console.log(data);

        if(data.includes("updated")){

          alert(' Password Changed Successfully! \n\n\n');

          $('#chngpwddiv').hide(500);

          $('#curpass').val('');

          $('#newpass').val('');

          $('#cnewpass').val('');

          $('#chnpw').show(500);

        }else if(data.includes("error")){

          alert(' Something went wrong! \n Please try again after sometime. \n\n\n');

        }else if(data.includes("invalidpass")){

          alert(' Wrong Current Password! \n Please enter Current Password Correctly. \n\n\n');

          $('#curpass').val('');

          $('#curpass').focus();  

        }



    });



  }else{

    alert('New Passwords not matched! \n Please enter same password. \n\n\n');

    $('#newpass').val('');

    $('#cnewpass').val('');

    $('#newpass').focus();    

  }



  



}



function FunDetails(v)

{

  window.location="homelist.php?v="+v;

}

</script>





