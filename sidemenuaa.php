<?php 
include 'cdns.php'; 
include 'config.php'; 
?>
<?php
session_start();
if (!isset($_SESSION['uId'])) {
	$msg="Session Ended";
	header('location:index.php?msg='.$msg.'&color=danger');
}
?>

<style type="text/css">
	html, body {
    font-family: Arial, Helvetica, sans-serif;
    margin:0;
}


/* define a fixed width for the entire menu */
.navigation {
  width: 200px;
}

/* reset our lists to remove bullet points and padding */
.mainmenu, .submenu {
  list-style: none;
  padding: 0;
  margin: 0;
}

/* make ALL links (main and submenu) have padding and background color */
.mainmenu a {
  display: block;
  background: rgba(236,236,236,1);
background: -moz-linear-gradient(left, rgba(236,236,236,1) 0%, rgba(246,246,246,1) 95%, rgba(217,217,217,1) 100%);
background: -webkit-gradient(left top, right top, color-stop(0%, rgba(236,236,236,1)), color-stop(95%, rgba(246,246,246,1)), color-stop(100%, rgba(217,217,217,1)));
background: -webkit-linear-gradient(left, rgba(236,236,236,1) 0%, rgba(246,246,246,1) 95%, rgba(217,217,217,1) 100%);
background: -o-linear-gradient(left, rgba(236,236,236,1) 0%, rgba(246,246,246,1) 95%, rgba(217,217,217,1) 100%);
background: -ms-linear-gradient(left, rgba(236,236,236,1) 0%, rgba(246,246,246,1) 95%, rgba(217,217,217,1) 100%);
background: linear-gradient(to right, rgba(236,236,236,1) 0%, rgba(246,246,246,1) 95%, rgba(217,217,217,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ececec', endColorstr='#d9d9d9', GradientType=1 );
  text-decoration: none;
  padding: 10px;
  border-bottom: 2px solid #e6e6e6;
  color: #288AB9;
  font-weight: bold;
  font-size: 14px;

}

/* add hover behaviour */
.mainmenu a:hover {
    background: rgba(247,247,247,1);
background: -moz-linear-gradient(left, rgba(247,247,247,1) 0%, rgba(246,246,246,1) 96%, rgba(240,240,240,1) 100%);
background: -webkit-gradient(left top, right top, color-stop(0%, rgba(247,247,247,1)), color-stop(96%, rgba(246,246,246,1)), color-stop(100%, rgba(240,240,240,1)));
background: -webkit-linear-gradient(left, rgba(247,247,247,1) 0%, rgba(246,246,246,1) 96%, rgba(240,240,240,1) 100%);
background: -o-linear-gradient(left, rgba(247,247,247,1) 0%, rgba(246,246,246,1) 96%, rgba(240,240,240,1) 100%);
background: -ms-linear-gradient(left, rgba(247,247,247,1) 0%, rgba(246,246,246,1) 96%, rgba(240,240,240,1) 100%);
background: linear-gradient(to right, rgba(247,247,247,1) 0%, rgba(246,246,246,1) 96%, rgba(240,240,240,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f7f7f7', endColorstr='#f0f0f0', GradientType=1 );
}


.active{
	background: rgba(247,247,247,1) !important;
background: -moz-linear-gradient(left, rgba(247,247,247,1) 0%, rgba(246,246,246,1) 96%, rgba(240,240,240,1) 100%) !important;
background: -webkit-gradient(left top, right top, color-stop(0%, rgba(247,247,247,1)), color-stop(96%, rgba(246,246,246,1)), color-stop(100%, rgba(240,240,240,1))) !important;
background: -webkit-linear-gradient(left, rgba(247,247,247,1) 0%, rgba(246,246,246,1) 96%, rgba(240,240,240,1) 100%) !important;
background: -o-linear-gradient(left, rgba(247,247,247,1) 0%, rgba(246,246,246,1) 96%, rgba(240,240,240,1) 100%) !important;
background: -ms-linear-gradient(left, rgba(247,247,247,1) 0%, rgba(246,246,246,1) 96%, rgba(240,240,240,1) 100%) !important;
background: linear-gradient(to right, rgba(247,247,247,1) 0%, rgba(246,246,246,1) 96%, rgba(240,240,240,1) 100%) !important;
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f7f7f7', endColorstr='#f0f0f0', GradientType=1 ) ;

color:#000 !important;
font-weight: bold !important;
}


/* when hovering over a .mainmenu item,
  display the submenu inside it.
  we're changing the submenu's max-height from 0 to 200px;
*/

.mainmenu li:hover .submenu {
 /* display: block;
  max-height: 1200px;	*/
}

/*
  we now overwrite the background-color for .submenu links only.
  CSS reads down the page, so code at the bottom will overwrite the code at the top.
*/

.submenu a {
  /*background-color: #999;*/
background: rgba(236,236,236,1);
background: -moz-linear-gradient(left, rgba(236,236,236,1) 0%, rgba(246,246,246,1) 0%, rgba(217,217,217,1) 1%, rgba(217,217,217,1) 100%);
background: -webkit-gradient(left top, right top, color-stop(0%, rgba(236,236,236,1)), color-stop(0%, rgba(246,246,246,1)), color-stop(1%, rgba(217,217,217,1)), color-stop(100%, rgba(217,217,217,1)));
background: -webkit-linear-gradient(left, rgba(236,236,236,1) 0%, rgba(246,246,246,1) 0%, rgba(217,217,217,1) 1%, rgba(217,217,217,1) 100%);
background: -o-linear-gradient(left, rgba(236,236,236,1) 0%, rgba(246,246,246,1) 0%, rgba(217,217,217,1) 1%, rgba(217,217,217,1) 100%);
background: -ms-linear-gradient(left, rgba(236,236,236,1) 0%, rgba(246,246,246,1) 0%, rgba(217,217,217,1) 1%, rgba(217,217,217,1) 100%);
padding-left: 20px;

}

/* hover behaviour for links inside .submenu */
.submenu a:hover {
  /*background-color: #666;*/
  background: rgba(247,247,247,1);
background: -moz-linear-gradient(left, rgba(247,247,247,1) 0%, rgba(246,246,246,1) 6%, rgba(240,240,240,1) 100%);
background: -webkit-gradient(left top, right top, color-stop(0%, rgba(247,247,247,1)), color-stop(6%, rgba(246,246,246,1)), color-stop(100%, rgba(240,240,240,1)));
background: -webkit-linear-gradient(left, rgba(247,247,247,1) 0%, rgba(246,246,246,1) 6%, rgba(240,240,240,1) 100%);
background: -o-linear-gradient(left, rgba(247,247,247,1) 0%, rgba(246,246,246,1) 6%, rgba(240,240,240,1) 100%);
background: -ms-linear-gradient(left, rgba(247,247,247,1) 0%, rgba(246,246,246,1) 6%, rgba(240,240,240,1) 100%);
background: linear-gradient(to right, rgba(247,247,247,1) 0%, rgba(246,246,246,1) 6%, rgba(240,240,240,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f7f7f7', endColorstr='#f0f0f0', GradientType=1 );
}

/* this is the initial state of all submenus.
  we set it to max-height: 0, and hide the overflowed content.
*/
.submenu {
  overflow: hidden;
  display: none;
  -webkit-transition: all 0.5s ease-out;
  /**/

}

.smicon{
  font-size:20px;font-weight: bold;float: right;
}

.frminp{
  padding: 4px !important;
  height:25px;
  border-radius: 4px;
  font-size: 11px;
  font-weight:550;
}
.frmbtn{
  padding: 2px 4px !important;
  font-size: 11px;
}

.sidmenudiv{
  height: 100%;
width:200px;
background: rgba(236,236,236,1);
background: -moz-linear-gradient(left, rgba(236,236,236,1) 0%, rgba(246,246,246,1) 95%, rgba(217,217,217,1) 100%);
background: -webkit-gradient(left top, right top, color-stop(0%, rgba(236,236,236,1)), color-stop(95%, rgba(246,246,246,1)), color-stop(100%, rgba(217,217,217,1)));
background: -webkit-linear-gradient(left, rgba(236,236,236,1) 0%, rgba(246,246,246,1) 95%, rgba(217,217,217,1) 100%);
background: -o-linear-gradient(left, rgba(236,236,236,1) 0%, rgba(246,246,246,1) 95%, rgba(217,217,217,1) 100%);
background: -ms-linear-gradient(left, rgba(236,236,236,1) 0%, rgba(246,246,246,1) 95%, rgba(217,217,217,1) 100%);
background: linear-gradient(to right, rgba(236,236,236,1) 0%, rgba(246,246,246,1) 95%, rgba(217,217,217,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ececec', endColorstr='#d9d9d9', GradientType=1 );
margin:0;
display: block;
float: left;
position: absolute;
}

.estable thead th,.estable tbody th,.estable tbody td{
  font-size: 12px !important;
  padding: 1px 2px !important;
  text-align: center;
  font-weight: 500;
  border:2px solid #ccc;
  margin:0px;
}
.estable thead th{
  background-color:#b7e0f4;
  color: #000;
  font-size: 13px;
  font-weight: bold;
  padding: 7px 3px !important;
}

.estable tbody td{
  background-color: #fff !important;
}
.paginate_button,.dataTables_length,.dataTables_info,.dataTables_filter{
  font-size: 12px !important;
  font-weight: 600 !important;
  padding: 1px 2px !important;
}


</style>

<div class="sidmenudiv">

  <?php
  $pn=basename($_SERVER['PHP_SELF']);
  ?>
  <h3 style="text-align: center;color:#3f779e;font-family: 'Poppins', sans-serif;padding: 10px;background-color: #D3E4EF;padding-top:20px;padding-bottom: 20px;">Agreement</h3>
  <nav class="navigation">
    <ul class="mainmenu">
      <li><a href="home.php" class="<?=($pn=='home.php')?'active':'';?>" >Home</a></li>

      <li><a href="javascript:void(0)" onclick="ot(this)">Masters<i class="fa fa-angle-down smicon"></i></a>
        <ul class="submenu">
          <li><a href="company.php" class="<?=($pn=='company.php')?'active':'';?>" >Company</a> </li>
          <li><a href="users.php" class="<?=($pn=='users.php')?'active':'';?>" >Users</a> </li>
          <li><a href="state.php" class="<?=($pn=='state.php')?'active':'';?>" >State</a></li>
          <li><a href="district.php" class="<?=($pn=='district.php')?'active':'';?>" >District</a></li>
          <li><a href="tahsil.php" class="<?=($pn=='tahsil.php')?'active':'';?>" >Tahsil</a></li>
          <li><a href="village.php" class="<?=($pn=='village.php')?'active':'';?>" >Village</a></li>
          
        </ul>
      </li>
      <li><a  href="javascript:void(0)" onclick="ot(this)">Agreement<i class="fa fa-angle-down smicon"></i></a>
        <ul class="submenu">
          <li><a href="">Tops</a></li>
          <li><a href="">Bottoms</a></li>
          
        </ul>
      </li>
      <li><a href="report.php" class="<?=($pn=='report.php')?'active':'';?>" >Report</a></li>
      <li><a href="">Help</a></li>

      <li><a href="logout.php" >LogOut</a></li>
    </ul>
  </nav>
</div>



<script type="text/javascript">
	$(document).ready(function() 
	{
	 	var pg = '<?=$pn?>';

		$('.submenu a').each(function(){
		     var href = $(this).attr("href");
		     if(href == pg){
            $(this).parent().parent().css('display','block');
            $(this).parent().parent().parent().find('.fa').addClass('fa-angle-up');
            $(this).parent().parent().parent().find('.fa').removeClass('fa-angle-down');
		     }else{
		        
		     }
		  });

	});


	function ot(th){
		if($(th).parent().find('.submenu').css('display') == 'none'){
      $(th).parent().find('.submenu').css('display','block');
      $(th).parent().find('.fa').removeClass('fa-angle-down');
			$(th).parent().find('.fa').addClass('fa-angle-up');
			// $(th).addClass('active');
		}else{
			$(th).parent().find('.submenu').css('display','none');
      $(th).parent().find('.fa').removeClass('fa-angle-up');
      $(th).parent().find('.fa').addClass('fa-angle-down');
			// $(th).removeClass('active');

		}
	}

</script>