<h2>Edit Load</h2>

<form method="POST" action="<?php echo e(route('loads.update', $load->id)); ?>">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <label>Customer</label>
    <select name="customer_id">
        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($customer->id); ?>"
                <?php echo e($customer->id == $load->customer_id ? 'selected' : ''); ?>>
                <?php echo e($customer->name); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <input name="pickup_location" value="<?php echo e($load->pickup_location); ?>">
    <input name="delivery_location" value="<?php echo e($load->delivery_location); ?>">
    <input name="material" value="<?php echo e($load->material); ?>">
    <input name="weight" value="<?php echo e($load->weight); ?>">
    <input name="pickup_date" type="date" value="<?php echo e($load->pickup_date); ?>">
    <input name="price" value="<?php echo e($load->price); ?>">
    <label>Status</label>
<select name="status" class="border px-2 py-1 w-full mb-3">
    <option value="pending" <?php echo e($load->status == 'pending' ? 'selected' : ''); ?>>Pending</option>
    <option value="assigned" <?php echo e($load->status == 'assigned' ? 'selected' : ''); ?>>Assigned</option>
    <option value="in_transit" <?php echo e($load->status == 'in_transit' ? 'selected' : ''); ?>>In Transit</option>
    <option value="delivered" <?php echo e($load->status == 'delivered' ? 'selected' : ''); ?>>Delivered</option>
</select>
    <input name="expense" value="<?php echo e($load->expense); ?>" class="w-full border px-3 py-2 mb-4 rounded">

    <button type="submit">Update Load</button>
</form><?php /**PATH C:\Users\utsav\indinox\resources\views/loads/edit.blade.php ENDPATH**/ ?>