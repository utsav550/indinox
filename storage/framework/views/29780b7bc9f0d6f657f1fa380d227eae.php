

<?php $__env->startSection('content'); ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&family=IBM+Plex+Sans:wght@400;500;600;700&display=swap');

    .form-wrap { max-width: 720px; }

    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 20px;
    }
    .page-title { font-size: 20px; font-weight: 700; letter-spacing: -0.02em; color: #1C1917; }
    .page-sub   { font-size: 12px; color: #A8A29E; margin-top: 2px; font-family: 'IBM Plex Mono', monospace; }

    .form-card { background: #fff; border: 1px solid #E7E5E4; border-radius: 10px; overflow: hidden; }

    .form-section { padding: 20px 24px; border-bottom: 1px solid #F5F5F4; }
    .form-section:last-child { border-bottom: none; }

    .section-title {
        font-size: 10px; font-weight: 700; letter-spacing: 0.12em;
        text-transform: uppercase; color: #A8A29E; margin-bottom: 14px;
    }

    .form-grid   { display: grid; gap: 14px; }
    .form-grid-2 { grid-template-columns: 1fr 1fr; }
    .form-group  { display: flex; flex-direction: column; gap: 5px; }

    .form-label {
        font-size: 12px; font-weight: 600; color: #57534E; letter-spacing: 0.01em;
    }

    .form-input, .form-select, .form-textarea {
        padding: 9px 12px; border: 1px solid #E7E5E4;
        border-radius: 7px; font-size: 13px; font-family: inherit;
        color: #1C1917; background: #fff; outline: none; width: 100%;
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        border-color: #E85D2F;
        box-shadow: 0 0 0 3px rgba(232, 93, 47, 0.08);
    }
    .form-textarea { resize: vertical; min-height: 80px; }

    .form-hint { font-size: 11px; color: #A8A29E; margin-top: 2px; }

    /* Status select color cues */
    .status-pending   { color: #92400E; }
    .status-assigned  { color: #1E40AF; }
    .status-delivered { color: #065F46; }
    .status-expired   { color: #991B1B; }

    .form-footer {
        padding: 16px 24px;
        display: flex; align-items: center; justify-content: space-between;
        border-top: 1px solid #F5F5F4; background: #FAFAF9;
    }

    .btn-primary {
        background: #E85D2F; color: #fff; border: none;
        padding: 9px 24px; border-radius: 7px; font-size: 13px;
        font-weight: 600; cursor: pointer; font-family: inherit;
        transition: background 0.15s;
    }
    .btn-primary:hover { background: #D4522A; }

    .btn-cancel {
        color: #78716C; font-size: 13px; font-weight: 500;
        text-decoration: none; padding: 9px 16px; border-radius: 7px;
        transition: background 0.1s;
    }
    .btn-cancel:hover { background: #F5F5F4; }

    /* Status badge preview */
    .status-preview {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 12px; border-radius: 99px; font-size: 12px; font-weight: 600;
    }
    .sp-pending   { background: #FEF3C7; color: #92400E; }
    .sp-assigned  { background: #DBEAFE; color: #1E40AF; }
    .sp-delivered { background: #D1FAE5; color: #065F46; }
    .sp-completed { background: #D1FAE5; color: #065F46; }
    .sp-expired   { background: #FEE2E2; color: #991B1B; }
    .sp-in_transit{ background: #E0E7FF; color: #3730A3; }
</style>

<div class="form-wrap">

    <div class="page-header">
        <div>
            <div class="page-title">Edit Load</div>
            <div class="page-sub">
                <?php echo e($load->pickup_location); ?> → <?php echo e($load->delivery_location); ?>

                &nbsp;·&nbsp; <?php echo e($load->customer->name ?? ''); ?>

            </div>
        </div>
        <span class="status-preview sp-<?php echo e($load->status); ?>">
            <?php echo e(ucfirst(str_replace('_',' ', $load->status))); ?>

        </span>
    </div>

    <form method="POST" action="<?php echo e(route('loads.update', $load->id)); ?>" class="form-card">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        
        <div class="form-section">
            <div class="section-title">Customer</div>
            <div class="form-group">
                <label class="form-label">Customer</label>
                <select name="customer_id" class="form-select">
                    <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($customer->id); ?>"
                            <?php echo e($customer->id == $load->customer_id ? 'selected' : ''); ?>>
                            <?php echo e($customer->name); ?><?php echo e($customer->company_name ? ' — '.$customer->company_name : ''); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        
        <div class="form-section">
            <div class="section-title">Route</div>
            <div class="form-grid form-grid-2">
                <div class="form-group">
                    <label class="form-label">Pickup Location</label>
                    <input name="pickup_location" class="form-input"
                           value="<?php echo e($load->pickup_location); ?>" placeholder="Pickup city">
                </div>
                <div class="form-group">
                    <label class="form-label">Delivery Location</label>
                    <input name="delivery_location" class="form-input"
                           value="<?php echo e($load->delivery_location); ?>" placeholder="Delivery city">
                </div>
            </div>
        </div>

        
        <div class="form-section">
            <div class="section-title">Cargo</div>
            <div class="form-grid form-grid-2">
                <div class="form-group">
                    <label class="form-label">Material</label>
                    <input name="material" class="form-input" value="<?php echo e($load->material); ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Weight (Tonnes)</label>
                    <input name="weight" type="number" step="0.1" class="form-input" value="<?php echo e($load->weight); ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Price (₹)</label>
                    <input name="price" type="number" class="form-input" value="<?php echo e($load->price); ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Expense (₹)</label>
                    <input name="expense" type="number" class="form-input" value="<?php echo e($load->expense); ?>"
                           placeholder="Trip expense">
                    <span class="form-hint">Driver cost, fuel, toll etc.</span>
                </div>
            </div>
        </div>

        
        <div class="form-section">
            <div class="section-title">Schedule</div>
            <div class="form-grid form-grid-2">
                <div class="form-group">
                    <label class="form-label">Pickup Date</label>
                    <input type="date" name="pickup_date" class="form-input"
                           value="<?php echo e($load->pickup_date); ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Pickup Time Slot</label>
                    <select name="pickup_time_slot" class="form-select">
                        <option value="">Select slot…</option>
                        <?php $__currentLoopData = [
                            'early_morning' => 'Early Morning (4AM – 8AM)',
                            'morning'       => 'Morning (8AM – 12PM)',
                            'afternoon'     => 'Afternoon (12PM – 4PM)',
                            'evening'       => 'Evening (4PM – 8PM)',
                            'night'         => 'Night (8PM – 12AM)',
                            'late_night'    => 'Late Night (12AM – 4AM)',
                        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($val); ?>" <?php echo e($load->pickup_time_slot == $val ? 'selected' : ''); ?>>
                                <?php echo e($label); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Trip Days</label>
                    <input type="number" name="trip_days" min="1" class="form-input"
                           value="<?php echo e($load->trip_days ?? 1); ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">Priority</label>
                    <select name="priority" class="form-select">
                        <?php $__currentLoopData = ['normal','high','low']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($p); ?>" <?php echo e($load->priority == $p ? 'selected' : ''); ?>>
                                <?php echo e(ucfirst($p)); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>

        
        <div class="form-section">
            <div class="section-title">Status</div>
            <div class="form-group" style="max-width:260px;">
                <label class="form-label">Load Status</label>
                <select name="status" class="form-select">
                    <?php $__currentLoopData = ['pending','assigned','in_transit','delivered','completed','expired']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s); ?>" <?php echo e($load->status == $s ? 'selected' : ''); ?>>
                            <?php echo e(ucfirst(str_replace('_',' ',$s))); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="form-hint">Changing status here will override dispatch flow</span>
            </div>
        </div>

        
        <div class="form-section">
            <div class="section-title">Notes</div>
            <div class="form-group">
                <textarea name="notes" class="form-textarea"
                          placeholder="Special instructions or requirements…"><?php echo e($load->notes); ?></textarea>
            </div>
        </div>

        
        <div class="form-footer">
            <a href="<?php echo e(route('loads.index')); ?>" class="btn-cancel">Cancel</a>
            <button type="submit" class="btn-primary">Update Load</button>
        </div>

    </form>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\utsav\indinox\resources\views/loads/edit.blade.php ENDPATH**/ ?>