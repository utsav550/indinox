

<?php $__env->startSection('content'); ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&family=IBM+Plex+Sans:wght@400;500;600;700&display=swap');
    .mono { font-family: 'IBM Plex Mono', monospace; }

    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 20px;
    }

    .page-title {
        font-size: 20px; font-weight: 700; letter-spacing: -0.02em; color: #1C1917;
    }

    .btn-primary {
        background: #E85D2F; color: #fff; border: none;
        padding: 8px 18px; border-radius: 7px; font-size: 13px;
        font-weight: 600; text-decoration: none; cursor: pointer;
        transition: background 0.15s; display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-primary:hover { background: #D4522A; }

    /* FILTERS */
    .filter-bar {
        display: flex; gap: 8px; margin-bottom: 16px; align-items: center; flex-wrap: wrap;
    }

    .filter-input {
        padding: 7px 12px; border: 1px solid #E7E5E4; border-radius: 7px;
        font-size: 13px; font-family: inherit; background: #fff;
        outline: none; transition: border 0.15s;
    }
    .filter-input:focus { border-color: #E85D2F; }

    .filter-select {
        padding: 7px 12px; border: 1px solid #E7E5E4; border-radius: 7px;
        font-size: 13px; font-family: inherit; background: #fff;
        outline: none; cursor: pointer; transition: border 0.15s;
    }
    .filter-select:focus { border-color: #E85D2F; }

    /* TABLE */
    .loads-table {
        width: 100%; border-collapse: separate; border-spacing: 0;
        background: #fff; border-radius: 10px;
        border: 1px solid #E7E5E4; overflow: hidden;
        font-size: 13px;
    }

    .loads-table thead tr {
        background: #FAFAF9;
    }

    .loads-table th {
        padding: 10px 14px; text-align: left;
        font-size: 10px; font-weight: 700; letter-spacing: 0.1em;
        text-transform: uppercase; color: #A8A29E;
        border-bottom: 1px solid #E7E5E4; white-space: nowrap;
    }

    .loads-table td {
        padding: 11px 14px; border-bottom: 1px solid #F5F5F4;
        color: #1C1917; vertical-align: middle;
    }

    .loads-table tbody tr:last-child td { border-bottom: none; }

    .loads-table tbody tr:hover td { background: #FAFAF9; }

    /* Priority border */
    .loads-table tbody tr.pri-high td:first-child { border-left: 3px solid #EF4444; }
    .loads-table tbody tr.pri-normal td:first-child { border-left: 3px solid #E7E5E4; }
    .loads-table tbody tr.pri-low td:first-child { border-left: 3px solid #93C5FD; }

    /* PILLS */
    .pill {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 2px 9px; border-radius: 99px;
        font-size: 11px; font-weight: 600; letter-spacing: 0.03em;
        white-space: nowrap;
    }
    .pill-pending   { background: #FEF3C7; color: #92400E; }
    .pill-assigned  { background: #DBEAFE; color: #1E40AF; }
    .pill-expired   { background: #FEE2E2; color: #991B1B; }
    .pill-delivered { background: #D1FAE5; color: #065F46; }
    .pill-completed { background: #D1FAE5; color: #065F46; }
    .pill-in_transit{ background: #E0E7FF; color: #3730A3; }

    .pill-high   { background: #FEE2E2; color: #991B1B; }
    .pill-normal { background: #F3F4F6; color: #374151; }
    .pill-low    { background: #EFF6FF; color: #1D4ED8; }

    .slot-pill { background: #F5F5F4; color: #57534E; }

    .dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; flex-shrink: 0; }

    /* ROUTE */
    .route-cell { display: flex; flex-direction: column; gap: 2px; }
    .route-main { font-weight: 600; color: #1C1917; }
    .route-sub  { font-size: 11px; color: #A8A29E; font-family: 'IBM Plex Mono', monospace; }

    /* ACTION */
    .action-link {
        color: #6B7280; font-size: 12px; font-weight: 500;
        text-decoration: none; padding: 4px 10px; border-radius: 5px;
        border: 1px solid #E7E5E4; transition: all 0.1s;
    }
    .action-link:hover { background: #F5F5F4; color: #1C1917; border-color: #D6D3D1; }

    .empty-state {
        text-align: center; padding: 60px 20px; color: #A8A29E;
    }
    .empty-state .icon { font-size: 36px; margin-bottom: 10px; }
    .empty-state .label { font-weight: 600; color: #78716C; font-size: 15px; }
    .empty-state .sub   { font-size: 13px; margin-top: 4px; }
</style>

<div class="page-header">
    <div>
        <div class="page-title">Loads</div>
        <div style="font-size:12px; color:#A8A29E; margin-top:2px; font-family:'IBM Plex Mono',monospace;">
            <?php echo e($loads->count()); ?> loads found
        </div>
    </div>
    <a href="<?php echo e(route('loads.create')); ?>" class="btn-primary">+ New Load</a>
</div>


<form method="GET" action="<?php echo e(route('loads.index')); ?>" class="filter-bar">
    <input type="text" name="search" placeholder="Search customer…"
           value="<?php echo e(request('search')); ?>" class="filter-input" style="width:200px;">

    <select name="status" class="filter-select" onchange="this.form.submit()">
        <option value="">All Statuses</option>
        <option value="pending"   <?php echo e(request('status')=='pending'   ? 'selected':''); ?>>Pending</option>
        <option value="assigned"  <?php echo e(request('status')=='assigned'  ? 'selected':''); ?>>Assigned</option>
        <option value="in_transit"<?php echo e(request('status')=='in_transit'? 'selected':''); ?>>In Transit</option>
        <option value="delivered" <?php echo e(request('status')=='delivered' ? 'selected':''); ?>>Delivered</option>
        <option value="expired"   <?php echo e(request('status')=='expired'   ? 'selected':''); ?>>Expired</option>
    </select>

    <?php if(request('search') || request('status')): ?>
        <a href="<?php echo e(route('loads.index')); ?>" style="font-size:12px; color:#A8A29E; text-decoration:none; padding:7px 10px;">✕ Clear</a>
    <?php endif; ?>
</form>


<table class="loads-table">
    <thead>
        <tr>
            <th>Customer</th>
            <th>Route</th>
            <th>Pickup Date</th>
            <th>Truck Type</th>
            <th>Time Slot</th>
            <th>Price</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Notes</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $loads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $load): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
            $priClass = match($load->priority ?? 'normal') {
                'high' => 'pri-high', 'low' => 'pri-low', default => 'pri-normal'
            };
            $statusPill = 'pill-' . ($load->status ?? 'pending');

            $slotLabels = [
                'early_morning' => 'Early Morning',
                'morning'       => 'Morning',
                'afternoon'     => 'Afternoon',
                'evening'       => 'Evening',
                'night'         => 'Night',
                'late_night'    => 'Late Night',
            ];
        ?>
        <tr class="<?php echo e($priClass); ?>">

            
            <td>
                <div style="font-weight:600;"><?php echo e($load->customer->name ?? '—'); ?></div>
                <?php if($load->customer->company_name ?? false): ?>
                    <div style="font-size:11px; color:#A8A29E;"><?php echo e($load->customer->company_name); ?></div>
                <?php endif; ?>
            </td>

            
            <td>
                <div class="route-cell">
                    <div class="route-main"><?php echo e($load->pickup_location); ?> → <?php echo e($load->delivery_location); ?></div>
                    <div class="route-sub"><?php echo e($load->material); ?> · <?php echo e($load->weight); ?>T</div>
                </div>
            </td>

            
            <td class="mono" style="white-space:nowrap; color:#57534E;">
                <?php echo e(\Carbon\Carbon::parse($load->pickup_date)->format('d M Y')); ?>

            </td>

            
            <td style="color:#57534E;"><?php echo e($load->truckType->name ?? '—'); ?></td>

            
            <td>
                <span class="pill slot-pill">
                    <?php echo e($slotLabels[$load->pickup_time_slot] ?? ucfirst(str_replace('_',' ',$load->pickup_time_slot ?? '—'))); ?>

                </span>
            </td>

            
            <td class="mono" style="font-weight:600;">
                ₹<?php echo e(number_format($load->price)); ?>

            </td>

            
            <td>
                <span class="pill pill-<?php echo e($load->priority ?? 'normal'); ?>">
                    <?php echo e(ucfirst($load->priority ?? 'normal')); ?>

                </span>
            </td>

            
            <td>
                <span class="pill <?php echo e($statusPill); ?>">
                    <?php echo e(ucfirst(str_replace('_',' ', $load->status ?? 'pending'))); ?>

                </span>
            </td>

            
            <td style="max-width:160px; color:#78716C; font-size:12px;">
                <?php echo e($load->notes ? \Illuminate\Support\Str::limit($load->notes, 40) : '—'); ?>

            </td>

            
            <td>
                <a href="<?php echo e(route('loads.edit', $load->id)); ?>" class="action-link">Edit</a>
            </td>

        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="10">
                <div class="empty-state">
                    <div class="icon">📦</div>
                    <div class="label">No loads found</div>
                    <div class="sub">Try adjusting your filters or add a new load</div>
                </div>
            </td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\utsav\indinox\resources\views/loads/index.blade.php ENDPATH**/ ?>