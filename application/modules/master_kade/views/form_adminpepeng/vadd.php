<div class="container">
  <div class="panel-heading">
    <h4>Administrasi Pengesahan Pengangkatan dan Pemberhentian KDH</h4>
  </div>
  <div class="panel panel-inverse">
    <div class="panel-heading">
      <ul class="nav nav-tabs">
        <li class="active nav-item">
          <a href="#home1" class="nav-link" data-toggle="tab">1. Isi Data </a>
        </li>
        <li id="upload" class="nav-item">
          <a href="#upload1" class="nav-link" data-toggle="tab">2. Upload Persyaratan</a>
        </li>
        <li id="profile" class="nav-item">
          <a href="#profile1" class="nav-link" data-toggle="tab">3. Bukti Registrasi Pelayanan</a>
        </li>
      </ul>
    </div>

    <div class="panel-body collapse in">
      <?php echo $this->session->flashdata('message'); ?>
      <div id="errEntry"></div>
      <div class="tab-content">
        <div class="tab-pane active" id="home1">
          <div class="panel panel-inverse">
            <div class="panel-heading"><i class="fa fa-bars"></i> Silahkan Isi Data Pada Form</div>
            <?php echo form_open_multipart(site_url('master-kade/adminpepeng/create/save-register'), array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'formEntry')); ?>
            <?php echo form_hidden('no_registrasi', !empty($data_pepeng) ? $data_pepeng['no_urut'] : ''); ?>
            <div class="panel-body">
              <div class="form-group required">
                <label for="nama_lengkap" class="col-sm-3 control-label">
                  <font color="#000000">Nama Lengkap</font>
                </label>
                <div class="col-sm-6">
                  <input type="text" class="input1 form-control tooltips" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap" value="<?php echo !empty($data_pepeng) ? $data_pepeng['nama_lengkap'] : set_value('nama_lengkap'); ?>" data-trigger="hover" data-original-title="Nama Lengkap yang akan digunakan">
                  <div class="help-block"></div>
                </div>
              </div>

              <div class="form-group required">
                <label for="nik" class="col-sm-3 control-label">
                  <font color="#000000">NIK(Nomor KTP Elektronik)</font>
                </label>
                <div class="col-sm-6">
                  <input type="number" class="input1 form-control tooltips" name="nik" id="nik" placeholder="NIK(Nomor KTP Elektronik)" value="<?php echo !empty($data_pepeng) ? $data_pepeng['nik'] : set_value('nik'); ?>" data-trigger="hover" data-original-title="NIK(Nomor KTP Elektronik) yang akan digunakan">
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
                    <span style="font-size: small;font-style: italic;color: red;">*Max upload file 10 MB</span>
                  </div>
                  <div class="help-block"></div>
                </div>
              </div>

              <div class="form-group required">
                <label for="alamat" class="col-sm-3 control-label">
                  <font color="#000000">Alamat Anda</font>
                </label>
                <div class="col-sm-6">
                  <input type="text" class="input1 form-control tooltips" name="alamat" id="alamat" placeholder="Alamat Anda" value="<?php echo !empty($data_pepeng) ? $data_pepeng['alamat'] : set_value('alamat'); ?>" data-trigger="hover" data-original-title="Alamat Anda">
                  <div class="help-block"></div>
                </div>
              </div>

              <div class="form-group required">
                <label for="pemda_lembaga_umum" class="col-sm-3 control-label">
                  <font color="#000000">Pemda/Lembaga/Umum</font>
                </label>
                <div class="col-sm-6">
                  <input type="text" class="input1 form-control tooltips" name="pemda_lembaga_umum" id="pemda_lembaga_umum" placeholder="Pemda/Lembaga/Umum" value="<?php echo !empty($data_pepeng) ? $data_pepeng['pemda_lembaga_umum'] : set_value('pemda_lembaga_umum'); ?>" data-trigger="hover" data-original-title="Pemda/Lembaga/Umum">
                  <div class="help-block"></div>
                </div>
              </div>
              <!-- <div class="row">
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
                            <td align="center" colspan="3">Tidak Ada Dokumen Administrasi Utama</td>
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
                                    <input type="file" name="file_doc_<?= $i; ?>" id="file_doc_<?= $i; ?>" value="<?php echo !empty($data_pepeng) ? $data_pepeng['no_urut'] : ''; ?>" required>
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
                                    <input type="file" name="file_doc_pend<?= $i; ?>" id="file_doc_pend<?= $i; ?>" value="<?php echo !empty($data_pepeng) ? $data_pepeng['no_urut'] : ''; ?>">
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
              </div> -->
              <div class="panel-footer">
                <div class="row">
                  <div class="col-sm-6 col-sm-offset-3">
                    <div class="btn-toolbar">
                      <button class="btn-success btn" type="submit" name="save" id="save"><i class="fa fa-check"></i> Simpan Data</button>
                      <a href="<?= site_url('master-kade/adminpepeng') ?>" class="btn-warning btn"><i class="fa fa-times"></i> Kembali</a>

                    </div>
                  </div>
                </div>
              </div>
            </div>

            <?php echo form_close(); ?>
          </div>
        </div>

        <div class="tab-pane" id="upload1">
          <div class="row">
            <div class="col-xs-12">
              <div class="panel panel-midnightblue">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-offset-1 col-xs-9">
                      <h4 style="text-align:left;font-weight:bold;">Kelengkapan Administrasi</h4>
                      <span style="font-family: cursive; font-style: italic;">Note : </span>
                      <ol>
                        <li>Wajib Diisi <span style="color: red;">*</span></li>
                        <li>Pastikan dokumen administrasi sudah diupload seluruhnya</li>
                        <li>Pastikan dokumen administrasi max 10MB</li>
                      </ol>
                      <div class="table-responsive">
                        <input type="hidden" name="id_adminpepeng" id="id_adminpepeng">
                        <input type="hidden" name="status" id="status" value="<?= $data_pepeng['status'] ?>">
                        <table class="table table-bordered table-striped" width="100%">
                          <thead>
                            <tr>
                              <th width="10%">
                                <center>Nomor</center>
                              </th>
                              <th width="50%">Jenis Dokumen</th>
                              <th width="10%">Unggah</th>
                              <th width="10%">Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $i = 1;
                            if (empty($list_administrasi)) { ?>
                              <tr>
                                <td align="center" colspan="4">Tidak Ada Dokumen Administrasi Utama</td>
                              </tr>
                              <?php } else {
                              foreach ($list_administrasi as $key => $list) :
                                $abc        = $list->nama_file;
                                $file_ktp   = $cek_file['file_ktp'];
                                $year       = $cek_file['year'];
                                $month      = $cek_file['month'];
                                $nik        = $cek_file['nik'];
                              ?>
                                <tr>
                                  <td align="center"><?php echo $i; ?>.</td>
                                  <td><?php echo $list->nama_administrasi; ?><span style="color: red;"> *</span></td>
                                  <td>
                                    <?php echo form_hidden('id_doc[' . $i . ']', $list->id_administrasi); ?>
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                      <span class="btn btn-magenta btn-file pulsate">
                                        <span class="fileinput-new">Pilih file</span>
                                        <span class="fileinput-exists">Change</span>


                                        <input type="file" class="uploadDokumen" name="file_doc_<?= $i; ?>" id="file_doc_<?= $i; ?>" value="<?php echo !empty($data_pepeng) ? $data_pepeng['no_urut'] : ''; ?>" data-idadminupload="<?= base64_encode($list->id_adminupload)  ?>" data-idadminpepeng="<?= $this->uri->segment(5); ?>" data-idadministrasi="<?= base64_encode($list->id_administrasi)   ?>" data-id="<?= $i ?>">


                                      </span>
                                      <span class="fileinput-filename"></span>

                                      <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                    </div>
                                    <input type="hidden" value="<?php echo $list->nama_file ?>">
                                    <input type="hidden" value="<?php echo $list->id_adminupload ?>">
                                    <input type="hidden" value="<?php echo $list->id_administrasi ?>">
                                    <!-- <br> -->
                                    <!-- <span style="font-size: small;font-style: italic;color: red;">*Max upload file 10 MB</span> -->

                                  </td>
                                  <td>
                                    <center>
                                      <?php if (!empty($abc)) { ?>
                                        <a class="btn btn-xs btn-primary" target="_blank" href="<?= site_url('upload/file/administrasi/pepeng/' . $year . '/' . $month . '/' . $nik . '/' . $abc) ?>">View</a>
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

                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-offset-1 col-xs-9">
                      <h4 style="text-align:left;font-weight:bold;">Kelengkapan Pendukung</h4>
                      <span style="font-family: cursive; font-style: italic;">Note : </span>
                      <ol>
                        <li>Pastikan dokumen pendukung sudah diupload minimal 1 (satu) dokumen</li>
                        <li>Pastikan dokumen administrasi max 10MB</li>
                      </ol>
                      <div class="table-responsive">
                        <table class="table table-bordered table-striped" width="100%">
                          <thead>
                            <tr>
                              <th width="10%">
                                <center>Nomor</center>
                              </th>
                              <th width="50%">Jenis Dokumen</th>
                              <th width="10%">Unggah</th>
                              <th width="10%">Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $i = 1;
                            if (empty($list_pendukung)) { ?>
                              <tr>
                                <td align="center" colspan="4">Tidak Ada Dokumen Pendukung</td>
                              </tr>
                              <?php } else {
                              foreach ($list_pendukung as $key => $list) :
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
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                      <span class="btn btn-magenta btn-file pulsate">
                                        <span class="fileinput-new">Pilih file</span>
                                        <span class="fileinput-exists">Change</span>

                                        <input type="file" class="uploadDokPend" name="file_doc_pend<?= $i; ?>" id="file_doc_pend<?= $i; ?>" value="<?php echo !empty($data_pepeng) ? $data_pepeng['no_urut'] : ''; ?>" data-idadminupload="<?= base64_encode($list->id_adminupload)  ?>" data-idadminpepeng="<?= $this->uri->segment(5); ?>" data-idadministrasi="<?= base64_encode($list->id_administrasi)   ?>" data-id="<?= $i ?>">
                                      </span>
                                      <span class="fileinput-filename"></span>
                                      <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                    </div>
                                    <input type="hidden" value="<?php echo $list->nama_file ?>">
                                    <input type="hidden" value="<?php echo $list->id_adminupload ?>">
                                    <input type="hidden" value="<?php echo $list->id_administrasi ?>">
                                  </td>
                                  <td>
                                    <center>
                                      <?php if (!empty($abc)) { ?>
                                        <a class="btn btn-xs btn-primary" target="_blank" href="<?= site_url('upload/file/administrasi/pepeng/' . $year . '/' . $month . '/' . $nik . '/' . $abc) ?>">View</a>
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
                    </div>
                  </div>
                  <?php echo form_open_multipart(site_url('master-kade/adminpepeng/create/save-ajukan'), array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'formAjukan')); ?>
                  <div class="panel-footer">
                    <div class="row">
                      <div class="col-sm-6 col-sm-offset-3">
                        <div class="btn-toolbar">
                          <input type="hidden" value="<?php echo base64_encode($data_pepeng['id_adminpepeng'])  ?>" name="id_adminpepeng">
                          <input type="hidden" value="<?php echo $data_pepeng['nama_lengkap']  ?>" name="nama_lengkap">
                          <button class="btn-success btn" type="submit" name="saveAjukan" id="saveAjukan"><i class="fa fa-check"></i> Ajukan</button>
                          <a href="<?= site_url('master-kade/adminpepeng') ?>" class="btn-warning btn"><i class="fa fa-times"></i> Batal Simpan</a>
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
                          <h3><strong>Nomor Registrasi: <?php echo !empty($data_pepeng) ? $data_pepeng['no_urut'] : ''; ?></strong></h3>

                          <tbody>
                            <tr>
                              <td>Tanggal Registrasi</td>
                              <td>: <strong><?php echo !empty($data_pepeng) ? tgl_indo_registrasi($data_pepeng['create_date']) : ''; ?></strong></td>
                            </tr>
                            <tr>
                              <td>Jam Registrasi</td>
                              <td>: <strong><?php echo !empty($data_pepeng) ? tgl_indo_jam($data_pepeng['create_date']) : ''; ?> WIB</strong></td>
                            </tr>
                            <tr>
                              <td>Nama Lengkap</td>
                              <td>: <strong><?php echo !empty($data_pepeng) ? $data_pepeng['nama_lengkap'] : ''; ?></strong></td>
                            </tr>
                            <tr>
                              <td>NIK (Nomor Induk Kependudukan)</td>
                              <td>: <strong><?php echo !empty($data_pepeng) ? $data_pepeng['nik'] : ''; ?></strong></td>
                            </tr>
                            <tr>
                              <td>Alamat</td>
                              <td>: <strong><?php echo !empty($data_pepeng) ? $data_pepeng['alamat'] : ''; ?></strong></td>
                            </tr>
                            <tr>
                              <td>Pemda/Lembaga/Umum</td>
                              <td>: <strong><?php echo !empty($data_pepeng) ? $data_pepeng['pemda_lembaga_umum'] : ''; ?></strong></td>
                            </tr>
                            <tr>
                              <td>Nama Layanan</td>
                              <td>: <strong><?php echo !empty($data_pepeng) ? $data_pepeng['nm_layanan'] : ''; ?></strong></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                      <button target="_blank" class="btn btn-magenta btn-block printPdf pulsate"><i class="fa fa-print"></i> Cetak Bukti Registrasi</button>
                      <a href="<?= site_url('master-kade/adminpepeng') ?>" class="btn-warning btn"><i class="fa fa-times"></i> Kembali</a>
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
  $('.uploadDokumen').change(function(e) {
    e.preventDefault();
    var id_adminupload = $(this).data('idadminupload');
    var id_adminpepeng = $(this).data('idadminpepeng');
    var id_administrasi = $(this).data('idadministrasi');
    var id = $(this).data('id');
    var dokumen = document.getElementById("file_doc_" + id).files.length;
    data = new FormData();
    data.append('dokumen', $('#file_doc_' + id)[0].files[0]);
    data.append('id_adminupload', id_adminupload);
    data.append('id_adminpepeng', id_adminpepeng);
    data.append('id_administrasi', id_administrasi);
    data.append(csrfName, $('input[name="' + csrfName + '"]').val());
    $.ajax({
      url: '<?= site_url('master-kade/adminpepeng/create/insertadministrasi') ?>',
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
    var id_adminupload = $(this).data('idadminupload');
    var id_adminpepeng = $(this).data('idadminpepeng');
    var id_administrasi = $(this).data('idadministrasi');
    var id = $(this).data('id');
    var dokumen = document.getElementById("file_doc_pend" + id).files.length;
    data = new FormData();
    data.append('dokumenPend', $('#file_doc_pend' + id)[0].files[0]);
    data.append('id_adminupload', id_adminupload);
    data.append('id_adminpepeng', id_adminpepeng);
    data.append('id_administrasi', id_administrasi);
    data.append(csrfName, $('input[name="' + csrfName + '"]').val());
    $.ajax({
      url: '<?= site_url('master-kade/adminpepeng/create/insertpendukung') ?>',
      type: 'post',
      dataType: 'json',
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function() {
        $('#file_doc_pend' + id).addClass('disable');
        $('#file_doc_pend' + id).text('uploading...');
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
    $('#formEntry').attr('action', site + 'master-kade/adminpepeng/create');
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
                  // console.log(data)
                  window.location.href = site + 'master-kade/adminpepeng/create/new-register/' + data.kode;


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

  $('#formAjukan').submit(function(e) {
    e.preventDefault();
    // var postData = $(this).serialize();
    var form = $('#formAjukan')[0];
    // get form action url
    var formActionURL = $(this).attr("action");
    $("#saveAjukan").html('<i class="fa fa-hourglass-half"></i> Diproses...');
    $("#saveAjukan").addClass('disabled');
    bootbox.dialog({
      title: "Konfirmasi",
      message: "Apakah anda ingin mengajukan permohonan ini ?",
      buttons: {
        "cancel": {
          "label": "<i class='fa fa-times'></i> Tidak",
          "className": "btn-danger",
          callback: function(response) {
            if (response) {
              $("#saveAjukan").html('<i class="fa fa-check"></i> Simpan Data');
              $("#saveAjukan").removeClass('disabled');
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
                  // console.log(data)
                  window.location.href = site + 'master-kade/adminpepeng/create/new-register/' + data.kode;
                  // $('[href="#profile1"]').tab('show');


                }
              }).fail(function() {
                $('#errEntry').html('<div class="alert alert-danger">' +
                  '<strong>Peringatan!</strong> Harap periksa kembali data yang diinputkan...' +
                  '</div>');
              }).always(function() {
                $("#saveAjukan").html('<i class="fa fa-check"></i> Simpan Data');
                $("#saveAjukan").removeClass('disabled');
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
                url: site + 'master-kade/adminpepeng/deletedokumenpendukung',
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

  //cetak laporan pdf
  $(document).on('click', '.printPdf', function(e) {
    var pepeng = $('input[name="no_registrasi"]').val();
    url = site + 'master-kade/adminpepeng/export-to-pdf?registration_number=' + pepeng;
    window.location.href = url;
  });

  jQuery(document).ready(function() {
    $(".pulsate").pulsate({
      glow: false
    });
    var id_adminpepeng = "<?php echo  !empty($data_pepeng) ? $data_pepeng['id_adminpepeng'] : '' ?>";
    if (id_adminpepeng != '') {
      $('#id_adminpepeng').val(id_adminpepeng);
      $('[href="#upload1"]').tab('show');
      $('.input1').attr('readonly', true);
    }
    var status = "<?php echo  $data_pepeng['status'] ?>";
    if (status == 'diajukan') {
      $('#status').val(status);
      $('[href="#profile1"]').tab('show');
    }

  });
  $(document).on('click', '#upload', function() {
    var id = $('#id_adminpepeng').val();
    if (id == '') {
      alert('Silahkan Isi Data Dulu')
      $('[href="#home1"]').tab('show');
    }
  });
  $(document).on('click', '#profile', function() {
    var id = $('#id_adminpepeng').val();
    var status = $('#status').val();
    if (id == '') {
      alert('Silahkan Isi Data Dulu')
      $('[href="#home1"]').tab('show');
    }

    if (status == 'belumdiajukan') {
      alert('Silahkan Upload Dokumen Dulu')
      $('[href="#upload1"]').tab('show');
    }
  });
</script>