<div class="container">
  <div class="panel-heading">
    <h4>Administrasi Pergantian antar waktu DPRD</h4>
  </div>
  <div class="panel panel-info">
    <div class="panel-heading">
      <ul class="nav nav-tabs">
        <li class="active">
          <a href="#home1" data-toggle="tab">1. Isi Data dan Upload Persyaratan</a>
        </li>
        <li>
          <a href="#profile1" data-toggle="tab">2. Bukti Registrasi Pelayanan</a>
        </li>
      </ul>
    </div>

    <div class="panel-body collapse in">
      <div class="tab-content">
        <div class="tab-pane active" id="home1">
          <div class="panel panel-info">
            <?php echo $this->session->flashdata('message'); ?>
            <div id="errEntry"></div>
            <div class="panel-heading"><i class="fa fa-bars"></i> Silahkan Isi Data Pada Form</div>
            <?php echo form_open_multipart(site_url('master-dprd/dprdperawa/create/save-register'), array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'formEntry')); ?>
            <?php echo form_hidden('no_registrasi', !empty($dprd_perawa) ? $dprd_perawa['no_urut'] : ''); ?>
            <div class="panel-body">
              <div class="form-group required">
                <label for="nama_lengkap" class="col-sm-3 control-label">
                  <font color="#000000">Nama Lengkap</font>
                </label>
                <div class="col-sm-6">
                  <input type="text" class="form-control tooltips" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap" value="<?php echo !empty($dprd_perawa) ? $dprd_perawa['nama_lengkap'] : set_value('nama_lengkap'); ?>" data-trigger="hover" data-original-title="Nama Lengkap yang akan digunakan">
                  <div class="help-block"></div>
                </div>
              </div>

              <div class="form-group required">
                <label for="nik" class="col-sm-3 control-label">
                  <font color="#000000">NIK(Nomor KTP Elektronik)</font>
                </label>
                <div class="col-sm-6">
                  <input type="text" class="form-control tooltips" name="nik" id="nik" placeholder="NIK(Nomor KTP Elektronik)" value="<?php echo !empty($dprd_perawa) ? $dprd_perawa['nik'] : set_value('nik'); ?>" data-trigger="hover" data-original-title="NIK(Nomor KTP Elektronik) yang akan digunakan">
                  <div class="help-block"></div>
                </div>
              </div>

              <div class="form-group required">
                <label class="col-sm-3 control-label">
                  <font color="#000000">File Scan KTP Elektronik</font>
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
                        <input type="file" name="file_ktp" id="file_ktp">
                      </span>
                      <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                    </div>
                  </div>
                  <div class="help-block"></div>
                </div>
              </div>

              <div class="form-group required">
                <label for="alamat" class="col-sm-3 control-label">
                  <font color="#000000">Alamat Anda</font>
                </label>
                <div class="col-sm-6">
                  <input type="text" class="form-control tooltips" name="alamat" id="alamat" placeholder="Alamat Anda" value="<?php echo !empty($dprd_perawa) ? $dprd_perawa['alamat'] : set_value('alamat'); ?>" data-trigger="hover" data-original-title="Alamat Anda">
                  <div class="help-block"></div>
                </div>
              </div>

              <div class="form-group required">
                <label for="pemda_lembaga_umum" class="col-sm-3 control-label">
                  <font color="#000000">Pemda/Lembaga/Umum</font>
                </label>
                <div class="col-sm-6">
                  <input type="text" class="form-control tooltips" name="pemda_lembaga_umum" id="pemda_lembaga_umum" placeholder="Pemda/Lembaga/Umum" value="<?php echo !empty($dprd_perawa) ? $dprd_perawa['pemda_lembaga_umum'] : set_value('pemda_lembaga_umum'); ?>" data-trigger="hover" data-original-title="Pemda/Lembaga/Umum">
                  <div class="help-block"></div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-offset-1 col-xs-9">
                  <h4 style="text-align:left;font-weight:bold;">Kelengkapan Administrasi</h4>
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%">
                      <thead>
                        <tr>
                          <th>
                            <center>Nomor</center>
                          </th>
                          <th>Jenis Dokumen</th>
                          <th width="10%">Unggah</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1;
                        if (empty($list_administrasi)) { ?>
                          <tr>
                            <td align="center" colspan="3">Tidak Ada Dokumen Pendukung</td>
                          </tr>
                          <?php } else {
                          foreach ($list_administrasi as $key => $list) : ?>
                            <tr>
                              <td align="center"><?php echo $i; ?>.</td>
                              <td><?php echo $list->nama_administrasi; ?></td>
                              <td>
                                <?php echo form_hidden('id_doc[' . $i . ']', $list->id_administrasi); ?>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                  <span class="btn btn-magenta btn-file pulsate">
                                    <span class="fileinput-new">Pilih file</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="file_doc_<?= $i; ?>" value="<?php echo !empty($dprd_perawa) ? $dprd_perawa['no_urut'] : ''; ?>" required>
                                  </span>
                                  <span class="fileinput-filename"></span>
                                  <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                </div>
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
                          <th>
                            <center>Nomor</center>
                          </th>
                          <th>Jenis Dokumen</th>
                          <th width="10%">Unggah</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1;
                        if (empty($list_pendukung)) { ?>
                          <tr>
                            <td align="center" colspan="3">Tidak Ada Dokumen Pendukung</td>
                          </tr>
                          <?php } else {
                          foreach ($list_pendukung as $key => $list) : ?>
                            <tr>
                              <td align="center"><?php echo $i; ?>.</td>
                              <td><?php echo $list->nama_administrasi; ?></td>
                              <td>
                                <?php echo form_hidden('id_doc_pend[' . $i . ']', $list->id_administrasi); ?>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                  <span class="btn btn-magenta btn-file pulsate">
                                    <span class="fileinput-new">Pilih file</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="file_doc_pend<?= $i; ?>" id="file_doc_pend<?= $i; ?>" value="<?php echo !empty($dprd_perawa) ? $dprd_perawa['no_urut'] : ''; ?>">
                                  </span>
                                  <span class="fileinput-filename"></span>
                                  <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                </div>
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
        <div class="tab-pane" id="profile1">
          <div class="row">
            <div class="col-xs-12">

              <div class="panel panel-midnightblue">
                <div class="panel-body">

                  <div class="row">
                    <div class="col-md-12">
                      <!-- <img src="assets/demo/avatar/johansson.png" alt="" class="pull-left" style="margin: 0 20px 20px 0"> -->
                      <div class="table-responsive">
                        <table class="table table-condensed">
                          <h3><strong>Nomor Registrasi: <?php echo !empty($dprd_perawa) ? $dprd_perawa['no_urut'] : ''; ?></strong></h3>

                          <tbody>
                            <tr>
                              <td>Tanggal Registrasi</td>
                              <td>: <strong><?php echo !empty($dprd_perawa) ? tgl_indo_registrasi($dprd_perawa['create_date']) : ''; ?></strong></td>
                            </tr>
                            <tr>
                              <td>Jam Registrasi</td>
                              <td>: <strong><?php echo !empty($dprd_perawa) ? tgl_indo_jam($dprd_perawa['create_date']) : ''; ?> WIB</strong></td>
                            </tr>
                            <tr>
                              <td>Nama Lengkap</td>
                              <td>: <strong><?php echo !empty($dprd_perawa) ? $dprd_perawa['nama_lengkap'] : ''; ?></strong></td>
                            </tr>
                            <tr>
                              <td>NIK (Nomor Induk Kependudukan)</td>
                              <td>: <strong><?php echo !empty($dprd_perawa) ? $dprd_perawa['nik'] : ''; ?></strong></td>
                            </tr>
                            <tr>
                              <td>Alamat</td>
                              <td>: <strong><?php echo !empty($dprd_perawa) ? $dprd_perawa['alamat'] : ''; ?></strong></td>
                            </tr>
                            <tr>
                              <td>Pemda/Lembaga/Umum</td>
                              <td>: <strong><?php echo !empty($dprd_perawa) ? $dprd_perawa['pemda_lembaga_umum'] : ''; ?></strong></td>
                            </tr>
                            <tr>
                              <td>Nama Layanan</td>
                              <td>: <strong><?php echo !empty($dprd_perawa) ? $dprd_perawa['nm_layanan'] : ''; ?></strong></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                      <button class="btn btn-magenta btn-block printPdf pulsate"><i class="fa fa-print"></i> Cetak Bukti Registrasi</button>
                    </div>
                  </div>

                </div>
              </div>

            </div>
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
    $('#formEntry').attr('action', site + 'master-dprd/dprdperawa/create');
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
                  //formReset();
                  $('#errEntry').html('<div class="alert alert-dismissable alert-success">' +
                    '<strong>Sukses!</strong> ' + data.message +
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                    '</div>');
                  window.location.href = site + 'master-dprd/dprdperawa/create/new-register/' + data.kode;
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

  //cetak laporan pdf
  $(document).on('click', '.printPdf', function(e) {
    var cuka = $('input[name="no_registrasi"]').val();
    url = site + 'master-dprd/dprdperawa/export-to-pdf?registration_number=' + cuka;
    window.location.href = url;
  });

  jQuery(document).ready(function() {
    $(".pulsate").pulsate({
      glow: false
    });
  });
</script>