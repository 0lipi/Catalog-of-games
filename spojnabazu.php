<?php


$dbc = null;
$db = null;
$vel_str = 5;
$vel_str_video = 20;

function SpojNaBazu($sql) {
	
	$BP_server = 'localhost';
	$BP_bazaPodataka = 'iwa_2015_zb_projekt';
	$BP_korisnik = 'iwa_2015';
	$BP_lozinka = 'foi2015';
	global $dbc;
	global $db;

	$dbc = mysqli_connect($BP_server, $BP_korisnik, $BP_lozinka,$BP_bazaPodataka);
	if(mysqli_connect_errno()){
		die("Greška kod spajanja na bazu podataka ".$BP_bazaPodataka.":".mysqli_connect_error());
	}

	mysqli_set_charset($dbc,"utf8");
	
	$rs = mysqli_query($dbc,$sql);
	if(!$rs) {
		die("Greška kod izvršavnaja sljedećeg upita: ".$sql."<br>Opis greške: ".mysqli_error($dbc));
	}
	
	if(is_resource($dbc)){
	mysqli_close($dbc);
	}
	
	return $rs;
	
}


	function BrojPretplata($kor){
		
		$prpl = "select count(*) from pretplata pr where pr.korisnik_id = ".$kor." and pr.pretplacen = 1";
		$rs = SpojNaBazu($prpl);
		
		$ukupno = mysqli_fetch_array($rs);
		
		return $ukupno[0];
	}

?>