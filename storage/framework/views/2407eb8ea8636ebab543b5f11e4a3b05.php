

<?php $__env->startSection('content'); ?>

<h2 class="text-xl font-bold mb-4">Customers</h2>

<a href="<?php echo e(route('customers.create')); ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
    Add Customer
</a>

<table class="w-full mt-4 bg-white shadow rounded">
    <tr class="bg-gray-200 text-left">
        <th class="p-2">Name</th>
        <th class="p-2">Phone</th>
        <th class="p-2">Email</th>
        <th class="p-2">Company</th>
        <th class="p-2">Action</th>
    </tr>

    <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr class="border-t hover:bg-gray-50">
        <td class="p-2"><?php echo e($customer->name); ?></td>
        <td class="p-2"><?php echo e($customer->phone); ?></td>
        <td class="p-2"><?php echo e($customer->email); ?></td>
        <td class="p-2"><?php echo e($customer->company_name); ?></td>
        <td class="p-2">
            <a href="<?php echo e(route('customers.edit', $customer->id)); ?>" class="text-blue-500">Edit</a>
        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</table>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\utsav\indinox\resources\views/customers/index.blade.php ENDPATH**/ ?>