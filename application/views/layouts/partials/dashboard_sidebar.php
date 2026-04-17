<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="leftside-menu">
    <a href="<?php echo site_url('dashboard'); ?>" class="logo logo-light">
        <span class="logo-lg">
            <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="logo" />
        </span>
        <span class="logo-sm">
            <img src="<?php echo base_url('assets/images/logo-sm.png'); ?>" alt="small logo" />
        </span>
    </a>

    <a href="<?php echo site_url('dashboard'); ?>" class="logo logo-dark">
        <span class="logo-lg">
            <img src="<?php echo base_url('assets/images/logo-dark.png'); ?>" alt="dark logo" />
        </span>
        <span class="logo-sm">
            <img src="<?php echo base_url('assets/images/logo-sm.png'); ?>" alt="small logo" />
        </span>
    </a>

    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>

    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <div class="leftbar-user">
            <a href="javascript:void(0);">
                <img src="<?php echo base_url('assets/images/users/avatar-1.jpg'); ?>" alt="user-image" height="42" class="rounded-circle shadow-sm">
                <span class="leftbar-user-name mt-2">Admin User</span>
            </a>
        </div>

        <ul class="side-nav">
            <li class="side-nav-title">Workspace</li>

            <li class="side-nav-item">
                <a href="<?php echo site_url('dashboard'); ?>" class="side-nav-link <?php echo $current_page === 'overview' ? 'active' : ''; ?>">
                    <i class="ri-home-4-line"></i>
                    <span> Overview </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="<?php echo site_url('dashboard/tasks'); ?>" class="side-nav-link <?php echo $current_page === 'tasks' ? 'active' : ''; ?>">
                    <i class="ri-task-line"></i>
                    <span> Tasks </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="<?php echo site_url('dashboard/reports'); ?>" class="side-nav-link <?php echo $current_page === 'reports' ? 'active' : ''; ?>">
                    <i class="ri-bar-chart-box-line"></i>
                    <span> Reports </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="<?php echo site_url('dashboard/equipment'); ?>" class="side-nav-link <?php echo $current_page === 'equipment' ? 'active' : ''; ?>">
                    <i class="ri-tools-line"></i>
                    <span> Equipment </span>
                </a>
            </li>

            <li class="side-nav-title mt-3">Quick Access</li>

            <li class="side-nav-item">
                <a href="<?php echo site_url('login'); ?>" class="side-nav-link">
                    <i class="ri-login-box-line"></i>
                    <span> Login Page </span>
                </a>
            </li>
        </ul>

        <div class="clearfix"></div>
    </div>
</div>
