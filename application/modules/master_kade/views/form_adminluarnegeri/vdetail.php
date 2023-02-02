<div class="container">
  <div class="panel-heading">

    <h4>Detail Permohonan <u><?= !empty($data_luarnegeri_pend) ? ($data_luarnegeri_pend[0]->nama_lengkap) : ($data_luarnegeri_adm[0]->nama_lengkap) ?> </u> </h4>
  </div>
  <div class="panel panel-info">
    <div class="panel-body collapse in">
      <div class="tab-content">
        <div class="tab-pane active" id="home1">
          <div class="panel panel-info">
            <?php echo $this->session->flashdata('message'); ?>
            <div id="errEntry"></div>
            <div class="panel-heading"><i class="fa fa-bars"></i> Biodata Diri</div>
            <div class="panel-body">
              <div class="col-md-offset-1 col-xs-10">
                <h4 style="text-align:left;font-weight:bold;">Kelengkapan Data Diri</h4><br>
                <div class="row">
                  <div class="form-group required">
                    <label for="nama_lengkap" class="col-sm-3 control-label">
                      <font color="#000000">Nama Lengkap</font>
                    </label>
                    <div class="col-sm-6">
                      <input type="hidden" value="<?= $data_luarnegeri_diri[0]->id_adminluarnegeri ?>" name="id_adminluarnegeri">
                      <input type="text" class="form-control tooltips" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap" value="<?= $data_luarnegeri_diri[0]->nama_lengkap ?>" data-trigger="hover" data-original-title="Nama Lengkap yang akan digunakan" readonly style="background-color:white">
                      <div class="help-block"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group required">
                    <label for="nik" class="col-sm-3 control-label">
                      <font color="#000000">NIK(Nomor KTP Elektronik)</font>
                    </label>
                    <div class="col-sm-6">
                      <input type="number" class="form-control tooltips" name="nik" id="nik" placeholder="NIK(Nomor KTP Elektronik)" value="<?= $data_luarnegeri_diri[0]->nik ?>" data-trigger="hover" data-original-title="NIK(Nomor KTP Elektronik) yang akan digunakan" readonly style="background-color:white">
                      <div class="help-block"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group required">
                    <label for="alamat" class="col-sm-3 control-label">
                      <font color="#000000">Alamat Anda</font>
                    </label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control tooltips" name="alamat" id="alamat" placeholder="Alamat Anda" value="<?= $data_luarnegeri_diri[0]->alamat ?>" data-trigger="hover" data-original-title="Alamat Anda" readonly style="background-color:white">
                      <div class="help-block"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group required">
                    <label for="pemda_lembaga_umum" class="col-sm-3 control-label">
                      <font color="#000000">Pemda/Lembaga/Umum</font>
                    </label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control tooltips" name="pemda_lembaga_umum" id="pemda_lembaga_umum" placeholder="Pemda/Lembaga/Umum" value="<?= $data_luarnegeri_diri[0]->pemda_lembaga_umum ?>" data-trigger="hover" data-original-title="Pemda/Lembaga/Umum" readonly style="background-color:white">
                      <div class="help-block"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-offset-1 col-xs-9">
                  <h4 style="text-align:left;font-weight:bold;">Kelengkapan KTP</h4>
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%">
                      <thead>
                        <tr>
                          <th width="10%">
                            <center>Nomor</center>
                          </th>
                          <th>Jenis Dokumen</th>
                          <th width="10%">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php echo form_open('', array('class' => 'form-horizontal row-border', 'role' => 'form')); ?>
                        <?php $i = 1;
                        if (empty($data_luarnegeri_diri)) { ?>
                          <tr>
                            <td align="center" colspan="3">Tidak ada file KTP</td>
                          </tr>
                        <?php } else {
                          $file_ktp = $cek_file['file_ktp'];
                          $year = $cek_file['year'];
                          $month = $cek_file['month'];
                          $nik = $cek_file['nik'];
                          $id_adminluarnegeri = $data_luarnegeri_diri[0]->id_adminluarnegeri;
                          $namafile = $data_luarnegeri_diri[0]->file_ktp;
                        ?>
                          <tr>

                            <td align="center"><?php echo $i; ?>.</td>
                            <td>File KTP</td>
                            <td>
                              <center>
                                <a class="btn btn-xs btn-primary" target="_blank" href="<?= site_url('upload/file/administrasi/luarnegeri/' . $year . '/' . $month . '/' . $nik . '/' . $file_ktp) ?>"><i class="fa fa-eye"></i></a>

                                <a class="btn btn-xs btn-primary" download href="<?= site_url('upload/file/administrasi/luarnegeri/' . $year . '/' . $month . '/' . $nik . '/' . $file_ktp) ?>"><i class="fa fa-download"></i></a>
                              </center>
                            </td>
                          </tr>
                        <?php
                        }
                        ?>
                        <?php echo form_close(); ?>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-offset-1 col-xs-9">
                  <h4 style="text-align:left;font-weight:bold;">Kelengkapan Administrasi</h4>
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%">
                      <thead>
                        <tr>
                          <th width="10%">
                            <center>Nomor</center>
                          </th>
                          <th>Jenis Dokumen</th>
                          <!-- <th width="10%">Unggah</th> -->
                          <th width="10%">File Upload</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1;

                        if (empty($data_luarnegeri_adm[0]->nama_administrasi)) { ?>
                          <tr>
                            <td align="center" colspan="3">Tidak Ada Dokumen Administrasi Utama</td>
                          </tr>
                          <?php } else {
                          foreach ($data_luarnegeri_adm as $key => $list) :
                            $abc = $list->nama_file;
                            $file_ktp   = $cek_file['file_ktp'];
                            $year       = $cek_file['year'];
                            $month      = $cek_file['month'];
                            $nik        = $cek_file['nik'];
                          ?>
                            <tr>
                              <td align="center"><?php echo $i; ?>.</td>
                              <td><?php echo $list->nama_administrasi; ?></td>
                              <td>
                                <center>
                                  <?php
                                  if (empty($abc)) {
                                    echo "<span style='color: red;'>Tidak ada file</span>";
                                  } else { ?>
                                    <a class="btn btn-xs btn-primary" target="_blank" href="<?= site_url('upload/file/administrasi/luarnegeri/' . $year . '/' . $month . '/' . $nik . '/' . $abc) ?>"><i class="fa fa-eye"></i></a>

                                    <a class="btn btn-xs btn-primary" download href="<?= site_url('upload/file/administrasi/luarnegeri/' . $year . '/' . $month . '/' . $nik . '/' . $abc) ?>"><i class="fa fa-download"></i></a>
                                  <?php } ?>
                                </center>


                              </td>
                            </tr>
                        <?php $i++;
                          endforeach;
                        } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-offset-1 col-xs-9">
                  <h4 style="text-align:left;font-weight:bold;">Kelengkapan Pendukung</h4>
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%">
                      <thead>
                        <tr>
                          <th width="10%">
                            <center>Nomor</center>
                          </th>
                          <th>Jenis Dokumen</th>
                          <th width="10%">File Upload</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1;
                        if (empty($data_luarnegeri_pend)) { ?>
                          <tr>
                            <td align="center" colspan="3">Tidak Ada Dokumen Pendukung</td>
                          </tr>
                          <?php } else {
                          foreach ($data_luarnegeri_pend as $key => $list) :
                            $abc = $list->nama_file;
                            $file_ktp   = $cek_file['file_ktp'];
                            $year       = $cek_file['year'];
                            $month      = $cek_file['month'];
                            $nik        = $cek_file['nik'];
                          ?>
                            <tr>
                              <td align="center"><?php echo $i; ?>.</td>
                              <td><?php echo $list->nama_administrasi; ?></td>
                              <td>
                                <center>
                                  <?php
                                  if (empty($abc)) {
                                    echo "<span style='color: red;'>Tidak ada file</span>";
                                  } else { ?>
                                    <a class="btn btn-xs btn-primary" target="_blank" href="<?= site_url('upload/file/administrasi/luarnegeri/' . $year . '/' . $month . '/' . $nik . '/' . $abc) ?>"><i class="fa fa-eye"></i></a>

                                    <a class="btn btn-xs btn-primary" download href="<?= site_url('upload/file/administrasi/luarnegeri/' . $year . '/' . $month . '/' . $nik . '/' . $abc) ?>"><i class="fa fa-download"></i></a>
                                  <?php } ?>
                                </center>
                              </td>
                            </tr>
                        <?php $i++;
                          endforeach;
                        } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <?php echo form_open_multipart(site_url('master-kade/adminluarnegeri/updatestatuspermohonan'), array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'formEntry')); ?>
              <?php echo form_hidden('tokenId', ''); ?>
              <div class="row">
                <div class="col-md-offset-1 col-xs-9">
                  <h4 style="text-align:left;font-weight:bold;">Status Permohonan</h4>
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="hidden" value="<?= $data_luarnegeri_diri[0]->id_adminluarnegeri ?>" name="id_adminluarnegeri">
                      <input type="hidden" value="<?= $data_luarnegeri_diri[0]->nama_lengkap ?>" name="nama_lengkap">
                      <label style="font-size:16px;"><b>Pilih Status</b></label>
                      <?php echo form_dropdown('statusPermohonan', statusPermohonan(), $this->input->post('statusPermohonan'), 'class="select-all" id="statusPermohonan"'); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label style="font-size:16px;"><b>Keterangan</b></label>
                      <textarea name="keterangan" id="keterangan" class="form-control" cols="30" rows="6"><?php echo $keterangan  ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="panel-footer">
            <div class="row">
              <div class="col-sm-6 col-sm-offset-3">
                <div class="btn-toolbar">
                  <button class="btn-success btn" type="submit" name="save" id="save"><i class="fa fa-check"></i> Update Permohonan</button>
                  <a href="<?= site_url('master-kade/adminluarnegeri') ?>" class="btn-warning btn"><i class="fa fa-times"></i> Kembali</a>

                </div>
              </div>
            </div>
          </div>
        </div>

        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
