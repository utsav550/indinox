

<?php $__env->startSection('content'); ?>

<h2 class="text-xl font-bold mb-4">Add Truck</h2>

<div class="flex justify-center">
<form method="POST" action="<?php echo e(route('trucks.store')); ?>" class="bg-white p-6 rounded shadow w-full max-w-lg">
    <?php echo csrf_field(); ?>

    <!-- Registration Number -->
    <label class="block mb-1 font-medium">Registration Number</label>
    <input name="registration_number" class="w-full border px-3 py-2 mb-4 rounded" required>

    <!-- Truck Type -->
    <label class="block mb-1 font-medium">Truck Type</label>
    <select name="truck_type_id" class="w-full border px-3 py-2 mb-4 rounded" required>
        <option value="">Select Truck Type</option>
        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <!-- Capacity -->
    <label class="block mb-1 font-medium">Capacity</label>
    <input name="capacity" class="w-full border px-3 py-2 mb-4 rounded">

    <!-- Ownership -->
    <label class="block mb-1 font-medium">Ownership</label>
    <select name="ownership_type" class="w-full border px-3 py-2 mb-4 rounded">
        <option value="company_owned">Company Owned</option>
        <option value="driver_owned">Driver Owned</option>
    </select>

    <!-- Status -->
    <label class="block mb-1 font-medium">Status</label>
    <select name="status" class="w-full border px-3 py-2 mb-4 rounded">
        <option value="active">Active</option>
        <option value="in_service">In Service</option>
        <option value="inoperative">Inoperative</option>
        <option value="on_hold">On Hold</option>
    </select>

    <button class="bg-blue-500 text-white px-4 py-2 rounded w-full">
        Save Truck
    </button>

</form>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\utsav\indinox\resources\views/trucks/create.blade.php ENDPATH**/ ?>