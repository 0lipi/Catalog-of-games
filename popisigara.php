<?php
include("zaglavlje.php");
?>

  <div id="content">
   <h3>Detalji kategorija</h3> 
<?php
 


$sqlupit = "select 
distinct 
pr.uzrast_id,
uz.naziv,
case when ig.naziv is null then 'Nema igre'
else ig.naziv end as 'igra',
case when ig.opis is null then 'Nema igre'
else ig.opis end as 'opis_igra', ig.datum, ig.vrijeme, pr.pretplacen
from uzrast uz join igra ig
on uz.uzrast_id = ig.uzrast_id join pretplata pr 
on pr.uzrast_id = uz.uzrast_id";
if(isset($_GET['igre'])){
$sqlupit.=" where pr.korisnik_id = ".$aktivni_korisnik_id." and pr.pretplacen = 1";
}

$sqlupit.=" order by concat(ig.datum,' ',ig.vrijeme) asc";

	$rs = SpojNaBazu($sqlupit);	
	$row = mysqli_fetch_array($rs);
	$broj_redaka = mysqli_num_rows($rs);
	
	$broj_stranica = ceil($broj_redaka / $vel_str);

$kolspan='6';
if($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==2){
	echo "<h1>Popis igara na koje ste pretplaćeni:</h1>";
}

$upit = "select distinct pr.uzrast_id, uz.naziv, case when ig.naziv is null then 'Nema igre' else ig.naziv end as 'igra',
case when ig.opis is null then 'Nema igre' else ig.opis end as 'opis_igra', ig.datum, ig.vrijeme, pr.pretplacen
from uzrast uz join igra ig
on uz.uzrast_id = ig.uzrast_id join pretplata pr on pr.uzrast_id = uz.uzrast_id";
if(isset($_GET['igre'])){
$upit.=" where pr.korisnik_id =  ".$aktivni_korisnik_id." and pr.pretplacen = 1";
}
$upit.=" order by concat(ig.datum,' ',ig.vrijeme) asc";

	
	$upit.= " LIMIT " . $vel_str;
	
	if (isset($_GET['stranica'])){
		$upit = $upit . " OFFSET " . (($_GET['stranica'] - 1) * $vel_str);
		$aktivna = $_GET['stranica'];
	} else {
		$aktivna = 1;
	}

$ex = SpojNaBazu($upit);

echo '<table border="1">';
echo '<tr>';
echo '<th>ID uzrast</th><th>Naziv uzrast</th><th>Naziv igre</th><th>Opis igre</th><th>Datum</th><th>Vrijeme</th>';


echo '</tr>';
while(list($uzrid,$uzrnaziv,$igranaziv,$igraopis,$datum,$vrijeme,$pretplata)=mysqli_fetch_array($ex)){
	$datum = date("d.m.Y",strtotime($datum));
	
echo '<tr>';
echo "<td>$uzrid</td><td>$uzrnaziv</td><td>$igranaziv</td><td>$igraopis</td><td>$datum</td><td>$vrijeme</td>";


	echo '</tr>';
}
echo "<td colspan='$kolspan'>";  
echo "Stranice: ";
		for ($i = 1; $i <= $broj_stranica; $i++) {
			if($i==$aktivna){
				$str = "<strong>$i</strong>";
			}
			else
			{
				$str=$i;
			}
			echo " <a href=\"popisigara.php?";
			if(isset($_GET['igre'])){
			echo "igre=1";
			}
			echo "&stranica=" .$i. "\">$str</a>";
		}
echo "</td>";
echo '</tr>';
echo '</table>';
echo "<a href='javascript:history.back(-1)'>Natrag</a>";
	

?>				    
  </div>
  <?php
include("podnozje.php");
?>