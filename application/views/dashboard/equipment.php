<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if ($this->session->flashdata('success')): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php echo $this->session->flashdata('success'); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?php echo $this->session->flashdata('error'); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- Add Equipment Modal -->
<div class="modal fade" id="addEquipmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Equipment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo site_url('dashboard/add_equipment'); ?>" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Name *</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">QR Code *</label>
                                <input type="text" class="form-control" name="qr_code" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Model</label>
                                <input type="text" class="form-control" name="model">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Location</label>
                                <input type="text" class="form-control" name="location">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Manufacturer</label>
                                <input type="text" class="form-control" name="manufacturer">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status *</label>
                                <select class="form-control" name="status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="maintenance">Maintenance</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Equipment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Equipment Modal -->
<div class="modal fade" id="editEquipmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Equipment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST" id="editForm">
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Name *</label>
                                <input type="text" class="form-control" name="name" id="edit_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">QR Code *</label>
                                <input type="text" class="form-control" name="qr_code" id="edit_qr_code" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Model</label>
                                <input type="text" class="form-control" name="model" id="edit_model">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Location</label>
                                <input type="text" class="form-control" name="location" id="edit_location">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Manufacturer</label>
                                <input type="text" class="form-control" name="manufacturer" id="edit_manufacturer">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status *</label>
                                <select class="form-control" name="status" id="edit_status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="maintenance">Maintenance</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Update Equipment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- QR Code Modal -->
<div class="modal fade" id="qrModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Equipment QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div id="qrContainer">
                    <canvas id="qrCanvas" style="max-width: 300px; max-height: 300px;"></canvas>
                </div>
                <div class="mt-3">
                    <h6 id="qrName"></h6>
                    <p class="text-muted mb-0" id="qrCodeText"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printQR()">Print QR</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card summary-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="header-title mb-1">Equipment List</h4>
                    <p class="text-muted mb-0">Track issued items, stock availability, and maintenance status. Total: <?php echo count($equipment ?? []); ?> items</p>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEquipmentModal">
                    <i class="ri-add-line me-1"></i> Add Equipment
                </button>
            </div>
            <div class="card-body">
                <?php if (empty($equipment)): ?>
                    <div class="text-center py-5">
                        <i class="ri-tools-line display-1 text-muted mb-3"></i>
                        <h5 class="text-muted">No equipment found</h5>
                        <p class="text-muted">Add your first equipment to get started.</p>
                    </div>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>QR Code</th>
                                <th>Name</th>
                                <th>Model</th>
                                <th>Location</th>
                                <th>Manufacturer</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($equipment as $item): ?>
                            <tr>
                                <td><?php echo $item['id']; ?></td>
                                <td><?php echo htmlspecialchars($item['qr_code']); ?></td>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo htmlspecialchars($item['model'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($item['location'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($item['manufacturer'] ?? ''); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $item['status'] == 'active' ? 'success' : ($item['status'] == 'inactive' ? 'danger' : 'warning'); ?>">
                                        <?php echo ucfirst($item['status']); ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="<?php echo site_url('dashboard/checklist-questions/' . $item['id']); ?>" class="btn btn-sm btn-primary me-1">
                                        <i class="ri-list-check-2 me-1"></i> Questions
                                    </a>
                                    <button class="btn btn-sm btn-warning me-1 edit-btn" data-id="<?php echo $item['id']; ?>" data-name="<?php echo htmlspecialchars($item['name']); ?>" data-qr="<?php echo htmlspecialchars($item['qr_code']); ?>" data-model="<?php echo htmlspecialchars($item['model'] ?? ''); ?>" data-location="<?php echo htmlspecialchars($item['location'] ?? ''); ?>" data-manufacturer="<?php echo htmlspecialchars($item['manufacturer'] ?? ''); ?>" data-status="<?php echo $item['status']; ?>">
                                        <i class="ri-edit-line me-1"></i> Edit
                                    </button>
    <button type="button" class="btn btn-sm btn-info me-1 show-qr-btn" data-qr="<?php echo htmlspecialchars($item['qr_code']); ?>" data-name="<?php echo htmlspecialchars($item['name']); ?>" data-location="<?php echo htmlspecialchars($item['location'] ?? ''); ?>">
                                        <i class="ri-eye-line me-1"></i> QR
                                    </button>
                                    <a href="<?php echo site_url('dashboard/delete_equipment/' . $item['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">
                                        <i class="ri-delete-bin-line me-1"></i> Delete
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    @page {
        size: A4 portrait;
        margin: 1cm;
    }
    
    body * {
        visibility: hidden;
    }
    
    #qrModal .modal-body,
    #qrModal .modal-body * {
        visibility: visible !important;
    }
    
    #qrModal {
        position: absolute !important;
        left: 0;
        top: 0;
        width: 100vw !important;
        height: 100vh !important;
        padding: 20px;
        box-sizing: border-box;
    }
    
    #qrModal .modal-dialog {
        max-width: none !important;
        width: 100% !important;
        height: 100% !important;
        margin: 0 !important;
        position: static !important;
    }
    
    #qrModal .modal-content {
        height: 100% !important;
        border: none !important;
        box-shadow: none !important;
    }
    
    #qrModal .modal-header,
    #qrModal .modal-footer {
        display: none !important;
    }
    
    /* #qrModal .modal-body {
        padding: 40px !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: top !important;
        justify-content: center !important;
        height: 100% !important;
    } */
    
    #qrContainer {
        margin-bottom: 20px !important;
    }
    
    #qrContainer canvas {
        width: 400px !important;
        height: 400px !important;
        max-width: 400px !important;
        max-height: 400px !important;
    }
    
    #qrName {
        font-size: 26px !important;
        font-weight: bold !important;
        margin-bottom: 10px !important;
        text-align: center !important;
    }
    
    #qrCodeText {
        font-size: 24px !important;
        font-family: monospace !important;
    }
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode/1.4.4/qrcode.js" ></script>
<script>
function onQRCodeLoaded() {
    console.log('QRCode library loaded');
}

