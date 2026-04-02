

<?php $__env->startSection('content'); ?>

<h2 class="text-xl font-bold mb-4">Loads</h2>

<a href="<?php echo e(route('loads.create')); ?>" class="bg-blue-500 text-white px-4 py-2 rounded">Add Load</a>

<table class="w-full mt-4 bg-white shadow">
    <tr class="bg-gray-200">
        <th class="p-2">Customer</th>
<th class="p-2">Pickup</th>
<th class="p-2">Delivery</th>
<th class="p-2">Price</th>
<th class="p-2">Truck Type</th>
<th class="p-2">Pickup Slot</th>
<th class="p-2">Priority</th>
<th class="p-2">Status</th>
<th class="p-2">Notes</th>
<th class="p-2">Action</th>
        
    </tr>

    <?php $__currentLoopData = $loads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $load): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr class="border-t">
       <tr class="border-t">
    <td class="p-2 text-center"><?php echo e($load->customer->name); ?></td>
    <td class="p-2 text-center"><?php echo e($load->pickup_location); ?></td>
    <td class="p-2 text-center"><?php echo e($load->delivery_location); ?></td>
    <td class="p-2 text-center"><?php echo e($load->price); ?></td>

    <td class="p-2 text-center">
        <?php echo e($load->truckType->name ?? 'N/A'); ?>

    </td>

    <td class="p-2 text-center">
    <?php
        $slot = $load->pickup_time_slot;
    ?>

    <?php if($slot == 'early_morning'): ?>
        <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded-full text-xs">Early Morning</span>

    <?php elseif($slot == 'morning'): ?>
        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs">Morning</span>

    <?php elseif($slot == 'afternoon'): ?>
        <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded-full text-xs">Afternoon</span>

    <?php elseif($slot == 'evening'): ?>
        <span class="bg-pink-100 text-pink-700 px-2 py-1 rounded-full text-xs">Evening</span>

    <?php elseif($slot == 'night'): ?>
        <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full text-xs">Night</span>

    <?php elseif($slot == 'late_night'): ?>
        <span class="bg-gray-200 text-gray-800 px-2 py-1 rounded-full text-xs">Late Night</span>
    <?php endif; ?>
</td>

    <td class="p-2 text-center">
    <?php if($load->priority == 'high'): ?>
        <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-semibold">
            High
        </span>

    <?php elseif($load->priority == 'normal'): ?>
        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-semibold">
            Normal
        </span>

    <?php elseif($load->priority == 'low'): ?>
        <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs font-semibold">
            Low
        </span>
    <?php endif; ?>
</td>

    <td class="p-2 text-center">
        <?php if($load->status == 'pending'): ?>
            <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded">Pending</span>
        <?php elseif($load->status == 'assigned'): ?>
            <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded">Assigned</span>
        <?php elseif($load->status == 'expired'): ?>
    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Expired</span>
<?php endif; ?>
    </td>

    <td class="p-2 text-center">
        <?php echo e($load->notes ?? '-'); ?>

    </td>

    <td class="p-2 text-center">
        <a href="<?php echo e(route('loads.edit', $load->id)); ?>" class="text-blue-500">Edit</a>
    </td>
</tr>

    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\utsav\indinox\resources\views/loads/index.blade.php ENDPATH**/ ?>