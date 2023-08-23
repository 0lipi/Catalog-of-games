<?php
include("spojnabazu.php");

if(session_id() ==""){
	session_start();
}

	if(isset($_POST['prijava'])){

		$korisnik=$_POST['korisnik']; 
		$sifra=$_POST['lozinka'];

		if(!empty($korisnik) && !empty($sifra)){

			
			$query="SELECT 
			korisnik.korisnik_id,korisnik.tip_id,korisnik.korisnicko_ime,korisnik.ime,korisnik.prezime,korisnik.slika,
			tip_korisnika.naziv FROM korisnik inner join tip_korisnika on  korisnik.tip_id = tip_korisnika.tip_id
			WHERE korisnicko_ime='$korisnik' AND lozinka='$sifra'";
			$conn = SpojNaBazu($query);
			$data = mysqli_num_rows($conn);
			if($data>0){
				
				list($idkor,$idtip,$korime,$ime,$prezime,$slika,$nazivtip)=mysqli_fetch_array($conn);
				
				$_SESSION['aktivni_korisnik']=$korime;
				$_SESSION['aktivni_korisnik_ime']=$ime." ".$prezime;
				$_SESSION["aktivni_korisnik_id"]=$idkor;
				$_SESSION['aktivni_korisnik_tip']=$idtip;
				$_SESSION['aktivni_korisnik_slika']=$slika;
				$_SESSION['aktivni_korisnik_tipime']=$nazivtip;
				
			}
			else
			{
				$_SESSION["informacija"]="<strong>Neispravni podaci za prijavu!</strong>";
				header("Location: index.php");
				return false;
			}

		}
		
		header("Location:index.php");
	} 
?>

