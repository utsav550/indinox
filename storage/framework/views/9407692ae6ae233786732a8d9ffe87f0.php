

<?php $__env->startSection('content'); ?>

<h2 class="text-xl font-bold mb-4">Trucks</h2>

<a href="<?php echo e(route('trucks.create')); ?>" class="bg-blue-500 text-white px-4 py-2 rounded">
    Add Truck
</a>

<table class="w-full mt-4 bg-white shadow">
    <tr class="bg-gray-200 text-left">
    <th class="p-2">Truck Code</th>
    <th class="p-2">Registration</th>
    <th class="p-2">Type</th>
    <th class="p-2">Capacity</th>
    <th class="p-2">Ownership</th>
    <th class="p-2">Status</th>
    <th class="p-2">Action</th>
</tr>

    <?php $__currentLoopData = $trucks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $truck): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
   <tr class="border-t">
    <td class="p-2"><?php echo e($truck->truck_code); ?></td>
    <td class="p-2"><?php echo e($truck->registration_number); ?></td>
    <td class="p-2"><?php echo e($truck->type->name ?? ''); ?></td>
    <td class="p-2"><?php echo e($truck->capacity); ?></td>
    <td class="p-2 capitalize">
        <?php echo e(str_replace('_', ' ', $truck->ownership_type)); ?>

    </td>

    <td class="p-2">
        <?php if($truck->status == 'active'): ?>
            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Active</span>
        <?php elseif($truck->status == 'in_service'): ?>
            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">In Service</span>
        <?php elseif($truck->status == 'inoperative'): ?>
            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Inoperative</span>
        <?php elseif($truck->status == 'on_hold'): ?>
            <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs">On Hold</span>
        <?php endif; ?>
    </td>
    <td class="p-2">
    <a href="<?php echo e(route('trucks.edit', $truck->id)); ?>" class="text-blue-500">
        Edit
    </a>
</td>
</tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</table>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\utsav\indinox\resources\views/trucks/index.blade.php ENDPATH**/ ?>