<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?php echo base_url("./assets/css/login.css") ?>">
</head>
<body>
    
    <form action="<?php echo base_url("login_controller/login") ?>" method="post">
        <h2>Recrutement</h2>
        <input type="text" name="email" id="" placeholder="E-mail">
        <input type="password" name="password" id="" placeholder="Password">
        <input type="submit" value="Log">
    </form>

</body>
</html>