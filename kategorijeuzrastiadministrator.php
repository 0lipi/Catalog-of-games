<?php
include("zaglavlje.php");
?>

  <div id="content">
   <h3>Administracija uzrasta</h3> 
<?php


if(isset($_POST['UzrastUnos'])){
	
	
	$poruka = "";
	
	$id=$_POST['uzrastid'];
	$ekspert=$_POST['ekspert'];
	$naziv=$_POST['naziv'];
	$opis=$_POST['opis'];
	$naziv = str_replace("'","\'",$naziv);
	$opis = str_replace("'","\'",$opis);

	if($id>0){
		
		$sqlupit = "update uzrast set moderator_id='$ekspert', naziv='$naziv', opis='$opis' where uzrast_id=".$id;
	}
	else
	{
		$sqlupit = "insert into uzrast values ('','$ekspert','$naziv','$opis')";
	}
	
	$ex = SpojNaBazu($sqlupit);
	
	header("Location: kategorijeuzrasti.php");
}


if(isset($_GET['nova']) || isset($_GET['azuriraj'])){

if(isset($_GET['azuriraj'])){

$id_uzr=$_GET['azuriraj'];	

$sqlupit="select * from uzrast where uzrast_id=".$id_uzr;
$upit = SpojNaBazu($sqlupit);
list($uzrid,$modid,$naziv,$opis)=mysqli_fetch_array($upit);
}
else

{

	$uzrid=0;
	$modid="";
	$naziv="";
	$opis="";
}
	
?>

<form method="post" action="kategorijeuzrastiadministrator.php" id="kategorija" enctype="multipart/form-data" onsubmit="return Provjera(this.id)">
			<input type="hidden" name="uzrastid" value="<?php echo $uzrid; ?>"/>
			
			<table>
			
				<tr>
					<td><label for="ekspert">Ekspert:</label></td>
					<td>
					<select name="ekspert" id="ekspert">
					<?php
					$sqlupit="select korisnik_id, concat(ime,' ',prezime) from korisnik where tip_id = 1";
					$upit=SpojNaBazu($sqlupit);
					while(list($id,$korisnik)=mysqli_fetch_array($upit)){
						echo "<option value='$id'";
						if($id==$modid){
							echo " selected";
						}
						echo ">$korisnik</option>";
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
					<td><label for="opis">Opis:</label></td>
					<td><textarea rows="4" cols="50" name="opis" id="opis" placeholder="Opis"><?php echo $opis ?></textarea></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="UzrastUnos" value="Unesi"/></td>
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
echo "<p><a href='javascript:history.back(-1)'>Vrati se natrag</a></p>";

?>				    
  </div>
  <?php
include("podnozje.php");
?>