<?php
if(isset($_POST["login"])) {
	if(!empty($_POST["rememberme"])) {
        $cookie_name = "remember_me";
        $cookie_value = "90 days";
        setcookie($cookie_name, $cookie_value, time() + (86400 * 90), "/");
        header("Location: .");
    }		
}
?>