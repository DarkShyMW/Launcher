<?php
header("Content-Type: text/plain; charset=UTF-8");
 
// Verify login and password
$login = $_GET['login'];
$password = $_GET['password'];
if(empty($login) || empty($password)) {
    exit('Empty login or password');
}
 
// Load IPB init script
$_SERVER['SCRIPT_FILENAME'] = __FILE__;
require_once 'init.php';
 
// Try authenticate
$loginClass = new \IPS\Login;
$member = NULL;
foreach(\IPS\Login::methods() as $method) {
    try {
        $member = $method->authenticateUsernamePassword( $loginClass, $login, $password );
        if (!$member->member_id) {
            $member = NULL;
            continue;
        }
        break;
    } catch (\Exception $e) {
        // Do nothing
    }
}
 
// We're done
echo($member ? 'OK:' . $member->name : 'Incorrect login or password');
?>
