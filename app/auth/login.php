<?php
function  logInUser(string $email,$pass,PDO $pdo) {
    $sql="SELECT email,password FROM users WHERE Email=? ";
    $stnt=$pdo->prepare($sql);
    $stnt->execute([$email]);
    $user=$stnt->fetch();
    if($user['email']==$email && password_verify($pass,$user['password'])) {
        echo "Success log in";
        session_start();
        $_SESSION["email"]=$user["email"];
    }
}
logInUser($_POST["email"],$_POST["password"],$pdo);