<!DOCTYPE html>
<html lang="en">

<head>
    <title>SIKADE ONLINE</title>
    <!-- meta tags -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- /meta tags -->
    <!-- custom style sheet -->
    <link href="<?php echo base_url('assets/login/css/style_registrasi.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- /custom style sheet -->
    <!-- fontawesome css -->
    <link href="<?php echo base_url('assets/login/css/fontawesome-all.css'); ?>" rel="stylesheet" />

    <!-- /fontawesome css -->
    <!-- google fonts-->
    <link href="//fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- /google fonts-->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->

    <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/favicon.ico') ?>" sizes="32x32">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/styles.css?=121'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/demo/variations/header-blue.css'); ?>" />
    <link href='<?php echo base_url('assets/demo/variations/default.css'); ?>' rel='stylesheet' type='text/css' media='all' id='styleswitcher'>
    <link rel="stylesheet" href="<?php echo base_url('assets/demo/variations/sidebar-steel.css'); ?>" />
    <link href='<?php echo base_url('assets/demo/variations/default.css'); ?>' rel='stylesheet' type='text/css' media='all' id='headerswitcher'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600" />
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/form-markdown/css/bootstrap-markdown.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datatables/css/dataTables.bootstrap.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/codeprettifier/prettify.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/form-select2/select2.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/form-multiselect/css/multi-select.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/icheck/skins/all.css'); ?>" />
    <link rel='stylesheet' href="<?php echo base_url('assets/js/jqueryui.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/tree-table/css/jquery.treetable.cs'); ?>s" />
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/tree-table/css/jquery.treetable.theme.default.css'); ?>" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/waitme/waitMe.css'); ?>" />

    <link rel='stylesheet' type='text/css' href='<?php echo base_url('assets/plugins/form-fseditor/fseditor.css'); ?>' />
    <link rel='stylesheet' type='text/css' href='<?php echo base_url('assets/plugins/form-tokenfield/bootstrap-tokenfield.css'); ?>' />
    <link rel='stylesheet' type='text/css' href='<?php echo base_url('assets/plugins/form-toggle/toggles.css'); ?>' />


</head>
<style>
    .error {
        background-color: white;
        /* text-align: center; */
        padding-left: 200px;
    }
</style>

