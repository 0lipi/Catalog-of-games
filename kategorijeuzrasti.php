<?php
include("zaglavlje.php");
?>

  <div id="content">
   <h3>Kategorije</h3> 
<?php

$sqlupit = "SELECT count(*) FROM uzrast";

	if(isset($_GET['ekspert']) && $aktivni_korisnik_tip==1){
	$sqlupit.=" where moderator_id=".$aktivni_korisnik_id;
	}

	$rs = SpojNaBazu($sqlupit);	
	$row = mysqli_fetch_array($rs);
	$broj_redaka = $row[0];
	
	$broj_stranica = ceil($broj_redaka / $vel_str);


echo "<h1>Popis svih kategorija uzrasta";
	if(isset($_GET['ekspert']) && $aktivni_korisnik_tip==1){
	echo " - gdje ste vi moderator";
	}
echo "</h1>";
	$upit = "select uzrast_id, naziv, opis from uzrast";
	
	if(isset($_GET['ekspert']) && $aktivni_korisnik_tip==1){
	$upit.=" where moderator_id=".$aktivni_korisnik_id;
	}
	
	$upit.= " LIMIT " . $vel_str;
	
	if (isset($_GET['stranica'])){

		$upit = $upit . " OFFSET " . (($_GET['stranica'] - 1) * $vel_str); // objasni znacenje if funkcije i kak se cita....
		$aktivna = $_GET['stranica'];
	} else {
		$aktivna = 1;
	}

$ex = SpojNaBazu($upit);

$kolspan=3;
echo '<table class="table-fill">';
echo '<thead>';
echo '<tr>';
echo '<th class="text-left">ID uzrast</th><th>Naziv uzrast</th><th>Opis</th>';
if($aktivni_korisnik_tip!=-1){
echo '<th>Mogućnosti</th>';	
$kolspan=4;
}
if($aktivni_korisnik_tip==0){
echo '<th>Ažuriranje</th>';	
$kolspan=5;
}
echo '</tr>';
echo '</thead>';
echo '<tbody class="table-hover">';
while(list($id,$naziv,$opis)=mysqli_fetch_array($ex)){
$detalji="<a title='Klikni za detalje' href='kategorijeuzrastidetalji.php?uzrast=$id&naz=$naziv'>$naziv</a>";
$br = Igre($id);
$detalji.=" - ".$br." igara";
$odjava = "<a href='pretplataigra.php?odjava=$id'>Odjava</a>";
$pretplata = "<a href='pretplataigra.php?pretplata=$id'>Pretplata</a>";
if($aktivni_korisnik_tip==0){
	
	$ekspert = "select CONCAT(korisnik.ime,' ',korisnik.prezime) from korisnik join uzrast on korisnik.korisnik_id = uzrast.moderator_id where uzrast.uzrast_id = ".$id;
	$sqlupit = SpojNaBazu($ekspert);
	list($korime)=mysqli_fetch_array($sqlupit);
	$detalji.=" - moderator:  ".$korime;
}	
$azur = "<a href='kategorijeuzrastiadministrator.php?azuriraj=$id'>Ažuriraj</a>";
echo '<tr>';
echo "<td class=\"text-left\">$id</td><td>$detalji</td><td>$opis</td>";
echo "<td>";
	if($aktivni_korisnik_tip!=-1){
		if(PostojiKorisnikPretplata($id,$aktivni_korisnik_id)==1)
		{
			echo $odjava;
		}
		else {
			echo $pretplata;
			if(PostojiKorisnikPretplata($id,$aktivni_korisnik_id)==2){
				echo " - pretplatite se po prvi put!";
			}
		}

	}
echo "</td>";
if($aktivni_korisnik_tip==0){
echo "<td>$azur</td>";
}	

echo '</tr>';
}
echo "<tr>";
echo "<td colspan='$kolspan' class='last'>";  
echo "Stranice: ";
		for ($i = 1; $i <= $broj_stranica; $i++) {
			if($i==$aktivna){
				$str = "<strong>$i</strong>";
			}
			else
			{
				$str=$i;
			}
			echo " <a href=\"kategorijeuzrasti.php?stranica=" .$i. "\">$str</a>";
		}
echo "</td>";
echo '</tr>';
echo '</tbody>';
echo '</table>';	

if($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==0){
	echo "<p><a href='azurigra.php?nova=1'>Dodaj novu igru</a></p>";
}
if($aktivni_korisnik_tip==0){
	echo "<p><a href='kategorijeuzrastiadministrator.php?nova=1'>Dodaj novu kategoriju uzrasta</a></p>";
	echo "<p><a href='mogucnostiadmin.php?pretplate=1'>Broj preplata po uzrastu</a></p>";
	echo "<p><a href='mogucnostiadmin.php?topekspert=1'>Broj postavljenih igara po ekspertu</a></p>";
}


function Igre($iduzr){
	
	$sqlupit = "select * from igra where uzrast_id = '$iduzr'";
	$ex = SpojNaBazu($sqlupit);
	
	if(mysqli_num_rows($ex)>0){
		
		$broj = mysqli_num_rows($ex);
		}
		else
		{
			$broj=0;
		}

	
	return $broj;
}


function PostojiKorisnikPretplata($iduzr,$idkor){
	
	$sqlupit = "select * from pretplata where korisnik_id = '$idkor' and uzrast_id='$iduzr'";
	$ex = SpojNaBazu($sqlupit);
	
	if(mysqli_num_rows($ex)>0){
		
		list($kor,$igra,$pretp)=mysqli_fetch_array($ex);
		if($pretp==0){
			$ind=0;
		}
		else
		{
			$ind=1;
		}
	}
	else
	{
		$ind=2;
	}
	
	return $ind;
}

?>
  </div>
  <?php
include("podnozje.php");
?>