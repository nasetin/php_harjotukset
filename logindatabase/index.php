<?php
    require_once "includes/config_session.inc.php";
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="">
</head>
<body>
    <h3>Login</h3>

    <form action="include/login.inc.php" method="post">
        <input type="text" name ="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <button>Login</button>
    </form>

    <h3>Signup</h3>

    <form action="include/signup.inc.php" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <input type="text" name="email" placeholder="E-mail">
        <button>Signup</button>
    </form>
</body>
</html>