<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-12">
        <div class="card summary-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="header-title mb-1">Equipment List</h4>
                    <p class="text-muted mb-0">Track issued items, stock availability, and maintenance status.</p>
                </div>
                <a href="javascript:void(0);" class="btn btn-primary">
                    <i class="ri-add-line me-1"></i> Add Equipment
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Equipment ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Assigned To</th>
                                <th>Status</th>
                                <th>Condition</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>EQ-001</td>
                                <td>Laptop Dell Latitude 5440</td>
                                <td>Computers</td>
                                <td>Rahul Sharma</td>
                                <td><span class="badge bg-success-subtle text-success">In Use</span></td>
                                <td>Good</td>
                                <td class="text-end">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-light">
                                        <i class="ri-edit-line me-1"></i> Edit Equipment
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>EQ-002</td>
                                <td>Projector Epson EB-X06</td>
                                <td>Presentation</td>
                                <td>Meeting Room A</td>
                                <td><span class="badge bg-primary-subtle text-primary">Available</span></td>
                                <td>Excellent</td>
                                <td class="text-end">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-light">
                                        <i class="ri-edit-line me-1"></i> Edit Equipment
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>EQ-003</td>
                                <td>Barcode Scanner Honeywell</td>
                                <td>Accessories</td>
                                <td>Store Desk</td>
                                <td><span class="badge bg-warning-subtle text-warning">Maintenance</span></td>
                                <td>Needs Check</td>
                                <td class="text-end">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-light">
                                        <i class="ri-edit-line me-1"></i> Edit Equipment
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>EQ-004</td>
                                <td>Office Printer HP LaserJet</td>
                                <td>Printers</td>
                                <td>Accounts Team</td>
                                <td><span class="badge bg-info-subtle text-info">Reserved</span></td>
                                <td>Good</td>
                                <td class="text-end">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-light">
                                        <i class="ri-edit-line me-1"></i> Edit Equipment
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
