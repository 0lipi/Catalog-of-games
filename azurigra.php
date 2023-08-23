<?php
include("zaglavlje.php");
?>

  <div id="content">
   <h3>Administracija igre</h3> 
<?php

if(isset($_GET['nova']) || isset($_GET['azur'])){

if(isset($_GET['azur'])){
	
$id_igra=$_GET['azur'];	

$sqlupit="select * from igra where igra_id=".$id_igra;
$upit = SpojNaBazu($sqlupit);
list($id,$uzrid,$naziv,$opis,$datum,$vrijeme,$slika,$video)=mysqli_fetch_array($upit);
$datum = date("d.m.Y",strtotime($datum));
}
else
{
	$id=0;
	$uzrid="";
	$naziv="";
	$opis="";
	$datum=date("d.m.Y");
	$vrijeme=date("H:i:s");
	$slika="";
	$video="";
}
	
?>

<form method="post" id="igra" action="azurigra.php" enctype="multipart/form-data" onsubmit="return Provjera(this.id)">
			<input type="hidden" name="igraid" value="<?php echo $id; ?>"/>
			
			<table>
			
				<tr>
					<td><label for="kategorija">Kategorija uzrasta:</label></td>
					<td>
					<select name="kategorija" id="kategorija">
					<?php
					$sqlupit="select uzrast_id, naziv from uzrast";
					if($aktivni_korisnik_tip==1){
					$sqlupit.=" where moderator_id = ".$aktivni_korisnik_id;
					}
					$upit=SpojNaBazu($sqlupit);
					while(list($id,$unaziv)=mysqli_fetch_array($upit)){
						echo "<option value='$id'";
						if($id==$uzrid){
							echo " selected";
						}
						echo ">$unaziv</option>";
					}
					?>
					</select>
					</td>				
				</tr>
				<tr>
					<td><label for="naziv">Naziv:</label></td>
					<td><input type="text" name="naziv" id="naziv" value="<?php echo $naziv; ?>" placeholder="Naziv"/></td>					
				</tr>
				
				<tr>
					<td><label for="datum">Datum:</label></td>
					<td><input type="text" name="datum" id="datum" value="<?php echo $datum; ?>" placeholder="Datum"/></td>
				</tr>
				<tr>
					<td><label for="vrijeme">Vrijeme:</label></td>
					<td><input type="text" name="vrijeme" id="vrijeme" value="<?php echo $vrijeme; ?>" placeholder="Vrijeme"/></td>
				</tr>
				<tr>
					<td><label for="opis">Opis:</label></td>
					<td><textarea rows="4" cols="50" name="opis" id="opis" placeholder="Opis"><?php echo $opis; ?></textarea></td>
				</tr>
				<tr>
					<td><label for="slikalink">URL slike:</label></td>
					<td><input type="text" name="slikalink" id="slikalink" value="<?php echo $slika; ?>" size="64" placeholder="URL do slike"/>				
				</tr>
				<tr>
					<td><label for="videolink">URL video:</label></td>
					<td><input type="text" name="videolink" id="videolink" value="<?php echo $video; ?>" size="64" placeholder="Video"/></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="IgraUnos" value="Spremi"/></td>
				</tr>
				<tr>
					<td colspan="2">
					<div id="pronadjenegreske"></div>
					</td>
				</tr>
			</table>
		</form>	

<?php	

}


if(isset($_POST['IgraUnos'])){

	$id=$_POST['igraid'];
	$uzrkat=$_POST['kategorija'];
	$naziv=$_POST['naziv'];
	$naziv = str_replace("'","\'",$naziv);
	$datum=$_POST['datum'];
	$datum=date("Y-m-d",strtotime($datum));
	$vrijeme=$_POST['vrijeme'];
	$opis=$_POST['opis'];
	$opis = str_replace("'","\'",$opis);
	$slika=$_POST['slikalink'];
		
	$video=$_POST['videolink'];
	
	if($id>0){
		
		$sqlupit = "update igra set uzrast_id='$uzrkat', naziv='$naziv',opis='$opis',datum='$datum',vrijeme='$vrijeme',slika='$slika', video='$video' where igra_id=".$id;
	}
	else
	{
		$sqlupit = "insert into igra values ('','$uzrkat','$naziv','$opis','$datum','$vrijeme','$slika','$video')";
	}
	
	$ex = SpojNaBazu($sqlupit);
	
	header("Location: kategorijeuzrasti.php?ekspert=1");
}


?>				    
  </div>
  <?php
include("podnozje.php");
?>