</div>
</div><!-- container -->

<script type="text/javascript">
  $.fn.modal.Constructor.prototype.enforceFocus = function() {};
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
  var site = '<?php echo site_url(); ?>';

  function formReset() {
    $('#formEntry').attr('action', site + 'master-kade/adminluarnegeri/updatestatuspermohonan');
    $('#errEntry').html('');
    $('form#formEntry').trigger('reset');
    $('.help-block').text('');
    $('.required').removeClass('has-error');
    $('.fileinput').addClass('fileinput-new').removeClass('fileinput-exists');
  }

  $('#formEntry').submit(function(e) {
    e.preventDefault();


    // var postData = $(this).serialize();
    var form = $('#formEntry')[0];
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
              var token = $(this).data('id');
              $.ajax({
                url: formActionURL,
                mimeType: "multipart/form-data",
                type: "POST",
                // data: {
                //   'form': new FormData(form),
                //   'token': token,
                //   '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
                // },
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
                  //formReset();
                  $('#errEntry').html('<div class="alert alert-dismissable alert-success">' +
                    '<strong>Sukses!</strong> ' + data.message +
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                    '</div>');
                  window.location.href = site + 'master-kade/adminluarnegeri/';
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

    // }

  });

  //cetak laporan pdf
  $(document).on('click', '.printPdf', function(e) {
    var cuti = $('input[name="no_registrasi"]').val();
    url = site + 'master-kade/adminluarnegeri/export-to-pdf?registration_number=' + cuti;
    window.location.href = url;
  });

  jQuery(document).ready(function() {
    $(".pulsate").pulsate({
      glow: false
    });
  });
</script>