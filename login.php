<?php
require_once('includes/init.php');
global $session;
$error = "";
if($_POST){
    $user_id = $_POST['user'];
    $password = $_POST['password'];
    $enc_password = md5(md5($user_id) . $password);
    $user = new User();
    $error = $user->find_user_by_id_password($user_id, $enc_password);
    if(!$error){
        $session->login($user);
        header('Location: index.php');
    }
}
?>

<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="login-container">
            <h1 class="login-title">Login</h1>
            <div class="cred-title">Enter your credentials</div>
            <form method="post" class="login-form">
                <p><input placeholder="Username" type="text" name="user"></p>
                <p><input placeholder="Password" type="password" name="password"></p>
                <p><input id="btn-login" type="submit" value="Login"></p>
                <p id="error-login"><?php echo $error ?></p>
                <p style="text-align: center">Don't have a user? <a style="font-weight: 600;" href="signup.html">Create user</a></p>
            </form>
        </div>

    </body>
</html>