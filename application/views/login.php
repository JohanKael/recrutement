<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    
    <form action="<?php echo base_url("login_controller/login") ?>" method="post">
        <input type="text" name="email" id="" placeholder="E-mail">
        <input type="text" name="password" id="" placeholder="Password">
        <input type="submit" value="Log">
    </form>

</body>
</html>