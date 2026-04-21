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
                                    <a href="<?php echo site_url('api/equipment/qr/' . $item['qr_code']); ?>" class="btn btn-sm btn-info me-1" target="_blank">
                                        <i class="ri-eye-line me-1"></i> QR
                                    </a>
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

<script>
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
});
</script>
