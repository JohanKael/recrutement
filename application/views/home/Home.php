<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $pageTitle; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php $this->load->view('component/styleLink/CssLink')?>
    </head>

    <body> 
        <div class="col-md-12 row">
        <?php $this->load->view('component/navbar/Navbar')?>
            <div class="col-md-10 content">
                <div class="col-md-10 box">
                    <?php $this->load->view($pageToLoad)?>
                </div>
            </div>
        </div>
        <?php $this->load->view('component/styleLink/JsLink')?>
    </body>
</html>
