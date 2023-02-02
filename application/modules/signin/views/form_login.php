<!DOCTYPE html>
<html lang="en">

<head>
    <title>SIKADE ONLINE</title>
    <!-- meta tags -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- /meta tags -->
    <!-- custom style sheet -->
    <link href="<?php echo base_url('assets/login/css/style.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- /custom style sheet -->
    <!-- fontawesome css -->
    <link href="<?php echo base_url('assets/login/css/fontawesome-all.css'); ?>" rel="stylesheet" />
    <!-- /fontawesome css -->
    <!-- google fonts-->
    <link href="//fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- /google fonts-->

</head>


<body>
    <h1>Sistem Informasi Pelayanan <br> Administrasi Kepala Daerah dan DPRD</h1>

    <div class=" w3l-login-form">
        <h2>Silahkan Login</h2>
        <?php echo $this->session->flashdata('message'); ?>
        <?php echo form_open(site_url('signin/login'), array('class' => 'form-horizontal', 'role' => 'form')); ?>
        <form action="#" method="POST">

            <div class="w3l-form-group">
                <label> <strong>Username </strong> :</label>
                <div class="group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" id="username" value="<?php echo set_value('username'); ?>" class="form-control" placeholder="Username" />
                </div>
            </div>
            <?php echo form_error('username'); ?>
            <div class="w3l-form-group">
                <label> <strong>Password:</strong> </label>
                <div class="group">
                    <i class="fas fa-unlock"></i>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" />
                </div>
            </div>
            <?php echo form_error('password'); ?>
            <?php if (isset($captcha_img)) echo $captcha_img; ?>
            <br>
            <!-- <button type="submit" class="btn btn-primary btn-sm" name="submit" id="submit" value="Login">Login</button>
            <button type="reset">reset</button> -->
            <button type="submit" class="button button1" name="submit" id="submit" value="Login">Login</button>
            <!-- <button class="button button2">Shadow on Hover</button> -->
        </form>
        <!--<p style="text-align: right;">Belum punya akun ? <a href="<?php echo site_url('registrasi') ?>" style="text-decoration: underline;">Registrasi disini</a></p>-->
    </div>
    <footer>
        <p style="text-align:center;color:#000000;"><b><?php echo "Hak Cipta ©" . ((date('Y') == "2020") ? "2020" : "2020 - " . date('Y')) . " " . " Tim IT Dinas Komunikasi dan Informatika Provinsi Sumatera Barat"; ?></b></p>
    </footer>

</body>

</html>