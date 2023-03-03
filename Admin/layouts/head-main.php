<?php
// include language configuration file based on selected language
$lang = "es";
if (isset($_GET['lang'])) {
   $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
}
if( isset( $_SESSION['lang'] ) ) {
    $lang = $_SESSION['lang'];
}else {
    $lang = "es";
}
require_once ("./assets/lang/" . $lang . ".php");

?>
<?php include ('./controller/get-user-info.php');?>
<!DOCTYPE html>
<html lang="<?php echo $lang ?>">