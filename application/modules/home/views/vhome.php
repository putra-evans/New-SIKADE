<div class="container">
    <div class="row">
        <div class="col-md-6 col-xs-12 col-sm-6">
            <a class="info-tiles tiles-toyo" href="<?= site_url('home/halkade/index'); ?>">
                <div class="tiles-heading">PELAYANAN ADMINISTRASI KEPALA DAERAH</div>
                <div class="tiles-body-alt">
                    <div class="text-center"><i class="fa fa-bar-chart-o"></i></div>
                </div>
                <div align="center" class="tiles-footer">Klik Disini</div>
            </a>
        </div>

        <div class="col-md-6 col-xs-12 col-sm-6">
            <a class="info-tiles tiles-orange" href="<?= site_url('home/haldprd/index'); ?>">
                <div class="tiles-heading">PELAYANAN ADMINISTRASI DEWAN PERWAKILAN DAERAH</div>
                <div class="tiles-body-alt">
                    <div class="text-center"><i class="fa fa-bar-chart-o"></i></div>
                </div>
                <div align="center" class="tiles-footer">Klik Disini</div>
            </a>
        </div>

        <div class="col-md-12 col-xs-12 col-sm-6">
            <div class="panel panel-magenta">
                <div class="panel-heading"><i class="fa fa-bars"></i> SOP PELAYANAN ADMINISTRASI KEPALA DAERAH DAN PELAYANAN ADMINISTRASI DPRD </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table cellpadding="0" cellspacing="0" width="100%" border="0" class="table table-striped table-bordered basic-datatables" id="tables_checkbox">
                            <thead>
                                <tr>
                                    <th>
                                        <center>
                                            <font color="#000000">Nomor</font>
                                        </center>
                                    </th>
                                    <th>
                                        <font color="#000000">Nama Fasilitasi
                                    </th>
                                    <th>
                                        <center>
                                            <font color="#000000">File SOP</font>
                                        </center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($list_layanan as $key => $list) : ?>
                                    <tr>
                                        <td align="center"><i><?php echo $i; ?></i></td>
                                        <td><?php echo $list->nm_layanan; ?></td>
                                        <td><a href="<?= site_url('upload/sop/' . $list->sop); ?>">
                                                <font color="red"> <?php echo $list->sop; ?></font>
                                            </a></td>
                                    </tr>
                                <?php $i++;
                                endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div><!-- container -->
<script type="text/javascript">
    jQuery(document).ready(function() {
        $(".pulsate").pulsate({
            glow: false
        });
    });
</script>