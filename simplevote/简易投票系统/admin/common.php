<?php
	@session_start();
	if( !isset($_SESSION['admin']) ||  $_SESSION['admin']!== true ){
		echo "<meta http-equiv=\"Refresh\" content=\"0;url=login.html\">";
		exit();
	}
?>