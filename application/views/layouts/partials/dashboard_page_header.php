<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo site_url('dashboard'); ?>"><?php echo html_escape($app_name); ?></a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo html_escape($breadcrumb_parent); ?></a></li>
                    <li class="breadcrumb-item active"><?php echo html_escape($page_heading); ?></li>
                </ol>
            </div>
            <h4 class="page-title mb-1"><?php echo html_escape($page_heading); ?></h4>
        </div>
    </div>
</div>
