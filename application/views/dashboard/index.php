<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-12">
        <div class="card hero-card mb-4">
            <div class="card-body p-4 p-lg-5">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <span class="badge bg-light text-primary mb-3">Shared layout ready</span>
                        <h2 class="mb-3 text-white">Your dashboard shell is now reusable across every internal page.</h2>
                        <p class="mb-4 text-white-50">We can keep adding modules like users, projects, and settings without rebuilding the header, sidebar, or footer each time.</p>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="<?php echo site_url('dashboard/tasks'); ?>" class="btn btn-light text-primary fw-semibold">Open Tasks</a>
                            <a href="<?php echo site_url('dashboard/reports'); ?>" class="btn btn-outline-light">View Reports</a>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-4 mt-lg-0">
                        <div class="bg-white bg-opacity-10 rounded-4 p-4">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-white-50">Completion rate</span>
                                <span class="text-white fw-semibold">84%</span>
                            </div>
                            <div class="progress progress-sm bg-white bg-opacity-25">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 84%"></div>
                            </div>
                            <div class="row text-center mt-4">
                                <div class="col-6">
                                    <h3 class="text-white mb-1">128</h3>
                                    <p class="text-white-50 mb-0">Open tasks</p>
                                </div>
                                <div class="col-6">
                                    <h3 class="text-white mb-1">18</h3>
                                    <p class="text-white-50 mb-0">Teams active</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-md-6">
        <div class="card summary-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1">Tasks Due Today</p>
                        <h3 class="mb-1">24</h3>
                        <p class="text-success mb-0"><i class="ri-arrow-up-line"></i> 12% from yesterday</p>
                    </div>
                    <span class="metric-icon bg-primary-subtle text-primary">
                        <i class="ri-calendar-check-line"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card summary-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1">Pending Reviews</p>
                        <h3 class="mb-1">09</h3>
                        <p class="text-warning mb-0"><i class="ri-time-line"></i> 3 blocked items</p>
                    </div>
                    <span class="metric-icon bg-warning-subtle text-warning">
                        <i class="ri-file-list-3-line"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card summary-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1">Team Efficiency</p>
                        <h3 class="mb-1">91%</h3>
                        <p class="text-success mb-0"><i class="ri-line-chart-line"></i> Strong weekly trend</p>
                    </div>
                    <span class="metric-icon bg-success-subtle text-success">
                        <i class="ri-speed-up-line"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-7">
        <div class="card summary-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="header-title mb-0">Recent Activity</h4>
                <a href="<?php echo site_url('dashboard/tasks'); ?>" class="btn btn-sm btn-light">Manage Tasks</a>
            </div>
            <div class="card-body">
                <div class="d-flex mb-4">
                    <span class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-primary-subtle text-primary rounded-circle">
                            <i class="ri-check-double-line"></i>
                        </span>
                    </span>
                    <div class="ms-3">
                        <h5 class="mt-0 mb-1">Sprint planning checklist updated</h5>
                        <p class="text-muted mb-0">Operations team completed 7 of 9 planning items for the next release.</p>
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <span class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-warning-subtle text-warning rounded-circle">
                            <i class="ri-alert-line"></i>
                        </span>
                    </span>
                    <div class="ms-3">
                        <h5 class="mt-0 mb-1">Approval waiting on finance review</h5>
                        <p class="text-muted mb-0">Two procurement tasks are paused until budget signoff is complete.</p>
                    </div>
                </div>
                <div class="d-flex">
                    <span class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-success-subtle text-success rounded-circle">
                            <i class="ri-team-line"></i>
                        </span>
                    </span>
                    <div class="ms-3">
                        <h5 class="mt-0 mb-1">New teammate assigned</h5>
                        <p class="text-muted mb-0">Maya Patel joined the website refresh workspace and picked up 4 onboarding tasks.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-5">
        <div class="card summary-card">
            <div class="card-header">
                <h4 class="header-title mb-0">Upcoming Deadlines</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                        <h5 class="mb-1">Client status report</h5>
                        <p class="text-muted mb-0">Due today at 5:00 PM</p>
                    </div>
                    <span class="badge bg-danger-subtle text-danger">Urgent</span>
                </div>
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                        <h5 class="mb-1">QA handoff checklist</h5>
                        <p class="text-muted mb-0">Due tomorrow</p>
                    </div>
                    <span class="badge bg-warning-subtle text-warning">Review</span>
                </div>
                <div class="d-flex justify-content-between align-items-center py-2">
                    <div>
                        <h5 class="mb-1">Quarterly planning board</h5>
                        <p class="text-muted mb-0">Due in 3 days</p>
                    </div>
                    <span class="badge bg-success-subtle text-success">On track</span>
                </div>
            </div>
        </div>
    </div>
</div>