<body>
    <script type='text/javascript' src='<?php echo base_url('assets/js/jquery-1.10.2.min.js'); ?>'></script>
    <h1 style="color: #fc3955;text-align: center;font-size: 30px;">Sistem Informasi<br>Pelayanan Administrasi Kepala Daerah dan DPRD</h1>

    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-body">

                <h3 style="color: blank; font-family: fantasy;"> Registrasi Operator</h3>
                <div class="tab-content">
                    <div class="panel panel-inverse">
                        <?php echo $this->session->flashdata('message'); ?>
                        <div id="errEntry"></div>
                        <div class="panel-heading"><i class="fa fa-user"></i> Silahkan Isi Data Pada Registrasi Form Berikut</div>
                        <?php echo form_open_multipart(site_url('registrasi/create'), array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'formEntry')); ?>
                        <div class="panel-body">
                            <div class="form-group required">
                                <label for="namaLengkap" class="col-sm-3 control-label">
                                    <font color="#000000">Nama Lengkap</font>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control tooltips" name="namaLengkap" id="namaLengkap" placeholder="Nama Lengkap" value="<?php echo set_value('namaLengkap'); ?>" data-trigger="hover" data-original-title="Nama Lengkap yang akan digunakan">
                                    <div class="help-block"></div>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="namaLengkap" class="col-sm-3 control-label">
                                    <font color="#000000">Tempat / Tgl Lahir</font>
                                </label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="tempatLahir" name="tempatLahir" value="<?php echo $this->input->post('tempatLahir', TRUE); ?>">
                                </div>
                                <div class="col-sm-3">
                                    <input type="date" class="form-control" id="tanggalLahir" name="tanggalLahir" value="<?php echo $this->input->post('tanggalLahir', TRUE); ?>">
                                </div>
                                <div class="help-block"></div>
                                <div class="help-block"></div>
                            </div>
                            <div class="form-group required">
                                <label for="namaLengkap" class="col-sm-3 control-label">
                                    <font color="#000000">Jenis Kelamin</font>
                                </label>
                                <div class="col-sm-6">
                                    <select name="jenisKelamin" id="jenisKelamin" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <div class="help-block"></div>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="alamat" class="col-sm-3 control-label">
                                    <font color="#000000">Alamat Anda</font>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control tooltips" name="alamat" id="alamat" placeholder="Alamat Anda" value="<?php echo set_value('alamat'); ?>" data-trigger="hover" data-original-title="Alamat Anda">
                                    <div class="help-block"></div>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="username" class="col-sm-3 control-label">
                                    <font color="#000000">Username</font>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control tooltips" name="username" id="username" placeholder="Username" value="<?php echo set_value('username'); ?>" data-trigger="hover" data-original-title="Username yang akan digunakan">
                                    <div class="help-block"></div>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="password" class="col-sm-3 control-label">
                                    <font color="#000000">Password</font>
                                </label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control tooltips" name="password" id="password" placeholder="Password" value="<?php echo set_value('password'); ?>" data-trigger="hover" data-original-title="Password">
                                    <div class="help-block"></div>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="conf_password" class="col-sm-3 control-label">
                                    <font color="#000000">Konfirmasi Password</font>
                                </label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control tooltips" name="conf_password" id="conf_password" placeholder="Konfirmasi Password" value="<?php echo set_value('conf_password'); ?>" data-trigger="hover" data-original-title="Konfirmasi Password">
                                    <div class="help-block"></div>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="email" class="col-sm-3 control-label">
                                    <font color="#000000">Email</font>
                                </label>
                                <div class="col-sm-6">
                                    <input type="email" class="form-control tooltips" name="email" id="email" placeholder="Email" value="<?php echo set_value('email'); ?>" data-trigger="hover" data-original-title="Email yang akan digunakan">
                                    <div class="help-block"></div>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="noHandphone" class="col-sm-3 control-label">
                                    <font color="#000000">No Handphone</font>
                                </label>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control tooltips" name="noHandphone" id="noHandphone" placeholder="No Handphone" value="<?php echo set_value('noHandphone'); ?>" data-trigger="hover" data-original-title="No Handphone yang akan digunakan">
                                    <div class="help-block"></div>
                                </div>
                            </div>

                            <div class="form-group required">
                                <label class="col-sm-3 control-label">
                                    <font color="#000000">Scan Asli Identitas</font>
                                </label>
                                <div class="col-sm-6">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="input-group">
                                            <div class="form-control uneditable-input" data-trigger="fileinput">
                                                <i class="fa fa-file fileinput-exists"></i>&nbsp;<span class="fileinput-filename"></span>
                                            </div>
                                            <span class="input-group-addon btn btn-green btn-file">
                                                <span class="fileinput-new">Pilih file</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="scanId" id="scanId" value="<?php echo $this->input->post('scanId', TRUE); ?>">
                                            </span>
                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                    </div>
                                    <span style="font-size: 14px;"> <i>KTP-el untuk WNI | Paspor untuk WNA | Kartu Pegawai untuk Internal Kemendagri</i> </span>
                                    <div class="help-block"></div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-sm-6 col-sm-offset-3">
                                        <div class="btn-toolbar">
                                            <button class="btn-success btn" type="submit" name="save" id="save"><i class="fa fa-check"></i> Simpan Data</button>
                                            <a href="javascript:history.back()" class="btn-warning btn"><i class="fa fa-times"></i> Batal Simpan</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
                <p style="text-align: right;">Sudah punya akun ? <a href="<?php echo site_url('signin/login') ?>" style="text-decoration: underline;">Login disini</a></p>
            </div>
            <footer>
                <p style="text-align:center;color:#000000;"><b><?php echo "Hak Cipta ©" . ((date('Y') == "2020") ? "2020" : "2020 - " . date('Y')) . " " . " Tim IT Dinas Komunikasi dan Informatika Provinsi Sumatera Barat"; ?></b></p>
            </footer>
        </div>

    </div>

    <script src="<?php echo base_url('assets/plugins/form-validation/jquery.validate.js') ?>"></script>
    <script type='text/javascript' src='<?php echo base_url('assets/js/jquery-1.10.2.min.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/plugins/form-validator/js/jquery.form-validator.min.js'); ?>'></script>

    <script type='text/javascript' src='<?php echo base_url('assets/js/jqueryui-1.10.3.min.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/js/bootstrap.min.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/js/enquire.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/js/jquery.cookie.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/js/jquery.nicescroll.min.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/plugins/codeprettifier/prettify.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/plugins/datatables/js/jquery.dataTables.min.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/plugins/datatables/js/dataTables.bootstrap.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/plugins/form-datepicker/js/bootstrap-datepicker.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/plugins/form-select2/select2.min.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/plugins/form-multiselect/js/jquery.multi-select.min.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/plugins/form-inputmask/jquery.inputmask.bundle.min.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/plugins/bootbox/bootbox.min.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/plugins/icheck/icheck.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/plugins/tree-table/jquery.treetable.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/plugins/waitme/waitMe.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/js/placeholdr.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/js/application.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/js/table-application.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/js/jquery-app.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/plugins/form-toggle/toggle.min.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/plugins/form-stepy/jquery.stepy.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/plugins/form-jasnyupload/fileinput.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/plugins/pulsate/jQuery.pulsate.min.js'); ?>'></script>
    <script type='text/javascript' src='<?php echo base_url('assets/demo/demo-alerts.js'); ?>'></script>



    <script>
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var site = '<?php echo site_url(); ?>';

        function formReset() {
            $('#formEntry').attr('action', site + 'registrasi/create');
            $('#errEntry').html('');
            $('form#formEntry').trigger('reset');
            $('.help-block').text('');

            // $('#formEntry').trigger("reset");
            $('.required').removeClass('has-error');
            // $('.fileinput-filename').text('');
            // $('.fileinput').removeClass('fileinput-exists');
            // $('.fileinput').addClass('fileinput-new');

        }


        $('#formEntry').submit(function(e) {
            e.preventDefault();
            // var postData = $(this).serialize();
            var form = $('#formEntry')[0];
            // console.log(form);
            // get form action url
            var formActionURL = $(this).attr("action");
            $("#save").html('<i class="fa fa-hourglass-half"></i> Diproses...');
            $("#save").addClass('disabled');
            bootbox.dialog({
                title: "Konfirmasi",
                message: "Apakah anda ingin menyimpan data sektor usaha ini ?",
                buttons: {
                    "cancel": {
                        "label": "<i class='fa fa-times'></i> Tidak",
                        "className": "btn-danger",
                        callback: function(response) {
                            if (response) {
                                $("#save").html('<i class="fa fa-check"></i> Simpan Data');
                                $("#save").removeClass('disabled');
                            }
                        }
                    },
                    "main": {
                        "label": "<i class='fa fa-check'></i> Ya, Lanjutkan",
                        "className": "btn-primary",
                        callback: function(response) {
                            if (response) {
                                $.ajax({
                                    url: formActionURL,
                                    mimeType: "multipart/form-data",
                                    type: "POST",
                                    data: new FormData(form),
                                    dataType: "json",
                                    async: true,
                                    cache: false,
                                    contentType: false,
                                    processData: false
                                }).done(function(data) {
                                    $('input[name="' + csrfName + '"]').val(data.csrfHash);
                                    $('.help-block').text('');
                                    $('.required').removeClass('has-error');
                                    if (data.status == 0) {
                                        $('#errEntry').html('<div class="alert alert-danger" id="pesanErr"><strong>Peringatan!</strong> Tolong dilengkapi form inputan dibawah...</div>');
                                        $.each(data.message, function(key, value) {
                                            if (key != 'isi')
                                                $('input[name="' + key + '"], select[name="' + key + '"]').closest('div.required').addClass('has-error').find('div.help-block').text(value);
                                            else {
                                                $('#pesanErr').html('<strong>Peringatan!</strong> ' + value);
                                            }
                                        });
                                    } else {
                                        // console.log(data)
                                         alert('Registrasi Berhasil, silahkan tunggu aktivasi')
                                        location.reload()
                                        $('#errEntry').html('<div class="alert alert-dismissable alert-success">' +
                                            '<strong>Berhasil Registrasi!</strong> ' + data.message +
                                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                                            '</div>');
                                    }
                                }).fail(function() {
                                    $('#errEntry').html('<div class="alert alert-danger">' +
                                        '<strong>Peringatan!</strong> Harap periksa kembali data yang diinputkan...' +
                                        '</div>');
                                }).always(function() {
                                    $("#save").html('<i class="fa fa-check"></i> Simpan Data');
                                    $("#save").removeClass('disabled');
                                });
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>