

<?php $__env->startSection('content'); ?>

<h2 class="text-xl font-bold mb-4">Add Driver</h2>

<div class="flex justify-center">
<form method="POST" action="<?php echo e(route('drivers.store')); ?>" class="bg-white p-6 rounded shadow w-full max-w-lg">
    <?php echo csrf_field(); ?>

    <!-- Name -->
    <label class="block mb-1 font-medium">Driver Name</label>
    <input name="name" class="w-full border px-3 py-2 mb-4 rounded">

    <!-- Phone -->
    <label class="block mb-1 font-medium">Phone</label>
    <input name="phone" class="w-full border px-3 py-2 mb-4 rounded">

    <!-- License -->
    <label class="block mb-1 font-medium">License Number</label>
    <input name="license_number" class="w-full border px-3 py-2 mb-4 rounded">

    <!-- Submit -->
    <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded w-full">
        Save Driver
    </button>

</form>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\utsav\indinox\resources\views/drivers/create.blade.php ENDPATH**/ ?>