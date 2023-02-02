<?php
  $timeout = $this->expired_login->login_check();
  if($timeout === FALSE) {
    redirect('signin/timeout');
    exit();
  }
?>
<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php echo $template['partials']['header']; ?>

  </head>
  <body class="horizontal-nav " onload="updateClock()">
    <?php echo $template['partials']['title']; ?>
    <div id="page-container">
    	<?php echo $template['partials']['navigation']; ?>
      <!-- Content Wrapper. Contains page content -->
      <div id="page-content" style="background:#FFFFFF;">
        <div id='wrap'>
          <div id="page-heading" style="background:#FFFFFF;">
            <?php echo $this->breadcrumb->output(); ?><!-- /.breadcrumb -->
            <!-- <h1><?php echo $page_name; ?></h1> -->
            <!-- <div class="options">
              <div class="btn-toolbar">
                <h3 style="text-align:right;"><?php echo strtoupper($this->app_loader->current_group_name()); ?></h3>
                <p style="margin-top:-15px;font-size:16px;text-align:right;" id="showtime"><?php echo tgl_surat(date('Y-m-d H:i:s')); ?></p>
              </div>
            </div> -->
          </div>
    	    <?php echo $template['body']; ?>
        </div><!--wrap -->
      </div><!-- page-content -->
    	<?php echo $template['partials']['footer']; ?>
    </div>
    <?php echo $template['partials']['javascript']; ?>
  </body>
</html>
