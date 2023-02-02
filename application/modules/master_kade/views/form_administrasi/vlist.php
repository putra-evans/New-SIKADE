<div class="container">
  <div class="row" id="formParent">
    <div class="col-xs-12 col-sm-12">
      <div class="btn-toolbar" style="margin-bottom: 15px">
        <a type="button" href="<?php echo site_url('master-data/administrasi'); ?>" class="btn btn-inverse" name="button" style="padding:12px 16px;"><b><i class="fa fa-table"></i> Data administrasi </b></a>
        <button type="button" class="btn btn-primary-alt" id="btnAdd" style="padding:11px 16px;"><b><i class="fa fa-plus"></i> Tambah Baru</b></button>
      </div>
    </div>
    <div class="col-xs-12 col-sm-12">
      <?php echo $this->session->flashdata('message'); ?>
      <div id="errSuccess"></div>
    </div>
    <div class="col-xs-12 col-sm-12">
      <div class="row">
        <div class="col-xs-12 col-sm-12">
          <div class="pull-left">
            <h3 style="font-weight:bold;text-align:left;">
              <a href="javascript:void(0);" class="btnFilter" style="text-decoration:none;color:#000000;">
                <i class="fa fa-sliders"></i> Filter Data
              </a>
            </h3>
          </div>
          
        </div>
        <div class="col-xs-12 col-sm-12">
          <?php echo form_open(site_url('#'), array('id'=>'formFilter', 'style'=>'display:none;margin-bottom:20px;')); ?>
            <div style="display:block;background:#FFF;padding:20px;border:1px solid #CCC;box-shadow:0px 0px 10px #CCC;">
              <div class="row">
                <div class="col-xs-12 col-sm-9">
                  <div class="form-group">
                    <label style="font-size:16px;"><b>Pilih Instansi</b></label>
                    <?php echo form_dropdown('id_instansi', $nm_instansi, $this->input->post('id_instansi', TRUE), 'class="select-all"'); ?>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                  <div class="form-group">
                    <label style="font-size:16px;"><b>Pilih Status</b></label>
                    <?php echo form_dropdown('status', array(''=>'Pilih Status', 1=>'Aktif', 0=>'Tidak Aktif'), $this->input->post('status'), 'class="select-all" id="status_id"');?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12">
                  <div class="pull-left">
                    <div class="btn-toolbar">
                      <button type="submit" class="btn btn-primary" name="filter" id="filter"><i class="fa fa-filter"></i> LAKUKAN PENCARIAN</button>
                      <button type="button" class="btn btn-danger" name="cancel" id="cancel"><i class="fa fa-refresh"></i> CANCEL</button>
                    </div>
                  </div>
                  <div class="pull-right">
                    <div class="btn-toolbar">
                      <button type="button" class="btn btn-default btnFilter" name="button"><i class="fa fa-times"></i> CLOSE</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
    <div class="col-xs-12 col-sm-12">
      <div class="panel panel-green">
        <div class="panel-heading">
          <h4>Daftar administrasi</h4>
        </div>
        <div class="panel-body collapse in">
          <div class="table-responsive">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="tbladministrasi" width="100%">
              <thead>
                <tr>
                  <th width="3%">#</th>
                  <th width="10%">Tipe administrasi</th>
                  <th width="15%">Nama administrasi</th>
                  <th width="30%">Nama Instansi</th>
                  <th width="3%">status</th>
                  <th width="3%">Action</th>
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
        <h4 class="modal-title"><b>FORM ENTRI DATA administrasi</b></h4>
      </div>
      <?php echo form_open(site_url('master/administrasi/create'), array('id' => 'formEntry')); ?>
      <div class="modal-body" style="padding:15px 15px 5px 15px;">
        <div id="errEntry"></div>

        <div class="row">
          <?php echo form_hidden('tokenId', ''); ?>
          <div class="col-xs-12 col-sm-4">
            <div class="form-group required">
              <label for="nama_administrasi" class="control-label"><b>Nama administrasi <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="nama_administrasi" id="nama_administrasi" placeholder="Nama administrasi" value="<?php echo $this->input->post('nama_administrasi', TRUE); ?>">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-8">
            <div class="form-group required">
              <label for="id_instansi" class="control-label"><b>Instansi <font color="red">*</font></b></label>
              <?php echo form_dropdown('id_instansi', $nm_instansi, $this->input->post('id_instansi'), 'class="select-all" id="id_instansi"');?>
              <div class="help-block"></div>
            </div>
          </div>
        </div>


        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label for="id_type" class="control-label"><b>Tipe administrasi<font color="red">*</font></b></label>
              <?php echo form_dropdown('id_type', $name_type, $this->input->post('id_type'), 'class="select-all" id="id_type"');?>
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label for="status" class="control-label"><b>Status<font color="red">*</font></b></label>
              <?php echo form_dropdown('status', status(), $this->input->post('status'), 'class="select-all" id="status"');?>
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
  var csrfName  = '<?php echo $this->security->get_csrf_token_name(); ?>';
  var site      = '<?php echo site_url();?>';
  var regeID = '', distID = '', villID = '';

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

  $(document).ready(function(e){
    getDataListRumahSakit();
  });

  $(document).on('click', '.btnFilter', function(e){
    $('#formFilter').slideToggle('slow');
    $('.select-all').select2('val', '');
  });

  $(document).on('click', '#cancel', function(e){
    e.preventDefault();
    $('.select-all').select2('val', '');
    getDataListRumahSakit();
  });

  $('#formFilter').submit(function(e){
    e.preventDefault();
    getDataListRumahSakit();
  });

  function getDataListRumahSakit() {
    $('#tbladministrasi').dataTable({
      "destroy": true,
      "processing":true,
      "language": {
        "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
      },
      "serverSide": true,
      "ordering": false,
      "ajax": {
        "url": site + "master-data/administrasi/listview",
        "type": "POST",
        "data": {
          "param" : $('#formFilter').serializeArray(),
          "<?php echo $this->security->get_csrf_token_name(); ?>" : $('input[name="'+csrfName+'"]').val()
        },
      },
      "columnDefs": [
        {
          "targets": [ 0 ], //first column
          "className": "text-center",
          "orderable": false, //set not orderable
        },
        {
          "targets": [ 4 ], //last column
          "className": "text-center",
          "orderable": false, //set not orderable
        },
        {
          "targets": [ 5 ], //last column
          "className": "text-center",
          "orderable": false, //set not orderable
        },
        {
          "targets": [ -1 ], //last column
          "orderable": false, //set not orderable
        },
      ],
    });
    $('#tbladministrasi_filter input').addClass('form-control').attr('placeholder','Search Data');
    $('#tbladministrasi_length select').addClass('form-control');
  }

  //panggil form Entri
  $(document).on('click', '#btnAdd', function(e){
    formReset();
    $('#modalEntryForm').modal({
      backdrop: 'static'
    });
  });

  //close form entri
  $(document).on('click', '.btnClose', function(e) {
    formReset();
    $('#modalEntryForm').modal('toggle');
  });

  function formReset() {
    $('#formEntry').attr('action', site + 'master-data/administrasi/create');
    $('#errEntry').html('');
    $('.select-all').select2('val', '');
    $('#status').select2('val', 1);
    $('.help-block').text('');
    $('.required').removeClass('has-error');
    $('form#formEntry').trigger('reset');
    regeID = ''; distID = ''; villID = '';
  }

  $('#formEntry').submit(function(e) {
    e.preventDefault();
    var postData = $(this).serialize();
    // get form action url
    var formActionURL = $(this).attr("action");
    $("#save").html('<i class="fa fa-hourglass-half"></i> DIPROSES...');
    $("#save").addClass('disabled');
    run_waitMe($('#frmEntry'));
    bootbox.dialog({
      title: "Konfirmasi",
      message: "Apakah anda ingin menyimpan data administrasi ini ?",
      buttons: {
        "cancel" : {
          "label" : "<i class='fa fa-times'></i> Tidak",
          "className" : "btn-danger",
          callback:function(response){
            if (response) {
              $("#save").html('<i class="fa fa-check"></i> SUBMIT');
              $("#save").removeClass('disabled');
              $('#frmEntry').waitMe('hide');
            }
          }
        },
        "main" : {
          "label" : "<i class='fa fa-check'></i> Ya, Lanjutkan",
          "className" : "btn-primary",
          callback:function(response){
            if (response) {
              $.ajax({
                url: formActionURL,
                type: "POST",
                data: postData,
                dataType: "json",
              }).done(function(data) {
                $('input[name="'+csrfName+'"]').val(data.csrfHash);
                $('.help-block').text('');
                $('.required').removeClass('has-error');
                if(data.status == 0) {
                  $('#errEntry').html('<div class="alert alert-danger" id="pesanErr"><strong>Peringatan!</strong> Tolong dilengkapi form inputan dibawah...</div>');
                  $.each(data.message, function(key,value){
                    if(key != 'isi')
                      $('input[name="'+key+'"], select[name="'+key+'"]').closest('div.required').addClass('has-error').find('div.help-block').text(value);
                    else {
                      $('#pesanErr').html('<strong>Peringatan!</strong> ' +value);
                    }
                  });
                  $('#modalEntryForm').animate({
                    scrollTop: (data.message.isi) ? 0 : ($('.has-error').find('input, select').first().focus().offset().top-300)
                  }, 'slow');
                } else {
                  $('#errSuccess').html('<div class="alert alert-dismissable alert-success">'+
                                          '<strong>Sukses!</strong> '+ data.message +
                                          '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                                        '</div>');
                  $('#modalEntryForm').modal('toggle');
                  getDataListRumahSakit();
                }
                $('#frmEntry').waitMe('hide');
              }).fail(function() {
                $('#errEntry').html('<div class="alert alert-danger">'+
                                     '<strong>Peringatan!</strong> Harap periksa kembali data yang diinputkan...'+
                                    '</div>');
                $('#frmEntry').waitMe('hide');
              }).always(function() {
                $("#save").html('<i class="fa fa-check"></i> SUBMIT');
                $("#save").removeClass('disabled');
              });
            }
          }
        }
      }
    });
  });

  $(document).on('click', '.btnEdit', function(e){
    formReset();
    $('#formEntry').attr('action', site + 'master-data/administrasi/update');
    var token = $(this).data('id');
    $('#modalEntryForm').modal({
      backdrop: 'static'
    });
    getDataadministrasi(token);
  });

  function getDataadministrasi(token) {
    run_waitMe($('#frmEntry'));
    $.ajax({
      type: 'POST',
      url: site + 'master-data/administrasi/details',
      data: {'token' : token, '<?php echo $this->security->get_csrf_token_name(); ?>' : $('input[name="'+csrfName+'"]').val()},
      dataType: 'json',
      success: function(data) {
        $('input[name="'+csrfName+'"]').val(data.csrfHash);
        if(data.status == 1) {
          $('input[name="tokenId"]').val(token);
          $('#id_type').select2('val', data.message.type);
          $('#nama_administrasi').val(data.message.nama_administrasi);
          $('#id_instansi').select2('val', data.message.instansi);
          $('#status').select2('val', data.message.status);
        }
        $('#frmEntry').waitMe('hide');
      }
    });
  }

  $(document).on('click', '.btnDelete', function(e){
    e.preventDefault();
    var postData = {
      'tokenId': $(this).data('id'),
      '<?php echo $this->security->get_csrf_token_name(); ?>' : $('input[name="'+csrfName+'"]').val()
    };
    $(this).html('<i class="fa fa-hourglass-half"></i>');
    $(this).addClass('disabled');
    run_waitMe($('#formParent'));
    bootbox.dialog({
      title: "Konfirmasi",
      message: "Apakah anda ingin menghapus data administrasi ini ?",
      buttons: {
        "cancel" : {
          "label" : "<i class='fa fa-times'></i> Tidak",
          "className" : "btn-danger",
          callback:function(response) {
            if (response) {
              $('.btnDelete').html('<i class="fa fa-times"></i>');
              $('.btnDelete').removeClass('disabled');
              $('#formParent').waitMe('hide');
            }
          }
        },
        "main" : {
          "label" : "<i class='fa fa-check'></i> Ya, Lanjutkan",
          "className" : "btn-primary",
          callback:function(response){
            if (response) {
              $.ajax({
                url: site + 'master-data/administrasi/delete',
                type: "POST",
                data: postData,
                dataType: "json",
              }).done(function(data) {
                $('input[name="'+csrfName+'"]').val(data.csrfHash);
                if(data.status == 0) {
                  $('#errSuccess').html('<div class="alert alert-danger">'+
                                         '<strong>Informasi!</strong> '+ data.message +
                                        '</div>');
                } else {
                  $('#errSuccess').html('<div class="alert alert-dismissable alert-success">'+
                                          '<strong>Sukses!</strong> '+ data.message +
                                          '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                                       '</div>');
                  getDataListRumahSakit();
                }
                $('#formParent').waitMe('hide');
              }).fail(function() {
                $('#errSuccess').html('<div class="alert alert-danger">'+
                                      '<strong>Peringatan!</strong> Proses delete data gagal...'+
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
