<?php
include("zaglavlje.php");
?>

  <div id="content">
   <h3>Korisnici</h3> 
<?php

	echo "<h2>Popis svih korisnika</h2>";
	
	
	
	$upit = "SELECT count(*) FROM korisnik";
	
	$conn = SpojNaBazu($upit);		
	$row = mysqli_fetch_array($conn);
	$broj_redaka = $row[0];
	
	$broj_stranica = ceil($broj_redaka / $vel_str);
	
	
	

	$upit = "SELECT * FROM korisnik";

	$upit.=" order by korisnik_id LIMIT " . $vel_str;

		if (isset($_GET['stranica'])){
		$upit = $upit . " OFFSET " . (($_GET['stranica'] - 1) * $vel_str);
		$aktivna = $_GET['stranica'];
	} else {
		$aktivna = 1;
	}
	
	$conn = SpojNaBazu($upit);	
	
	echo "<table>";
	echo "<tr>";
		echo "<th>Korisničko ime</th>";
	echo "<th>Ime</th>";
	echo "<th>Prezime</th>";
	echo "<th>E-mail</th>";
	echo "<th>Lozinka</th>";		 
	echo "<th>Broj pretplata</th>";		 
	echo "<th>Slika</th>";		 
	echo "<th>Akcija</th>";
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
	while(list($id, $tip, $kor_ime,$lozinka,$ime,$prezime,$email, $slika) = 
		mysqli_fetch_array($conn)) {				
		echo "<tr>";
		echo "<td>$kor_ime</td>";
		echo "<td>$ime</td>";		
		echo "<td>$prezime</td>";		
		echo "<td>$email</td>";
		echo "<td>$lozinka</td>";
		echo "<td>".BrojPretplata($id);
		
		if(BrojPretplata($id)>0){
			echo " - <a href='korisniciuzrasti.php?korisnik=$id&korime=$kor_ime'><img src='images/look.png' title='Pogledaj uzraste' width='16px' height='16px'></a>";
		}
		echo "</td>";
		
		echo "<td><img src='$slika' width='90px' height='94px'></td>";
		if ($aktivni_korisnik_tip==0) {
			echo "<td><a href='korisnik.php?korisnik=$id'>Ažuriraj</a></td>";
		}
		echo	"</tr>";
		
	}

	echo "<tr>";
	echo "<td colspan='8' class='last'>Stranice: ";
			if ($aktivna != 1) { 
			$prethodna = $aktivna - 1;
			echo "<a href=\"korisnici.php?stranica=" .$prethodna . "\">&lt;</a>";	
			}
			for ($i = 1; $i <= $broj_stranica; $i++) {
			echo "<a ";
			if ($aktivna == $i) {
				$glavnastr="<mark>$i</mark>";
			}
			else
			{
				$glavnastr = $i;
			}
			echo "' href=\"korisnici.php?stranica=" .$i . "\"> $glavnastr </a>";
			}
			if ($aktivna < $broj_stranica) {
			$sljedeca = $aktivna + 1;
			echo "<a href=\"korisnici.php?stranica=" .$sljedeca . "\">&gt;</a>";	
			}
			echo "</td>";
	echo "</tr>";
		echo "</tbody>";
	echo "</table>";
	
	if ($aktivni_korisnik_tip==0) {
		echo '<a href="korisnik.php?dodaj=1">Dodaj korisnika</a>';
	} else if(isset($_SESSION["aktivni_korisnik_id"])) {
		echo '<a href="korisnik.php?korisnik=' . $_SESSION["aktivni_korisnik_id"] . '">Uredi moje podatke</a>';
	}
	

?>				    
  </div>
  <?php
include("podnozje.php");
?>