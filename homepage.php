<?php
require_once('includes/init.php');
global $session;
if(!$session->signed_in){
    header('Location: index.html');
    exit;
}
$user_id = $session->user_id;
$user = new User();
$user->find_user_by_id($user_id);
echo '<h1>Hello ' . $user->first_name . ' ' . $user->last_name . '</h1>';
echo '<p> You created your account on ' . $user->registration_date;
?>
<html>
    <head>
        <script>
            function logout(){
                window.location = 'logout.php';
            }
        </script>
    </head>
    <body>
        <button onclick="logout()">Logout</button>
    </body>
</html>