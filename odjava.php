<?php

if(session_status()==PHP_SESSION_NONE){
session_start();	
}

		if(isset($_SESSION['aktivni_korisnik'])){
			
		
		session_destroy();
		
		}
		header("Location: index.php");

?>