<?php
include("zaglavlje.php");
?>

  <div id="content">

<?php


	$sqlupit="select count(*) from uzrast inner join pretplata on uzrast.uzrast_id = pretplata.uzrast_id where pretplata.korisnik_id=".$_GET["korisnik"];

	$rs = SpojNaBazu($sqlupit);	
	$row = mysqli_fetch_array($rs);
	$broj_redaka = $row[0];
	
	$broj_stranica = ceil($broj_redaka / $vel_str);


echo "<h3>Popis svih kategorija uzrasta za pretplaćenog korisnika ".$_GET["korime"].":";

echo "</h3>";
	$upit = "select uzrast.uzrast_id, uzrast.naziv, uzrast.opis from uzrast inner join pretplata on uzrast.uzrast_id = pretplata.uzrast_id where pretplata.korisnik_id=".$_GET["korisnik"];
	
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
if($aktivni_korisnik_tip==0){
echo '<th>Ažuriranje</th>';	
$kolspan=4;
}
echo '</tr>';
echo '</thead>';
echo '<tbody class="table-hover">';
while(list($id,$naziv,$opis)=mysqli_fetch_array($ex)){
$detalji="<a title='Klikni za detalje' href='kategorijeuzrastidetalji.php?uzrast=$id&naz=$naziv'>$naziv</a>";
$br = Igre($id);
$detalji.=" - ".$br." igara";

if($aktivni_korisnik_tip==0){
	
	$ekspert = "select CONCAT(korisnik.ime,' ',korisnik.prezime) from korisnik join uzrast on korisnik.korisnik_id = uzrast.moderator_id where uzrast.uzrast_id = ".$id;
	$sqlupit = SpojNaBazu($ekspert);
	list($korime)=mysqli_fetch_array($sqlupit);
	$detalji.=" - moderator:  ".$korime;
}	
$azur = "<a href='kategorijeuzrastiadministrator.php?azuriraj=$id'>Ažuriraj</a>";
echo '<tr>';
echo "<td class=\"text-left\">$id</td><td>$detalji</td><td>$opis</td>";
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
			echo " <a href=\"korisniciuzrasti.php?";
			if(isset($_GET["korisnik"])){
				echo "korisnik=".$_GET["korisnik"]."&korime=".$_GET["korime"]."&";
			}
			echo "stranica=" .$i. "\">$str</a>";
		}
echo "</td>";
echo '</tr>';
echo '</tbody>';
echo '</table>';	


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
echo "<p><a href='javascript:history.back(-1)'>Vrati se natrag</a></p>";
?>
  </div>
  <?php
include("podnozje.php");
?>