<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <script>
                    document.write(new Date().getFullYear())
                </script> © <?php echo html_escape($app_name); ?>
            </div>
            <div class="col-md-6">
                <div class="text-md-end footer-links d-none d-md-block">
                    <a href="<?php echo site_url('dashboard'); ?>">Overview</a>
                    <a href="<?php echo site_url('dashboard/tasks'); ?>">Tasks</a>
                    <a href="<?php echo site_url('dashboard/reports'); ?>">Reports</a>
                </div>
            </div>
        </div>
    </div>
</footer>
