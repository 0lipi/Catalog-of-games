<?php
include("zaglavlje.php");
?>

  <div id="content">
   <h3>Administracija uzrasta</h3> 
<?php


if(isset($_GET['pretplate'])){
	
	$sqlupit = "select 
uzrast.uzrast_id,
  uzrast.naziv,
  count(uzrast.uzrast_id)
from uzrast join pretplata 
  on uzrast.uzrast_id = pretplata.uzrast_id
where pretplata.pretplacen = 1
group by uzrast.uzrast_id";
$ex = SpojNaBazu($sqlupit);
echo "<h1>Broj kategorija po uzrastu:</h1>";
echo '<table border="1">';
echo '<th>ID uzrast</th><th>Naziv uzrast</th><th>Broj preplata</th>';
echo '</tr>';
while(list($id,$naziv,$preplate)=mysqli_fetch_array($ex)){
echo '<tr>';
echo "<td>$id</td><td>$naziv</td><td>$preplate</td>";
echo '</tr>';
}
echo '</table>';	
}


if(isset($_GET['topekspert'])){	
	
	$sqlupit = "SELECT
concat(korisnik.ime,' ',korisnik.prezime),
  count(korisnik.korisnik_id)
from uzrast join igra
  on uzrast.uzrast_id = igra.uzrast_id
  join korisnik
on uzrast.moderator_id = korisnik.korisnik_id
group by korisnik.korisnik_id
order by count(korisnik.korisnik_id) desc limit 10";
$ex = SpojNaBazu($sqlupit);
echo "<h1>Broj postavljenih igara po ekspertu:</h1>";
echo '<table border="1">';
echo '<th>Ekspert</th><th>Broj postavljenih igara</th>';
echo '</tr>';
while(list($naziv,$broj_igara)=mysqli_fetch_array($ex)){
echo '<tr>';
echo "<td>$naziv</td><td>$broj_igara</td>";
echo '</tr>';
}
echo '</table>';	
}

echo "<p><a href='javascript:history.back(-1)'>Vrati se natrag</a></p>";

?>				    
  </div>
  <?php
include("podnozje.php");
?>