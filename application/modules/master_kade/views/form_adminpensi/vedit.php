<div class="container">
  <div class="panel-heading">
    <?php
    // var_dump($data_pensi_diri);
    // exit;
    ?>
    <h4>Edit Permohonan <u><?= $data_pensi_diri[0]->nama_lengkap ?> </u> </h4>
  </div>
  <div class="panel panel-brown">
    <div class="panel-body collapse in">
      <div class="tab-content">
        <div class="tab-pane active" id="home1">
          <div class="panel panel-brown">
            <?php echo $this->session->flashdata('message'); ?>
            <div id="errEntry"></div>
            <div class="panel-heading"><i class="fa fa-bars"></i> Silahkan Isi Data Pada Form</div>
            <div class="panel-body">
              <?php echo form_open_multipart(site_url('master-kade/adminpensi/update/proses-edit-data'), array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'formEntry')); ?>
              <div class="panel-body">
                <div class="form-group required">
                  <label for="nama_lengkap" class="col-sm-3 control-label">
                    <font color="#000000">Nama Lengkap</font>
                  </label>
                  <div class="col-sm-6">
                    <input type="hidden" value="<?= $data_pensi_diri[0]->id_adminpensi ?>" name="id_adminpensi">
                    <input type="text" class="form-control tooltips" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap" value="<?= $data_pensi_diri[0]->nama_lengkap ?>" data-trigger="hover" data-original-title="Nama Lengkap yang akan digunakan">
                    <div class="help-block"></div>
                  </div>
                </div>

                <div class="form-group required">
                  <label for="nik" class="col-sm-3 control-label">
                    <font color="#000000">NIK(Nomor KTP Elektronik)</font>
                  </label>
                  <div class="col-sm-6">
                    <input type="number" class="form-control tooltips" name="nik" id="nik" placeholder="NIK(Nomor KTP Elektronik)" value="<?= $data_pensi_diri[0]->nik ?>" data-trigger="hover" data-original-title="NIK(Nomor KTP Elektronik) yang akan digunakan" readonly>
                    <div class="help-block"></div>
                  </div>
                </div>

                <div class="form-group required">
                  <label for="alamat" class="col-sm-3 control-label">
                    <font color="#000000">Alamat Anda</font>
                  </label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control tooltips" name="alamat" id="alamat" placeholder="Alamat Anda" value="<?= $data_pensi_diri[0]->alamat ?>" data-trigger="hover" data-original-title="Alamat Anda">
                    <div class="help-block"></div>
                  </div>
                </div>

                <div class="form-group required">
                  <label for="pemda_lembaga_umum" class="col-sm-3 control-label">
                    <font color="#000000">Pemda/Lembaga/Umum</font>
                  </label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control tooltips" name="pemda_lembaga_umum" id="pemda_lembaga_umum" placeholder="Pemda/Lembaga/Umum" value="<?= $data_pensi_diri[0]->pemda_lembaga_umum ?>" data-trigger="hover" data-original-title="Pemda/Lembaga/Umum">
                    <div class="help-block"></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 col-sm-offset-3">
                    <div class="btn-toolbar">
                      <button class="btn-success btn" type="submit" name="save" id="save"><i class="fa fa-check"></i> Update Data</button>
                      <a href="javascript:history.back()" class="btn-warning btn tes"><i class="fa fa-times"></i> Batal</a>
                    </div>
                  </div>
                </div>
                <?php echo form_close(); ?>


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
                            <th width="10%">Unggah</th>
                            <th width="15%">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php echo form_open('', array('class' => 'form-horizontal row-border', 'role' => 'form')); ?>
                          <?php $i = 1;
                          if (empty($data_pensi_diri)) { ?>
                            <tr>
                              <td align="center" colspan="3">Tidak ada file KTP</td>
                            </tr>
                          <?php } else {
                            $file_ktp   = $cek_file['file_ktp'];
                            $year       = $cek_file['year'];
                            $month      = $cek_file['month'];
                            $nik        = $cek_file['nik'];
                            $id_adminpensi  = $data_pensi_diri[0]->id_adminpensi;
                            $namafile       = $data_pensi_diri[0]->file_ktp;
                          ?>
                            <tr>

                              <td align="center"><?php echo $i; ?>.</td>
                              <td>File KTP</td>
                              <td>
                                <input type="file" style="display: none;" class="uploadKTP" name="file_ktp_" id="file_ktp_<?= $id_adminpensi; ?>" data-idadminpensi="<?= $id_adminpensi; ?>">


                                <button type="button" role="button" onclick="$('#file_ktp_<?= $id_adminpensi; ?>').click();" class="btn btn-primary">Upload</button>
                                <input type="hidden" value="<?php echo $id_adminpensi ?>">
                                <input type="hidden" value="<?php echo $namafile ?>">
                              </td>
                              <td>
                                <center>
                                  <a class="btn btn-xs btn-primary" target="_blank" href="<?= site_url('upload/file/administrasi/pensi/' . $year . '/' . $month . '/' . $nik . '/' . $namafile) ?>">View</a>
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
                            <th width="10%">Unggah</th>
                            <th width="15%">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php echo form_open('', array('class' => 'form-horizontal row-border', 'role' => 'form')); ?>
                          <?php $i = 1;
                          if (empty($edit_pensi_adm)) { ?>
                            <tr>
                              <td align="center" colspan="3">Tidak Ada Dokumen Administrasi Utama</td>
                            </tr>
                            <?php } else {
                            foreach ($edit_pensi_adm as $key => $list) :
                              $abc = $list->nama_file;
                              $file_ktp   = $cek_file['file_ktp'];
                              $year       = $cek_file['year'];
                              $month      = $cek_file['month'];
                              $nik        = $cek_file['nik'];
                            ?>
                              <tr>

                                <td align="center"><?php echo $i; ?>.</td>
                                <td><?php echo $list->nama_administrasi; ?><span style="color: red;"> *</span></td>
                                <td>
                                  <?php echo form_hidden('id_doc_pend[' . $i . ']', $list->id_adminpensi); ?>
                                  <input type="file" style="display: none;" class="uploadDokumen" name="file_doc_" id="file_doc_<?= $i; ?>" data-idadminupload="<?= base64_encode($list->id_adminupload) ?>" data-idadminpensi="<?= $this->uri->segment(4); ?>" data-idadministrasi="<?= base64_encode($list->id_administrasi)  ?>" data-id="<?= $i ?>">

                                  <button type="button" role="button" onclick="$('#file_doc_<?= $i ?>').click();" class="btn btn-primary">Upload</button>

                                  <input type="hidden" value="<?php echo $list->nama_file ?>">
                                  <input type="hidden" value="<?php echo $list->id_adminupload ?>">
                                  <input type="hidden" id="id_adminpensi" value="<?php echo $list->id_adminpensi ?>">
                                  <input type="hidden" value="<?php echo $list->id_administrasi ?>">
                                </td>
                                <td>
                                  <center>
                                    <?php if (!empty($abc)) { ?>
                                      <a class="btn btn-xs btn-primary" target="_blank" href="<?= site_url('upload/file/administrasi/pensi/' . $year . '/' . $month . '/' . $nik . '/' . $abc) ?>">View</a>
                                    <?php } else {
                                      echo "<span style='color: red;'>Belum ada file</span>";
                                    }
                                    ?>
                                  </center>
                                </td>
                              </tr>
                          <?php $i++;
                            endforeach;
                          } ?>
                          <?php echo form_close(); ?>

                        </tbody>
                      </table>
                    </div>
                    <span style="font-family: cursive; font-style: italic;">Note : </span>
                      <ol>
                        <li>Wajib Diisi <span style="color: red;">*</span></li>
                        <li>Pastikan dokumen administrasi sudah diupload seluruhnya</li>
                      </ol>
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
                            <th width="10%">Unggah</th>
                            <th width="15%">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $i = 1;
                          if (empty($data_pensi_pend)) { ?>
                            <tr>
                              <td align="center" colspan="3">Tidak Ada Dokumen Pendukung</td>
                            </tr>
                            <?php } else {
                            foreach ($data_pensi_pend as $key => $list) :
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
                                  <?php echo form_hidden('id_doc_pend[' . $i . ']', $list->id_administrasi); ?>
                                  <input type="file" style="display: none;" class="uploadDokPend" name="file_dokumen_pend_" id="file_dokumen_pend_<?= $i ?>" data-iduploadpend="<?= $list->id_adminupload ?>" data-idadminpensipend="<?= base64_decode($this->uri->segment(4)); ?>" data-idadministrasi="<?= $list->id_administrasi  ?>" data-id="<?= $i ?>">

                                  <button type="button" role="button" onclick="$('#file_dokumen_pend_<?= $i ?>').click();" class="btn btn-primary">Upload</button>

                                  <input type="hidden" name="file_doc_pend<?= $i; ?>" id="file_doc_pend<?= $i; ?>" value="<?php echo $list->nama_file ?>">
                                  <input type="hidden" value="<?php echo $list->id_adminupload ?>">
                                  <input type="hidden" id="id_adminpensi" value="<?php echo $list->id_adminpensi ?>">
                                  <input type="hidden" value="<?php echo $list->id_administrasi ?>">
                                </td>
                                <td>
                                  <center>
                                    <?php if (!empty($abc)) { ?>
                                      <a class="btn btn-xs btn-primary" target="_blank" href="<?= site_url('upload/file/administrasi/pensi/' . $year . '/' . $month . '/' . $nik . '/' . $abc) ?>">View</a>

                                      <a class="btnDelete btn btn-xs btn-danger" data-id="<?= $list->id_adminupload ?>" href="#">Hapus</a>
                                    <?php } else {

                                      echo "<span style='color: red;'>Belum ada file</span>";
                                    }
                                    ?>
                                  </center>
                                </td>
                              </tr>
                          <?php $i++;
                            endforeach;
                          } ?>
                        </tbody>
                      </table>
                    </div>
                    <span style="font-family: cursive; font-style: italic;">Note : </span>
                        <ol>
                          <li>Pastikan dokumen pendukung sudah diupload minimal 1 (satu) dokumen</li>
                        </ol>
                  </div>
                </div>
              </div>
            </div>
            <?php echo form_open_multipart(site_url('master-kade/adminpensi/update/ajukan-kembali'), array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'formajukankembali')); ?>
            <div class="panel-footer">
              <input type="hidden" value="<?= $data_pensi_diri[0]->id_adminpensi ?>" name="id_adminpensi">
              <input type="hidden" value="<?= $data_pensi_diri[0]->nama_lengkap ?>" name="nama_lengkap">
              <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                  <div class="btn-toolbar">
                    <button class="btn-success btn" type="submit" name="saveAjukanKembali" id="saveAjukanKembali"><i class="fa fa-check"></i> Ajukan Kembali</button>
                    <a href="<?= site_url('master-kade/adminpensi') ?>" class="btn-warning btn"><i class="fa fa-times"></i> Kembali</a>

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
</div>
</div><!-- container -->

