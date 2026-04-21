<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-12">
        <div class="card summary-card">
            <div class="card-header">
                <h4 class="header-title mb-1">Monthly Equipment Checklist Report</h4>
                <p class="text-muted mb-0">This view follows the same checklist structure as `print_equipment`, but stays inside the dashboard for screen review.</p>
            </div>
            <div class="card-body">
                <form method="GET" action="<?php echo site_url('dashboard/reports'); ?>" class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label for="equipment_id" class="form-label">Equipment</label>
                        <select name="equipment_id" id="equipment_id" class="form-select">
                            <?php if (empty($equipment)): ?>
                                <option value="">No equipment available</option>
                            <?php else: ?>
                                <?php foreach ($equipment as $item): ?>
                                    <option value="<?php echo (int) $item['id']; ?>" <?php echo (int) $selected_equipment_id === (int) $item['id'] ? 'selected' : ''; ?>>
                                        <?php echo html_escape($item['name']); ?><?php echo !empty($item['qr_code']) ? ' (' . html_escape($item['qr_code']) . ')' : ''; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="month" class="form-label">Month</label>
                        <select name="month" id="month" class="form-select">
                            <?php for ($month = 1; $month <= 12; $month++): ?>
                                <option value="<?php echo $month; ?>" <?php echo (int) $selected_month === $month ? 'selected' : ''; ?>>
                                    <?php echo date('F', mktime(0, 0, 0, $month, 1)); ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="year" class="form-label">Year</label>
                        <input type="number" min="2000" max="2100" name="year" id="year" class="form-control" value="<?php echo (int) $selected_year; ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ri-filter-3-line me-1"></i> View Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card summary-card">
            <div class="card-header d-flex justify-content-between align-items-start flex-wrap gap-2">
                <div>
                    <h4 class="header-title mb-1">
                        <?php echo $selected_equipment ? html_escape($selected_equipment['name']) : 'Equipment report'; ?>
                    </h4>
                    <p class="text-muted mb-0">
                        <?php if ($selected_equipment): ?>
                            <?php echo html_escape($month_name); ?> <?php echo (int) $selected_year; ?> checklist overview
                            <?php if (!empty($selected_equipment['location'])): ?>
                                | Location: <?php echo html_escape($selected_equipment['location']); ?>
                            <?php endif; ?>
                            <?php if (!empty($selected_equipment['model'])): ?>
                                | Model: <?php echo html_escape($selected_equipment['model']); ?>
                            <?php endif; ?>
                        <?php else: ?>
                            Select equipment to see its monthly checklist report.
                        <?php endif; ?>
                    </p>
                </div>
                <?php if ($selected_equipment): ?>
                    <div class="text-md-end">
                        <a
                            href="<?php echo site_url('dashboard/print-equipment?equipment_id=' . (int) $selected_equipment_id . '&month=' . (int) $selected_month . '&year=' . (int) $selected_year); ?>"
                            class="btn btn-primary btn-sm mb-2"
                            target="_blank"
                        >
                            <i class="ri-printer-line me-1"></i> Print Report
                        </a>
                        <br>
                        <span class="badge bg-<?php echo ($selected_equipment['status'] ?? '') === 'active' ? 'success' : (($selected_equipment['status'] ?? '') === 'inactive' ? 'danger' : 'warning'); ?>">
                            <?php echo html_escape(ucfirst($selected_equipment['status'] ?? 'unknown')); ?>
                        </span>
                        <?php if (!empty($selected_equipment['qr_code'])): ?>
                            <div class="text-muted small mt-2">QR: <?php echo html_escape($selected_equipment['qr_code']); ?></div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <?php if (empty($equipment)): ?>
                    <div class="text-center py-5">
                        <i class="ri-file-list-3-line display-1 text-muted mb-3"></i>
                        <h5 class="text-muted">No equipment found</h5>
                        <p class="text-muted mb-0">Add equipment first, then this report will show its monthly checklist history.</p>
                    </div>
                <?php elseif (!$selected_equipment): ?>
                    <div class="text-center py-5">
                        <i class="ri-search-eye-line display-1 text-muted mb-3"></i>
                        <h5 class="text-muted">Equipment not found</h5>
                        <p class="text-muted mb-0">The selected equipment could not be loaded.</p>
                    </div>
                <?php elseif (empty($questions)): ?>
                    <div class="text-center py-5">
                        <i class="ri-file-warning-line display-1 text-muted mb-3"></i>
                        <h5 class="text-muted">No checklist questions available</h5>
                        <p class="text-muted mb-0">This equipment does not have checklist questions yet.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm align-middle text-center mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="min-width: 70px;">Sl.N</th>
                                    <th class="text-start" style="min-width: 280px;">Description</th>
                                    <?php for ($day = 1; $day <= $days_in_month; $day++): ?>
                                        <th style="min-width: 44px;"><?php echo $day; ?></th>
                                    <?php endfor; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sn = 1; ?>
                                <?php foreach ($questions as $item): ?>
                                    <tr>
                                        <td><?php echo $sn++; ?></td>
                                        <td class="text-start"><?php echo html_escape($item['question']); ?></td>
                                        <?php for ($day = 1; $day <= $days_in_month; $day++): ?>
                                            <?php
                                            $value = isset($dataMap[$item['id']][$day]) ? $dataMap[$item['id']][$day] : '';
                                            $symbol = '';
                                            $class = 'text-muted';

                                            if ($value === 'comply') {
                                                $symbol = '&#10004;';
                                                $class = 'text-success fw-bold';
                                            } elseif ($value === 'non-comply') {
                                                $symbol = '&#10006;';
                                                $class = 'text-danger fw-bold';
                                            }
                                            ?>
                                            <td class="<?php echo $class; ?>"><?php echo $symbol; ?></td>
                                        <?php endfor; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row g-3 mt-3">
                        <div class="col-md-4">
                            <div class="border rounded-3 p-3 h-100">
                                <h5 class="mb-2">Comply</h5>
                                <p class="text-muted mb-0">A green check mark shows the completed response was marked as comply for that day.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded-3 p-3 h-100">
                                <h5 class="mb-2">Non-Comply</h5>
                                <p class="text-muted mb-0">A red cross shows the completed response was marked as non-comply for that day.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded-3 p-3 h-100">
                                <h5 class="mb-2">Blank Cell</h5>
                                <p class="text-muted mb-0">Blank cells mean there was no completed inspection response stored for that checklist item on that day.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
