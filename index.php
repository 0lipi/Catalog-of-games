<?php
include("zaglavlje.php");

if($aktivni_korisnik_tip==2){
	
	header("Location: popisigara.php?igre=1");
}

if($aktivni_korisnik_tip==1){
	
	header("Location: kategorijeuzrasti.php?ekspert=1");
}

?>

  <div id="content">
    					<h3>Administrator</h3> 
						
						<p align="justify">Administrator unosi, ažurira i pregledava korisnike sustava i definira njihove tipove. Može vidjeti sve preglede koje vidi moderator.  Administrator unosi, ažurira i pregledava kategorije uzrasta (bebe, predškolska djeca, osnovna škola 1-4, srednja škola, …) i dodjeljuje eksperte koji će biti odgovorni za pojedini uzrast (jedan ekspert može biti odgovoran za više uzrasta). Administrator vidi ukupno koliko ima preplata po pojedinom uzrastu i top 10 eksperata koji su postavili najviše igara.</p>
						<h3>Ekspert</h3> 
						<p align="justify">Ekspert ima sve preglede kao registrirani korisnik i uz to može, davati, pregledavati i ažurirati igre za uzraste za koje je on moderator. Prilikom unosa igre mora odabrati uzrast za koji je igra namijenjena (samo iz onih za koje je on odgovoran), mora unijeti naziv i opis igre i unijeti url do slike na webu. Automatski će se kod unosa unijeti trenutni datum i vrijeme. Opcionalno može unijeti url do videa na webu. Ekspert nakon prijave vidi popis svojih kategorija uzrasta i odabirom uzrasta vidi popis igara i popis preplaćenih korisnika.</p>
						<h3>Registrirani korisnik</h3> 
						<p align="justify">Registrirani korisnik, uz poglede koje ima anonimni korisnik. Klikom na uzrast vidi popis igara i mogućnost da se pretplati/odjavi za igre za taj uzrast. Klikom na igru vidi naziv i opis igre sa slikom koja je postavljena, te vidi video ako je on postavljen. Prilikom prijave vidi odmah popis svih igara za uzraste za koje se pretplatio sortirano uzlazno po datumu i vremenu.</p>
						<h3>Neregistrirani korisnik</h3>
						<p align="justify">Neregistrirani korisnik može samo vidjeti popis kategorija uzrasta i klikom na uzrast vidi popis igara sortirano uzlazno  po datumu i vremenu.</p>
  </div>
  <?php
include("podnozje.php");
?>