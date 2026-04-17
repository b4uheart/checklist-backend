<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('layouts/partials/dashboard_head', array('page_title' => $page_title)); ?>
</head>

<body>
    <div class="wrapper">
        <?php
        $this->load->view('layouts/partials/dashboard_topbar', array(
            'app_name' => $app_name,
        ));
        
        $this->load->view('layouts/partials/dashboard_sidebar', array(
            'app_name' => $app_name,
            'current_page' => $current_page,
        ));
        ?>

        <div class="content-page">
            <div class="content">


                <div class="container-fluid">
                    <?php
                    $this->load->view('layouts/partials/dashboard_page_header', array(
                        'app_name' => $app_name,
                        'page_heading' => $page_heading,
                        'breadcrumb_parent' => $breadcrumb_parent,
                    ));
                    ?>
                    <?php $this->load->view($content_view); ?>
                </div>
            </div>

            <?php $this->load->view('layouts/partials/dashboard_footer', array('app_name' => $app_name)); ?>
        </div>
    </div>

    <?php $this->load->view('layouts/partials/dashboard_scripts'); ?>
</body>

</html>
