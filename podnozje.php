     <div id="desni">
   
    <?php
	  if(!isset($_SESSION['aktivni_korisnik'])){
	  ?>
  				<form action="prijava.php" method="POST" id="korisniklogin" onsubmit="return Provjera(this.id)">
					<h4>Korisničko ime: <input type="text" name="korisnik" id="korisnik"  placeholder="Korisničko ime"></h4>
					<h4>Lozinka: <input type="password" name="lozinka" id="lozinka" placeholder="Lozinka"></h4>
					<h4><input type="submit" name="prijava" value="Prijavi se"></h4>
				</form>
				<div id="pronadjenegreske"><?php
					if(isset($_SESSION["informacija"])){
						echo $_SESSION["informacija"];
						unset($_SESSION["informacija"]);
					}
					?></div>
		 <?php
		 }
		 else
	  {
		  echo "<h4>PODACI O KORISNIKU:</h4>";
		  echo "<br><strong>Korisnik:</strong> ".$_SESSION['aktivni_korisnik'];
		  echo "<br><strong>Tip:</strong> ".$_SESSION['aktivni_korisnik_tipime'];
		  echo "<br><strong>Ime i prezime:</strong> ".$_SESSION['aktivni_korisnik_ime'];
		  echo "<br><strong>Slika:</strong> <br><img src='$aktivni_korisnik_slika' width='85px' height='109px'>";
		  echo "<br><strong>Broj pretplata:</strong> ".BrojPretplata($_SESSION['aktivni_korisnik_id']);
	  }
		 ?>
   </div>
</div>
<div id="footer"> Copyright &copy; 2015 Mihael Gašparin | Design by <a href="#"> Mihael Gašparin</a> | FOI 2015 Zabok </div>
</body>
</html>