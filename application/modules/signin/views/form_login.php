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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        th,
        td {
            padding: 5px;
            font-size: 14px;
            font-family: Segoe UI, Tahoma, Geneva, Verdana, 'sans-serif';
        }

        h3 {
            color: #fc3955;
            font-weight: bold;
        }
    </style>

</head>


<body>
    <h3 class="text-center font-weight-bold">Sistem Informasi Pelayanan <br> Administrasi Kepala Daerah dan DPRD</h3>

    <div class=" w3l-login-form">
        <h2 class="text-center font-weight-bold" style="color: white;">Silahkan Login</h2>
        <?php echo $this->session->flashdata('message'); ?>
        <?php echo form_open(site_url('signin/login'), array('class' => 'form-horizontal', 'role' => 'form')); ?>
        <form action="#" method="POST">
            <div class="w3l-form-group">
                <label> <strong>Username </strong> :</label>
                <div class="group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" id="username" value="<?php echo set_value('username'); ?>" class="form-control" placeholder="Masukan username..." />
                </div>
            </div>
            <?php echo form_error('username'); ?>
            <div class="w3l-form-group">
                <label> <strong>Password:</strong> </label>
                <div class="group">
                    <i class="fas fa-unlock"></i>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukan password..." />
                </div>
            </div>
            <?php echo form_error('password'); ?>
            <?php if (isset($captcha_img)) echo $captcha_img; ?>
            <!-- <br> -->
            <!-- <button type="submit" class="btn btn-primary btn-sm" name="submit" id="submit" value="Login">Login</button>
            <button type="reset">reset</button> -->
            <center>
                <button type="submit" class="button button1" style="font-size: 16px;" name="submit" id="submit" value="Login">LOGIN</button>
            </center>
            <!-- <button class="button button2">Shadow on Hover</button> -->
        </form>
        <br>
        <br>
        <a class="button-bantuan" data-toggle="collapse" href="#informasi-penting" role="button" aria-expanded="false" aria-controls="informasi-penting">
            <i class="fas fa-info"></i>&nbsp; Informasi Penting !!
        </a>
        <div class="collapse pt-3" id="informasi-penting">
            <div class="card" style="background-color: white;padding-left: 10px;border-radius: 5px;padding-top: 1px;padding-bottom: 1px;border-color: #fc3955 !important;">
                <div class="card-body">
                    <table width="100%" class="table-responsive">
                        <tr>
                            <td width="30%" style="font-weight: bold;">Manual Book</td>
                            <td style="font-weight: bold;">:</td>
                            <td><a href="<?= site_url('upload/MANUAL-SIKADE.pdf'); ?>" target="_blank" style="text-decoration: underline;color: #000000;"> <i>Download Disini</i> </a></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Contak Admin</td>
                            <td style="font-weight: bold;">:</td>
                            <td>085375158892</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Email Pengaduan</td>
                            <td style="font-weight: bold;">:</td>
                            <td>biro.pemerintahanotda@sumbarprov.go.id</td>
                        </tr>
                        <tr style="vertical-align: top;">
                            <td style="font-weight: bold;">Alamat</td>
                            <td style="font-weight: bold;">:</td>
                            <td>Biro Pemerintahan dan Otonomi Daerah Kantor Gubernur Sumatera Barat Escape Building lantai 2 jl. Sudirman 51 Padang Sumatera Barat</td>
                        </tr>
                    </table>
                    <!-- <p style="text-align: left; color: black;font-size: 14px;"><b>Manual Book</b> : <a href="<?php echo site_url('registrasi') ?>" style="text-decoration: underline;color: #000000;"> <i>Download Disini</i> </a></p>
                <p style="text-align: left; color: black;font-size: 14px;"><b>Alamat</b> : <a href="#" style="color: #000000;"> <i>Biro Pemerintahan dan Otonomi Daerah Kantor Gubernur Sumatera Barat Escape Building lantai 2 jl. Sudirman 51 Padang Sumatera Barat</i> </a></p> -->
                </div>
            </div>
        </div>

    </div>
    <footer>
        <p style="text-align:center;color:#000000;"><b><?php echo "Hak Cipta ©" . ((date('Y') == "2020") ? "2020" : "2020 - " . date('Y')) . " " . " Tim IT Dinas Komunikasi dan Informatika Provinsi Sumatera Barat"; ?></b></p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>