<div class="container">
  <div class="row" id="formParent">
    <div class="col-xs-12 col-sm-12">
      <div class="btn-toolbar" style="margin-bottom: 15px">
        <a type="button" class="btn btn-primary" style="padding:11px 16px;" href="<?= site_url('master-kade/adminpepeng/create/new-register'); ?>"><b><i class="fa fa-plus"></i> Tambah Baru </b></a>
      </div>
    </div>
    <div class="col-xs-12 col-sm-12">
      <?php echo $this->session->flashdata('message'); ?>
      <div id="errSuccess"></div>
    </div>
    <div class="col-xs-12 col-sm-12">
      <div class="panel panel-inverse">
        <div class="panel-heading">
          <h4>Daftar administrasi pengesahan pengangkatan dan pemberhentian KDH</h4>
        </div>
        <div class="panel-body collapse in">
          <div class="table-responsive">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="tbladministrasi" width="100%">
              <thead>
                <tr>
                  <th width="3%">#</th>
                  <th width="10%">Nama Lengkap</th>
                  <th width="10%">NIK</th>
                  <th width="15%">Alamat Anda</th>
                  <th width="15%">Pemda/Lembaga/Umum</th>
                  <th width="10%">File Upload</th>
                  <th width="15%">Kabupaten/Kota</th>
                  <!-- <th width="7%">status Upload</th> -->
                  <th width="7%">status Permohonan</th>
                  <th width="10%">Keterangan Permohonan</th>
                  <th width="10%">Action</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><!-- container -->

<div class="modal fade in" id="modalEntryForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" id="frmEntry">
    <div class="modal-content">
      <div class="modal-header" style="padding:10px 15px 10px 15px;">
        <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><b>FORM ENTRI UPLOAD DATA PENDUKUNG</b></h4>
      </div>
      <?php echo form_open_multipart(site_url('master-kade/adminpepeng/create-pendukung'), array('id' => 'formEntry')); ?>
      <div class="modal-body" style="padding:15px 15px 5px 15px;">
        <div id="errEntry"></div>

        <div class="row">
          <?php echo form_hidden('id_adminpepeng', ''); ?>

          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label for="nama_file" class="control-label"><b>Nama File <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="nama_file" id="nama_file" placeholder="Nama File" value="<?php echo $this->input->post('nama_file', TRUE); ?>">
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label for="status" class="control-label"><b>File Pendukung<font color="red">*</font></b></label>
              <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="input-group">
                  <div class="form-control uneditable-input" data-trigger="fileinput">
                    <i class="fa fa-file fileinput-exists"></i>&nbsp;<span class="fileinput-filename"></span>
                  </div>
                  <span class="input-group-addon btn btn-green btn-file">
                    <span class="fileinput-new">Pilih file</span>
                    <span class="fileinput-exists">Change</span>
                    <input type="file" name="file_pendukung" id="file_pendukung">
                  </span>
                  <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                </div>
                <a id="filependukung"></a>
              </div>
              <div class="help-block"></div>
            </div>
          </div>


        </div>

      </div>
      <div class="modal-footer" style="margin-top:0px;padding:10px 15px 15px 0px;">
        <button type="button" class="btn btn-default btnClose" style="padding:12px 16px;"><i class="fa fa-times"></i> CANCEL</button>
        <button type="submit" class="btn btn-primary" name="save" id="save" style="padding:12px 16px;"><i class="fa fa-check"></i> SUBMIT</button>
      </div>
      <?php echo form_close(); ?>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
  $.fn.modal.Constructor.prototype.enforceFocus = function() {};
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
  var site = '<?php echo site_url(); ?>';

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

  $(document).on('click', '.btnUpload', function(e) {
    formReset();
    $('#formEntry').attr('action', site + 'master-kade/adminpepeng/create-pendukung');
    var idAdmin = $(this).data('id');
    $('#modalEntryForm').modal({
      backdrop: 'static'
    });
    $('input[name="id_adminpepeng"]').val(idAdmin);
    // getDataGedung(token);
  });

  //close form entri
  $(document).on('click', '.btnClose', function(e) {
    formReset();
    $('#modalEntryForm').modal('toggle');
  });

  function formReset() {
    $('#formEntry').attr('action', site + 'master-kade/adminpepeng/create-pendukung');
    $('#errEntry').html('');
    $('#nama_file').val('');
    $('#file_pendukung').val('');
    $('.fileinput').removeClass('fileinput-exists').addClass('fileinput-new');
    $('.help-block').text('');
    $('.required').removeClass('has-error');
    $('.fileinput-filename').text('');
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
                  $('#modalEntryForm').animate({
                    scrollTop: (data.message.isi) ? 0 : ($('.has-error').find('input, select').first().focus().offset().top - 300)
                  }, 'slow');
                } else {
                  $('#errSuccess').html('<div class="alert alert-dismissable alert-success">' +
                    '<strong>Sukses!</strong> ' + data.message +
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                    '</div>');
                  $('#modalEntryForm').modal('toggle');
                  getDataListadminpepeng();
                  formReset();
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


  $(document).ready(function(e) {
    getDataListadminpepeng();
  });

  $(document).on('click', '#cancel', function(e) {
    e.preventDefault();
    $('.select-all').select2('val', '');
    getDataListadminpepeng();
  });

  $('#formFilter').submit(function(e) {
    e.preventDefault();
    getDataListadminpepeng();
  });

  function getDataPendukung(token) {
    console.log(token);
    // run_waitMe($('#frmEntry'));
    // $.ajax({
    //   type: 'POST',
    //   url: site + 'master-kade/admincuka/details',
    //   data: {'token' : token, '<?php //echo $this->security->get_csrf_token_name(); 
                                  ?>' : $('input[name="'+csrfName+'"]').val()},
    //   dataType: 'json',
    //   success: function(data) {
    //     $('input[name="'+csrfName+'"]').val(data.csrfHash);
    //     if(data.status == 1) {
    //       $('input[name="tokenId"]').val(token);
    //       $('#nama_file').val(data.message.nama_file);
    //       $('#filependukung').text(data.message.pendukung);
    //       $('#status').select2('val', data.message.status);
    //     }
    //     $('#frmEntry').waitMe('hide');
    //   }
    // });
  }

  function getDataListadminpepeng() {
    $('#tbladministrasi').dataTable({
      "destroy": true,
      "processing": true,
      "language": {
        "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
      },
      "serverSide": true,
      "ordering": false,
      "ajax": {
        "url": site + "master-kade/adminpepeng/listview",
        "type": "POST",
        "data": {
          "param": $('#formFilter').serializeArray(),
          "<?php echo $this->security->get_csrf_token_name(); ?>": $('input[name="' + csrfName + '"]').val()
        },
      },
      "columnDefs": [{
          "targets": [0], //first column
          "className": "text-center",
          "orderable": false, //set not orderable
        },
        {
          "targets": [7], //first column
          "className": "text-center",
          "orderable": false, //set not orderable
        },
        {
          "targets": [8], //first column
          "className": "text-center",
          "orderable": false, //set not orderable
        },
        {
          "targets": [-1], //last column
          "orderable": false, //set not orderable
        },
      ],
    });
    $('#tbladministrasi_filter input').addClass('form-control').attr('placeholder', 'Search Data');
    $('#tbladministrasi_length select').addClass('form-control');
  }


  $(document).on('click', '.btnDelete', function(e) {
    e.preventDefault();
    var postData = {
      'tokenId': $(this).data('id'),
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
                url: site + 'master-kade/adminpepeng/delete',
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
                  getDataListadminpepeng();
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