<?php
include("zaglavlje.php");
?>

  <div id="content">
   <h3>Igra</h3> 
<?php

if(isset($_GET['odjava'])){


$uzrodjava = $_GET['odjava'];

$sqlupit = "update pretplata set pretplacen = 0 where uzrast_id = '$uzrodjava' and korisnik_id='$aktivni_korisnik_id'";

$ex = SpojNaBazu($sqlupit);

header("Location: kategorijeuzrasti.php");

}	

if(isset($_GET['pretplata'])){


$uzpretplata = $_GET['pretplata'];

$ima = "select * from pretplata where uzrast_id = ".$uzpretplata." and korisnik_id = ".$aktivni_korisnik_id;
$rs = SpojNaBazu($ima);
$redovi = mysqli_num_rows($rs);

list($korid,$uzrid,$prep)=mysqli_fetch_array($rs);

if($redovi == 0){
	
$sqlupit = "insert into pretplata values ('$aktivni_korisnik_id','$uzpretplata',1)";	
}
else
{
$sqlupit = "update pretplata set pretplacen = 1 where uzrast_id = ".$uzpretplata." and korisnik_id = ".$aktivni_korisnik_id;
}



$ex = SpojNaBazu($sqlupit);

header("Location: kategorijeuzrasti.php");

}


if(isset($_GET['pretplata2'])){


$pretplata2 = $_GET['pretplata2'];

$sqlupit = "update pretplata set pretplacen = 1 where uzrast_id = '$pretplata2' and korisnik_id='$aktivni_korisnik_id'";

$ex = SpojNaBazu($sqlupit);

header("Location: ".$_SESSION['url']);

}


if(isset($_GET['detalji'])){


$igra = $_GET['detalji'];

$sqlupit = "select naziv, opis, slika, video from igra where igra_id = '$igra'";

$ex = SpojNaBazu($sqlupit);

list($naziv,$opis,$slika,$video)=mysqli_fetch_array($ex);
if($video!=""){
$video_ogg = str_replace(".mp4",".ogg",$video);
}
else
{
$video_ogg="";	
}
echo "<br><strong>Naziv:</strong> ".$naziv;
echo "<br><strong>Opis:</strong> ".$opis;
echo "<br><strong>Slika:</strong> <img src='$slika' width='640px' height='480px'>";
echo "<br><strong>Video:</strong> ";
	if($video!=""){
	echo "<video width='640' height='480' controls>";
	echo "<source src='$video' type='video/mp4'>";
	echo "<source src='$video_ogg' type='video/ogg'>";
	echo "</video>";
	}
}
?>				    
  </div>
  <?php
include("podnozje.php");
?>