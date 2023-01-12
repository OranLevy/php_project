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

    </head>
    <body>
        <p id="error-login"><?php echo $error ?></p>
        <form method="post">
            <fieldset>
                <legend>Login</legend>
                <p><label>User: <input type="text" name="user"></label></p>
                <p><label>Password: <input type="password" name="password"></label></p>
                <p><input type="submit" value="Login"></p>
                <p>Don't have a user? <a href="signup.html">Create user</a></p>
            </fieldset>
        </form>
    </body>
</html>