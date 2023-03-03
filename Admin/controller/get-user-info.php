<?php
if ($userid <> '') {
    $sql="SELECT * FROM users WHERE id = $userid";
    $result=mysql_query($sql);
    while ($row = mysql_fetch_assoc($result)) {
        $useremail = $row['useremail'];
        $username = $row['username'];
        $password_user = $row['password'];
        $fullname = "{$row['firstname']} {$row['lastname']}";
        $category = $row['category'];
    }

    $sql="UPDATE users SET lastlogin = NOW() WHERE user_id ='{$_GET[userid]}'";
    $result=mysql_query($sql);


    $administrador = 1;
    if ($category == 1) {
        $administrador = 1;
    }
}

?>
