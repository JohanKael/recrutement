<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?php echo base_url("assets/css/login.css") ?>">
</head>
<body>
    <?php if ($this->session->flashdata('error')): ?>
        <p style="color:red;"><?php echo $this->session->flashdata('error'); ?></p>
    <?php endif; ?>

    <form action="<?php echo site_url('index.php/Login_controller/login'); ?>" method="post">
        <h2>Recrutement</h2>
        <input type="text" name="email" id="" placeholder="E-mail">
        <input type="text" name="password" id="" placeholder="Password">
        <input type="submit" value="Log">
    </form>

</body>
</html>