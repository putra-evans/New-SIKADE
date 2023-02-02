<nav class="navbar navbar-default yamm" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <i class="fa fa-bars"></i>
            </button>
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse" id="horizontal-navbar">
            <ul class="nav navbar-nav">
               <?php echo $this->app_loader->create_menu(); ?>
            </ul>
        </div>
    </nav>