document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-btn');
    const editModal = document.getElementById('editEquipmentModal');
    const editForm = document.getElementById('editForm');

    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('edit_id').value = this.dataset.id;
            document.getElementById('edit_name').value = this.dataset.name;
            document.getElementById('edit_qr_code').value = this.dataset.qr;
            document.getElementById('edit_model').value = this.dataset.model; 
            document.getElementById('edit_location').value = this.dataset.location;
            document.getElementById('edit_manufacturer').value = this.dataset.manufacturer;
            document.getElementById('edit_status').value = this.dataset.status;
            editForm.action = '<?php echo site_url('dashboard/edit_equipment/'); ?>' + this.dataset.id;
            new bootstrap.Modal(editModal).show();
        });
    });

    // QR Modal functionality
    const qrButtons = document.querySelectorAll('.show-qr-btn');
    const qrModal = document.getElementById('qrModal');

    qrButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            console.log(this.dataset);   
            const qrCode = this.dataset.qr;
            const name = this.dataset.name;
            const location = this.dataset.location;
            
            document.getElementById('qrName').textContent = name;
            document.getElementById('qrCodeText').textContent = 'Location: ' + location;
            
            const canvas = document.getElementById('qrCanvas');
            
            if (typeof QRCode !== 'undefined') {
                QRCode.toCanvas(canvas, qrCode, { width: 256, margin: 1 }, function (error) {
                    if (error) console.error(error);
                });
            } else {
                canvas.getContext('2d').fillText('QRCode library not loaded yet. Try again.', 10, 50);
                console.error('QRCode not defined');
            }
            
            new bootstrap.Modal(qrModal).show();
        });
    });
});
</script>

<script>
function printQR() {
    window.print();
}
</script>