<script type="text/javascript">
  $.fn.modal.Constructor.prototype.enforceFocus = function() {};
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
  var site = '<?php echo site_url(); ?>';

  $('.uploadKTP').change(function(e) {
    e.preventDefault();
    var id_adminpensi = $(this).data('idadminpensi');
    var dokumen = document.getElementById("file_ktp_" + id_adminpensi).files.length;
    data = new FormData();
    data.append('id_adminpensi', id_adminpensi);
    data.append('file_ktp', $('#file_ktp_' + id_adminpensi)[0].files[0]);
    data.append(csrfName, $('input[name="' + csrfName + '"]').val());
    $.ajax({
      url: '<?= site_url('master-kade/adminpensi/update/proses-edit-ktp') ?>',
      type: 'post',
      dataType: 'json',
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function() {
        $('#file_ktp_' + id_adminpensi).addClass('disable');
        $('#file_ktp_' + id_adminpensi).text('uploading...');
      },
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
        // window.location.href = site + 'master-kade/adminluarnegeri/';
        location.reload()
      }
    }).fail(function() {
      $('#errEntry').html('<div class="alert alert-danger">' +
        '<strong>Peringatan!</strong> Harap periksa kembali data yang diinputkan...' +
        '</div>');
    }).always(function() {
      $("#save").html('<i class="fa fa-check"></i> Simpan Data');
      $("#save").removeClass('disabled');
    });
  });

  $('.uploadDokumen').change(function(e) {
    e.preventDefault();
    var id_adminupload = $(this).data('idadminupload');
    var id_administrasi = $(this).data('idadministrasi');
    var id_adminpensi = $(this).data('idadminpensi');
    var id = $(this).data('id');
    var dokumen = document.getElementById("file_doc_" + id).files.length;
    data = new FormData();
    data.append('dokumen', $('#file_doc_' + id)[0].files[0]);
    data.append('id_adminupload', id_adminupload);
    data.append('id_adminpensi', id_adminpensi);
    data.append('id_administrasi', id_administrasi);
    data.append(csrfName, $('input[name="' + csrfName + '"]').val());
    $.ajax({
      url: '<?= site_url('master-kade/adminpensi/update/proses-edit') ?>',
      type: 'post',
      dataType: 'json',
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function() {
        $('#file_doc_' + id).addClass('disable');
        $('#file_doc_' + id).text('uploading...');
      },
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
        // window.location.href = site + 'master-kade/adminluarnegeri/';
        location.reload()
      }
    }).fail(function() {
      $('#errEntry').html('<div class="alert alert-danger">' +
        '<strong>Peringatan!</strong> Harap periksa kembali data yang diinputkan...' +
        '</div>');
    }).always(function() {
      $("#save").html('<i class="fa fa-check"></i> Simpan Data');
      $("#save").removeClass('disabled');
    });
  });

  $('.uploadDokPend').change(function(e) {
    e.preventDefault();
    var id_uploadpend = $(this).data('iduploadpend');
    var idadminpensipend = <?= base64_decode($this->uri->segment(4)); ?>;
    var idadministrasi = $(this).data('idadministrasi');
    var id = $(this).data('id');
    var dokumenpend = document.getElementById("file_dokumen_pend_" + id).files.length;
    if (dokumenpend == 0) {
      alert('File kosong');
    } else {
      data = new FormData();
      data.append('dokumenPend', $('#file_dokumen_pend_' + id)[0].files[0]);
      data.append('iduploadpend', id_uploadpend);
      data.append('idadminpensipend', idadminpensipend);
      data.append('id_administrasi', idadministrasi);
      data.append(csrfName, $('input[name="' + csrfName + '"]').val());
      $.ajax({
        url: '<?= site_url('master-kade/adminpensi/update/proses-edit-pendukung') ?>',
        type: 'post',
        dataType: 'json',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
          $('#file_dokumen_pend_' + id_uploadpend).addClass('disable');
          $('#file_dokumen_pend_' + id_uploadpend).text('uploading...');
        },
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
          // window.location.href = site + 'master-kade/adminluarnegeri/';
          location.reload()
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
  });

  function run_waitMe(el) {
    el.waitMe({
      effect: 'facebook',
      text: 'Please wait...',
      bg: 'rgba(255,255,255,0.7)',
      color: '#000',
      maxSize: 100,
      waitTime: -1,
      textPos: 'vertical',
      source: '',
      fontSize: '',
      onClose: function(el) {}
    });
  }

  function formReset() {
    $('#formEntry').attr('action', site + 'master-kade/adminluarnegeri/update/proses-edit-data');
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
      message: "Apakah anda ingin menyimpan data ini ?",
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
                  location.reload();
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

  $('#formajukankembali').submit(function(e) {
    e.preventDefault();
    // var postData = $(this).serialize();
    var form = $('#formajukankembali')[0];
    // get form action url
    var formActionURL = $(this).attr("action");
    $("#saveAjukanKembali").html('<i class="fa fa-hourglass-half"></i> Diproses...');
    $("#saveAjukanKembali").addClass('disabled');
    bootbox.dialog({
      title: "Konfirmasi",
      message: "Apakah anda ingin mengajukan data ini kembali ?",
      buttons: {
        "cancel": {
          "label": "<i class='fa fa-times'></i> Tidak",
          "className": "btn-danger",
          callback: function(response) {
            if (response) {
              $("#saveAjukanKembali").html('<i class="fa fa-check"></i> Simpan Data');
              $("#saveAjukanKembali").removeClass('disabled');
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
                  // location.reload();
                  window.location.href = site + 'master-kade/adminpensi';

                }
              }).fail(function() {
                $('#errEntry').html('<div class="alert alert-danger">' +
                  '<strong>Peringatan!</strong> Harap periksa kembali data yang diinputkan...' +
                  '</div>');
              }).always(function() {
                $("#saveAjukanKembali").html('<i class="fa fa-check"></i> Simpan Data');
                $("#saveAjukanKembali").removeClass('disabled');
              });
            }
          }
        }
      }
    });
  });

  $(document).on('click', '.btnDelete', function(e) {
    e.preventDefault();
    var postData = {
      'id': $(this).data('id'),
      '<?php echo $this->security->get_csrf_token_name(); ?>': $('input[name="' + csrfName + '"]').val()
    };
    $(this).html('<i class="fa fa-hourglass-half"></i>');
    $(this).addClass('disabled');
    run_waitMe($('#formParent'));
    bootbox.dialog({
      title: "Konfirmasi",
      message: "Apakah anda ingin menghapus data fasilitasi ini ?",
      buttons: {
        "cancel": {
          "label": "<i class='fa fa-times'></i> Tidak",
          "className": "btn-danger",
          callback: function(response) {
            if (response) {
              $('.btnDelete').html('<i class="fa fa-times"></i>');
              $('.btnDelete').removeClass('disabled');
              $('#formParent').waitMe('hide');
            }
          }
        },
        "main": {
          "label": "<i class='fa fa-check'></i> Ya, Lanjutkan",
          "className": "btn-primary",
          callback: function(response) {
            if (response) {
              $.ajax({
                url: site + 'master-kade/adminpensi/deletedokumenpendukung',
                type: "POST",
                data: postData,
                dataType: "json",
              }).done(function(data) {
                $('input[name="' + csrfName + '"]').val(data.csrfHash);
                if (data.status == 0) {
                  $('#errSuccess').html('<div class="alert alert-danger">' +
                    '<strong>Informasi!</strong> ' + data.message +
                    '</div>');
                } else {
                  $('#errSuccess').html('<div class="alert alert-dismissable alert-success">' +
                    '<strong>Sukses!</strong> ' + data.message +
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                    '</div>');
                  location.reload();
                }
                $('#formParent').waitMe('hide');
              }).fail(function() {
                $('#errSuccess').html('<div class="alert alert-danger">' +
                  '<strong>Peringatan!</strong> Proses delete data gagal...' +
                  '</div>');
                $('#formParent').waitMe('hide');
              }).always(function() {
                $('.btnDelete').html('<i class="fa fa-times"></i>');
                $('.btnDelete').removeClass('disabled');
              });
            }
          }
        }
      }
    });
  });
</script>