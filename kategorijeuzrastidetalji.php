<?php
include("zaglavlje.php");
?>

  <div id="content">
   <h3>Detalji kategorija</h3> 
<?php

if(isset($_GET['uzrast'])){
	$iduzr = $_GET['uzrast'];
	$uzrnaziv = $_GET['naz'];
	
$kolspan='5';
$sqlupit = "SELECT count(*) FROM igra where uzrast_id = ".$iduzr;

	$rs = SpojNaBazu($sqlupit);	
	$row = mysqli_fetch_array($rs);
	$broj_redaka = $row[0];
	
	$broj_stranica = ceil($broj_redaka / $vel_str);


echo "<h1>Popis igara za uzrast ".$uzrnaziv."</h1>";


	$upit = "select * from igra";
	
    $upit.=" where uzrast_id = ".$iduzr;
	
	$upit.= " order by datum asc, vrijeme asc LIMIT " . $vel_str;
	
	if (isset($_GET['stranica'])){

		$upit = $upit . " OFFSET " . (($_GET['stranica'] - 1) * $vel_str); // objasni znacenje if funkcije i kak se cita....
		$aktivna = $_GET['stranica'];
	} else {
		$aktivna = 1;
	}

$ex = SpojNaBazu($upit);

echo '<table>';
echo "<thead>";
echo "<tr>";
echo '<th class=\"text-left\">ID igra</th><th>Naziv</th><th>Opis</th><th>Datum</th><th>Vrijeme</th>';
if($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==0){
echo '<th>Uređivanje</th>';	
echo '<th>Popis pretplatnika</th>';	
$kolspan='7';
}
echo '</tr>';
echo "</thead>";
echo "<tbody>";
while(list($igraid,$uzrastid,$naziv,$opis,$datum,$vrijeme,$slika,$video)=mysqli_fetch_array($ex)){
	$datum = date("d.m.Y",strtotime($datum));
	$opiskratki = substr($opis,0,125)."...";
	$preplata1 = "<a href='pretplataigra.php?pretplata1=$uzrastid'>Pretplata 1. put</a>";
	$preplata2 = "<a href='pretplataigra.php?pretplata2=$uzrastid'>Ponovna pretplata</a>";
	$odjava = "<a href='pretplataigra.php?odjava=$uzrastid'>Odjava</a>";
	$detnaziv = "<a href='pretplataigra.php?detalji=$igraid'>$naziv</a> - detalji";
	$azur = "<a href='azurigra.php?azur=$igraid'>Ažuriraj</a>";
echo '<tr>';
echo "<td>$igraid</td><td>";
if($aktivni_korisnik_tip==2 || $aktivni_korisnik_tip==1){
	echo $detnaziv;
}
else
{
	echo $naziv;
}
echo "</td>";
echo "<td title='$opis'>$opiskratki</td><td>$datum</td><td>$vrijeme</td>";
if($aktivni_korisnik_tip==2){
	$_SESSION['url']=$_SERVER['REQUEST_URI'];
	}
	
	if($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==0){
		echo "<td>$azur</td>";
			$sqlupit2 = "select concat(kor.ime,' ',kor.prezime) from pretplata pr join korisnik kor
  on pr.korisnik_id = kor.korisnik_id where pr.pretplacen = 1 and pr.uzrast_id = ".$uzrastid;
	$prep = SpojNaBazu($sqlupit2);
	
    echo "<td>";
		while(list($korisnik)=mysqli_fetch_array($prep)){
				echo $korisnik.",";
		}
     echo "</td>";
	}
	
	echo '</tr>';
}
echo '<tr>';
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
			echo " <a href=\"kategorijeuzrastidetalji.php?uzrast=".$iduzr."&naz=".$uzrnaziv."&stranica=" .$i. "\">$str</a>";
		}
echo "</td>";
echo '</tr>';
echo "</tbody>";
echo '</table>';
if($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==0){
	echo "<br><a href='azurigra.php?nova=1'>Dodaj novu igru</a>";
}
echo "<br><a href='javascript:history.back(-1)'>Natrag</a>";
}	


?>				    
  </div>
  <?php
include("podnozje.php");
?>