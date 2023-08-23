<?php
include("zaglavlje.php");
?>

  <div id="content">
   <h3>Administracija korisnika</h3> 
<?php

	if(isset($_GET['korisnik']) || isset($_GET['dodaj'])) {
	
		if(isset($_GET['korisnik'])){
		$id = $_GET['korisnik'];
		if ($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==2) {
			$id = $_SESSION["aktivni_korisnik_id"]; 
		}
		$upit = "SELECT * FROM korisnik WHERE korisnik_id='$id'";
		
		$conn = SpojNaBazu($upit);
		list($id, $tip, $kor_ime,$lozinka,$ime,$prezime,$email, $slika) = 
		mysqli_fetch_array($conn);
		
		
	} else {
		$kor_ime = "";
		$ime = "";
		$tip = 2;
		$prezime = "";
		$lozinka = "";
		$email = "";
		$slika = "";
	}

	?>

  <h2>Registracija korisnika</h2>
		<form method="post" id="korisnik" action="korisnik.php" enctype="multipart/form-data"  onsubmit="return Provjera(this.id)">
			<input type="hidden" name="novi" id="novi" value="<?php echo $id?>"/>
			<input type="hidden" name="photo" id="photo" value="<?php echo $slika?>"/>		
			<table>
				<tr>
					<td><label for="kor_ime">Korisničko ime:</label></td>
					<td><input type="text" name="kor_ime" id="kor_ime" placeholder="Korisničko ime" 
						<?php 
							if (isset($id)) {
								echo "readonly='readonly'";
							}	
						?>
						value="<?php echo $kor_ime?>"/></td>
				</tr>
				
				<tr>
					<td><label for="ime">Ime:</label></td>
					<td><input type="text" name="ime" id="ime" value="<?php echo $ime?>" placeholder="Ime"/></td>
				</tr>
				
				<tr>
					<td><label for="prezime">Prezime:</label></td>
					<td><input type="text" name="prezime" id="prezime" value="<?php echo $prezime?>" placeholder="Prezime"/></td>
				</tr>
				
				<tr>
					<td><label for="lozinka" >Lozinka:</label></td>
					<td><input type="text" name="lozinka" id="lozinka" value="<?php echo $lozinka?>" placeholder="Lozinka"/></td>
				</tr>
				
				<?php 
					if($_SESSION['aktivni_korisnik_tip'] == 0) {
						?>
							<tr>
								<td>Tip korisnika:</td>
								<td><select name="tip" id="tip">
									<option value="odb">Odaberite:</option>
									<option value="0" <?php if ($tip == 0) echo "selected='selected'";?>>Administrator</option>
									<option value="1" <?php if ($tip == 1) echo "selected='selected'";?>>Moderator</option>
									<option value="2" <?php if ($tip == 2) echo "selected='selected'";?>>Registrirani korisnik</option>
								</select></td>
							</tr>
						<?php
					}
					?>
				<tr>
					<td><label for="email">email:</label></td>
					<td><input type="text" name="email" id="email" value="<?php echo $email?>" placeholder="E-mail"/></td>
				</tr>
				
				<tr>
					<td><label for="slika">Slika:</label></td>
					<td><input type="file" name="slika" id="slika"/></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" value="Pošalji"/></td>
				</tr>
				<tr>
					<td colspan="2">
					<div id="pronadjenegreske"></div>
					</td>
				</tr>
			</table>
		</form>		
		<label id="poruka"></label>
<?php

}

if(isset($_POST['kor_ime'])) {
		if (isset($_POST['tip'])) {
			$tip = $_POST['tip'];
		} else  {
			$tip = 2;
		}	
		$kor_ime = $_POST['kor_ime'];
		$ime = $_POST['ime'];
		$prezime = $_POST['prezime'];
		$lozinka = $_POST['lozinka'];
		$email = $_POST['email'];
		
		
		$postojeca = $_POST['photo'];
		
		$mjesto = "korisnici/";	

		$ime_dat = basename($_FILES['slika']['name']);
	
		
		if(file_exists($mjesto.$ime_dat)){
			unlink($mjesto.$ime_dat);
		}
		
		if(!file_exists($mjesto.$ime_dat)){
			
			$slika = $mjesto.$ime_dat;	
			$stavi = move_uploaded_file($_FILES['slika']['tmp_name'],$slika);
		}
		else
		{

				if($postojeca != ""){
					$slika = $postojeca;
				}
				else
				{
					$slika = "korisnici/nophoto.jpg";
				}
				
		}
		
		$id = $_POST['novi'];
		
		if ($id == 0) {
		
			$upit = "INSERT INTO korisnik 
			(tip_id, korisnicko_ime, lozinka, ime, prezime, email, slika)
			VALUES
			($tip, '$kor_ime', '$lozinka', '$ime', '$prezime', '$email', '$slika');
			";
		} else {
			$upit = "UPDATE korisnik SET 				 
				ime='$ime',
				prezime='$prezime',
				lozinka='$lozinka',
				tip_id = '$tip',
				email = '$email',
				slika = '$slika'
				WHERE korisnik_id = '$id'
			";
		}		
		$conn = SpojNaBazu($upit);

		header("Location: korisnici.php");		
					
	}

?>				    
  </div>
  <?php
include("podnozje.php");
?>