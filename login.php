<?php
require_once('includes/init.php');
global $session;
$error = "";
if($_POST){
    $user_id = $_POST['user'];
    $password = $_POST['password'];
    $user = new User();
    $error = $user->find_user_by_id_password($user_id, $password);
    if(!$error){
        $session->login($user);
        header('Location: Q3.php');
    }
}
?>

<html>
    <head>

    </head>
    <body>
        <p id="error-login"><?php echo $error ?></p>
        <form method="post">
            <fieldset>
                <legend>Login</legend>
                <p><label>User: <input type="text" name="user"></label></p>
                <p><label>Password: <input type="password" name="password"></label></p>
                <p><input type="submit" value="Login"></p>
            </fieldset>
        </form>
    </body>
</html>