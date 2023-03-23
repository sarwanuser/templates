<?php
session_start();
@include(app_path("Providers/Functions/User.php"));
@include(app_path('Providers/Functions/Dataprovider.php'));

global $userdatag;

if(isset($userdatag)){
	checkuser($userdatag);
}
?>
