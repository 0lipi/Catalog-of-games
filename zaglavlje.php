<?php
ob_start();
if(session_status()==PHP_SESSION_NONE){
session_start();	
}
	$aktivni_korisnik=0;
	$aktivni_korisnik_tip=-1;
	$aktivni_korisnik_id=0;		
	$ime_tip="";
	if(isset($_SESSION['aktivni_korisnik'])){
		$aktivni_korisnik=$_SESSION['aktivni_korisnik'];
		$aktivni_korisnik_id=$_SESSION["aktivni_korisnik_id"];
		$aktivni_korisnik_ime=$_SESSION['aktivni_korisnik_ime'];
		$aktivni_korisnik_tip=$_SESSION['aktivni_korisnik_tip'];
		$aktivni_korisnik_tipime=$_SESSION['aktivni_korisnik_tipime'];
		$aktivni_korisnik_slika=$_SESSION['aktivni_korisnik_slika'];
		
	}
include("spojnabazu.php");	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Igre i Uzrasti</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="menu.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function Provjera(forma){	
		var svielementi = document.forms[forma];
		var sveporuke = "";
		var gresaka=0;
		
		
		if(forma=="korisniklogin"){
		
			for (var i=0;i<svielementi.length;i++){		
			

				
				if(svielementi[i].value==""){
				gresaka++;
				
				sveporuke+="<br>Unos <strong><i>"+svielementi[i].placeholder+"</i></strong> nije evidentiran!";	
				}
				
				
			}
		
		}
		
		
		if(forma=="korisnik"){
		
			for (var i=0;i<svielementi.length;i++){		
			
			if(svielementi[i].id!="slika" && svielementi[i].id!="photo"){
				
				if(svielementi[i].value==""){
				gresaka++;
				
				sveporuke+="<br>Unos <strong><i>"+svielementi[i].placeholder+"</i></strong> nije evidentiran!";	
				}
				
			}
				
			}
		
		}
			
		if(forma=="kategorija"){
		
			for (var i=0;i<svielementi.length;i++){
				if(svielementi[i].value==""){
				gresaka++;
				sveporuke+="<br>Unos <strong><i>"+svielementi[i].placeholder+"</i></strong> nije evidentiran!";		
				}
			}
		
		}
		
		if(forma=="igra"){
		
			for (var i=0;i<svielementi.length;i++){
				
			if(svielementi[i].id!="videolink"){
				
				if(svielementi[i].value==""){
				gresaka++;
				sveporuke+="<br>Unos <strong><i>"+svielementi[i].placeholder+"</i></strong> nije evidentiran!";						
				
				}
				
				if(svielementi[i].id=="datum"){
					var datreg = /^(0[1-9]|[1-2][0-9]|3[0-1])+\.(0[1-9]|1[0-2])+\.[0-9]{4}$/;
					var dat = svielementi[i].value;

					if(datreg.test(dat) == false) {
						  sveporuke+="<br>Pogrešan oblik datuma (mora biti dd.mm.gggg)";
						  gresaka++;
						  }
				}
				
				if(svielementi[i].id=="vrijeme"){
					var vrreg = /^([01][1-9]|2[0-3]|1[0-2]):[0-5][0-9]:[0-5][0-9]$/;
					var vri = svielementi[i].value;
						
					if(vrreg.test(vri) == false) {
						  sveporuke+="<br>Pogrešan oblik vremena (mora hh:mm:ss)";
						  gresaka++;
						  }					
				 }								
			}
				
			}	
		}		
						
		if(gresaka>0){
			document.getElementById("pronadjenegreske").innerHTML=sveporuke;
			return false;
		}		
}
</script>
</head>
<body>
<div id="top">
  <h2><a href="index.php">Početna</a> | <a href="o_autoru.html">O autoru</a></h2>
</div>
<div id="banner">
  <h1> <a href="#">Igre i uzrasti</a></h1>
</div>
<div id="menuh-container">
  <div id="menuh">
  <ul><li><a href="index.php" class="top_parent">Početna</a></li></ul>
  <?php
				switch($aktivni_korisnik_tip){
					
				case 0:
				echo "<ul><li><a href='korisnici.php' class='top_parent'>Korisnici</a></li></ul>";
				break;
				case 1:
				break;	
				case 2:
				echo "<ul><li><a href='popisigara.php?igre=1' class='top_parent'>Igre</a></li></ul>";
				break;
					}				
				?>
				<ul><li><a href="kategorijeuzrasti.php" class="top_parent">Kategorije</a></li></ul>
				<ul><li><a href="o_autoru.html" class="top_parent">O autoru</a></li></ul>
				<?php				
				if(isset($_SESSION['aktivni_korisnik'])){
					echo "<ul><li><a href='odjava.php' class='top_parent'>Odjava</a></li></ul>";
				}
				?>
  </div>
</div>
<div id="container">