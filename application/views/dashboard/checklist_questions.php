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

<div class="row">
    <div class="col-12">
        <div class="card summary-card">
            <div class="card-header d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div>
                    <h4 class="header-title mb-1"><?php echo html_escape($equipment_item['name']); ?></h4>
                    <p class="text-muted mb-0">
                        Manage checklist questions for this equipment.
                        <?php if (!empty($equipment_item['model'])): ?>
                            Model: <?php echo html_escape($equipment_item['model']); ?>
                        <?php endif; ?>
                        <?php if (!empty($equipment_item['location'])): ?>
                            | Location: <?php echo html_escape($equipment_item['location']); ?>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?php echo site_url('dashboard/equipment'); ?>" class="btn btn-light">
                        <i class="ri-arrow-left-line me-1"></i> Back
                    </a>
                    <a href="<?php echo site_url('dashboard/reports?equipment_id=' . (int) $equipment_item['id']); ?>" class="btn btn-primary">
                        <i class="ri-bar-chart-box-line me-1"></i> View Report
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="card summary-card">
            <div class="card-header">
                <h4 class="header-title mb-0">Add Question</h4>
            </div>
            <div class="card-body">
                <form action="<?php echo site_url('dashboard/checklist-questions/' . $equipment_item['id'] . '/add'); ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Question *</label>
                        <textarea name="question" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Order</label>
                        <input type="number" name="order_index" class="form-control" value="<?php echo count($questions) + 1; ?>" min="0">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ri-add-line me-1"></i> Add Question
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card summary-card">
            <div class="card-header">
                <h4 class="header-title mb-1">Existing Questions</h4>
                <p class="text-muted mb-0">Total: <?php echo count($questions); ?> questions</p>
            </div>
            <div class="card-body">
                <?php if (empty($questions)): ?>
                    <div class="text-center py-5">
                        <i class="ri-file-warning-line display-1 text-muted mb-3"></i>
                        <h5 class="text-muted">No checklist questions found</h5>
                        <p class="text-muted mb-0">Add the first question for this equipment from the form on the left.</p>
                    </div>
                <?php else: ?>
                    <div class="accordion" id="questionsAccordion">
                        <?php foreach ($questions as $index => $question): ?>
                            <div class="accordion-item mb-3 border rounded">
                                <h2 class="accordion-header" id="heading-<?php echo (int) $question['id']; ?>">
                                    <button class="accordion-button <?php echo $index === 0 ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo (int) $question['id']; ?>">
                                        <span class="me-2 badge bg-light text-dark">#<?php echo (int) $question['order_index']; ?></span>
                                        <span><?php echo html_escape($question['question']); ?></span>
                                    </button>
                                </h2>
                                <div id="collapse-<?php echo (int) $question['id']; ?>" class="accordion-collapse collapse <?php echo $index === 0 ? 'show' : ''; ?>" data-bs-parent="#questionsAccordion">
                                    <div class="accordion-body">
                                        <form action="<?php echo site_url('dashboard/checklist-questions/' . $equipment_item['id'] . '/edit/' . $question['id']); ?>" method="POST">
                                            <div class="mb-3">
                                                <label class="form-label">Question *</label>
                                                <textarea name="question" class="form-control" rows="3" required><?php echo html_escape($question['question']); ?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Order</label>
                                                <input type="number" name="order_index" class="form-control" value="<?php echo (int) $question['order_index']; ?>" min="0">
                                            </div>
                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="submit" class="btn btn-warning">
                                                    <i class="ri-save-line me-1"></i> Update
                                                </button>
                                                <a href="<?php echo site_url('dashboard/checklist-questions/' . $equipment_item['id'] . '/delete/' . $question['id']); ?>" class="btn btn-danger" onclick="return confirm('Delete this checklist question?');">
                                                    <i class="ri-delete-bin-line me-1"></i> Delete
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
