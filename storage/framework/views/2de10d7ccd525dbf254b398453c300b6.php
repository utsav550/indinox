

<?php $__env->startSection('content'); ?>

<h2 class="text-xl font-bold mb-4">Drivers</h2>

<a href="<?php echo e(route('drivers.create')); ?>" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
    Add Driver
</a>

<table class="w-full mt-4 bg-white shadow rounded">
    <tr class="bg-gray-200 text-left">
        <th class="p-2">Name</th>
        <th class="p-2">Phone</th>
        <th class="p-2">License</th>
        <th class="p-2">Action</th>
    </tr>

    <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr class="border-t hover:bg-gray-50">
        <td class="p-2"><?php echo e($driver->name); ?></td>
        <td class="p-2"><?php echo e($driver->phone); ?></td>
        <td class="p-2"><?php echo e($driver->license_number); ?></td>
        <td class="p-2">
            <!-- Future edit option -->
            <span class="text-gray-400 text-sm">-</span>
        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</table>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\utsav\indinox\resources\views/drivers/index.blade.php ENDPATH**/ ?>