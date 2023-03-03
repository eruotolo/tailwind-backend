<?php
include ('../layouts/config.php');

if (isset($_GET['id'])){

    $id_usuario = $_GET['id'];
    $query = "DELETE FROM users WHERE id = $id_usuario";
    $result = mysqli_query($link,$query);
    if($result){
        header("location: ../apps-contacts-list.php");
    }else{
        echo('Testing');
    }
    $_SESSION['message'] = 'Usuario Eliminado';
    $_SESSION['message_type'] = 'danger';
    session_start();
    header("location: ../apps-contacts-list.php");
}

?>