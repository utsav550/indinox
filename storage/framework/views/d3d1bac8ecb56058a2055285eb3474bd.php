

<?php $__env->startSection('content'); ?>

<h1 class="text-2xl font-bold mb-4">Dashboard</h1>

<div class="grid grid-cols-4 gap-4">
    <div class="bg-white p-4 shadow">Total Loads: <?php echo e($totalLoads); ?></div>
    <div class="bg-white p-4 shadow">Delivered: <?php echo e($deliveredLoads); ?></div>
    <div class="bg-white p-4 shadow">Pending: <?php echo e($pendingLoads); ?></div>
    <div class="bg-white p-4 shadow">Revenue: ₹<?php echo e($totalRevenue); ?></div>
    <div class="bg-white p-4 shadow">Total Expense: ₹<?php echo e($totalExpense); ?></div>
    <div class="bg-white p-4 shadow">Total Profit: ₹<?php echo e($totalProfit); ?></div>
    

<div class="bg-white p-4 shadow rounded">
    <h2 class="text-xl font-bold mb-4 center">Driver Profits</h2>
    <?php $__currentLoopData = $driverProfits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="flex justify-between border-b py-2">
            <span><?php echo e($data['driver']); ?></span>

            <span class="
                <?php echo e($data['profit'] >= 0 ? 'text-green-600' : 'text-red-600'); ?>

            ">
                ₹<?php echo e($data['profit']); ?>

            </span>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\utsav\indinox\resources\views/dashboard.blade.php ENDPATH**/ ?>