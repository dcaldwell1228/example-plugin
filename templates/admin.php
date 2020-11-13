<div class="wrap">
    <h1>Dillon Plugin Dashboard</h1>
    <?php settings_errors(); ?>
    <br/>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-1">Manage Settings</a></li>
        <li><a href="#tab-2">Updates</a></li>
        <li><a href="#tab-3">About</a></li>
    </ul>

    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <form method="post" action="options.php">
                <?php
                    settings_fields( 'dillon_plugin_settings' );
                    do_settings_sections( 'dillon_plugin' );
                    submit_button();
                ?>
            </form>
        </div> <!-- End #tab-1 -->

        <div id="tab-2" class="tab-pane">
            <h3>Updates</h3>
        </div> <!-- End #tab-2 -->

        <div id="tab-3" class="tab-pane">
            <h3>About</h3>
        </div> <!-- End #tab-3 -->

    </div> <!-- End .tab-content -->

    
</div> <!-- End .wrap -->