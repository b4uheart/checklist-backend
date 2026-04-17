<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-12">
        <div class="card summary-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="header-title mb-1">Task Board</h4>
                    <p class="text-muted mb-0">A starter page using the same dashboard layout components.</p>
                </div>
                <button class="btn btn-primary">
                    <i class="ri-add-line me-1"></i> Add Task
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Task</th>
                                <th>Owner</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Prepare launch checklist</td>
                                <td>Rahul</td>
                                <td><span class="badge bg-danger-subtle text-danger">High</span></td>
                                <td><span class="badge bg-warning-subtle text-warning">In Progress</span></td>
                                <td>15 Apr 2026</td>
                            </tr>
                            <tr>
                                <td>Review pending approvals</td>
                                <td>Anita</td>
                                <td><span class="badge bg-primary-subtle text-primary">Medium</span></td>
                                <td><span class="badge bg-info-subtle text-info">Waiting</span></td>
                                <td>16 Apr 2026</td>
                            </tr>
                            <tr>
                                <td>Finalize dashboard widgets</td>
                                <td>Dev Team</td>
                                <td><span class="badge bg-success-subtle text-success">Normal</span></td>
                                <td><span class="badge bg-success-subtle text-success">Completed</span></td>
                                <td>18 Apr 2026</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
