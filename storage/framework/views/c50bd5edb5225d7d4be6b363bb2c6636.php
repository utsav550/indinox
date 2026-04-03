

<?php $__env->startSection('content'); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC65AaWhsi_FNGW6KY7WXFoA-YB41UQhyI&libraries=places"></script>


<h2 class="text-xl font-bold mb-4">Edit Truck</h2>

<div class="flex justify-center">
<form method="POST" action="<?php echo e(route('trucks.update', $truck->id)); ?>" class="bg-white p-6 rounded shadow w-full max-w-lg">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <!-- Registration Number -->
    <label class="block mb-1 font-medium">Registration Number</label>
    <input name="registration_number" value="<?php echo e($truck->registration_number); ?>" class="w-full border px-3 py-2 mb-4 rounded">

    <!-- Truck Type -->
    <label class="block mb-1 font-medium">Truck Type</label>
    <select name="truck_type_id" class="w-full border px-3 py-2 mb-4 rounded">
        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($type->id); ?>" <?php echo e($truck->truck_type_id == $type->id ? 'selected' : ''); ?>>
                <?php echo e($type->name); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <!-- Capacity -->
    <label class="block mb-1 font-medium">Capacity</label>
    <input name="capacity" value="<?php echo e($truck->capacity); ?>" class="w-full border px-3 py-2 mb-4 rounded">

    <!-- Ownership -->
    <label class="block mb-1 font-medium">Ownership</label>
    <select name="ownership_type" class="w-full border px-3 py-2 mb-4 rounded">
        <option value="company_owned" <?php echo e($truck->ownership_type == 'company_owned' ? 'selected' : ''); ?>>Company Owned</option>
        <option value="driver_owned" <?php echo e($truck->ownership_type == 'driver_owned' ? 'selected' : ''); ?>>Driver Owned</option>
    </select>

    <!-- Driver Assignment -->
    <label class="block mb-1 font-medium">Assign Driver</label>
<select name="driver_id" class="w-full border px-3 py-2 mb-4 rounded">
    <option value="">-- Select Driver --</option>
    
    <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($driver->id); ?>"
            <?php echo e($truck->driver_id == $driver->id ? 'selected' : ''); ?>>
            <?php echo e($driver->name); ?> (<?php echo e($driver->phone); ?>)
        </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
    <!-- Status -->
    <label class="block mb-1 font-medium">Status</label>
    <select name="status" class="w-full border px-3 py-2 mb-4 rounded">
        <option value="active" <?php echo e($truck->status == 'active' ? 'selected' : ''); ?>>Active</option>
        <option value="in_service" <?php echo e($truck->status == 'in_service' ? 'selected' : ''); ?>>In Service</option>
        <option value="inoperative" <?php echo e($truck->status == 'inoperative' ? 'selected' : ''); ?>>Inoperative</option>
        <option value="on_hold" <?php echo e($truck->status == 'on_hold' ? 'selected' : ''); ?>>On Hold</option>
    </select>
    <!-- 📍 Current Location -->
<label class="block mb-1 font-medium">Current Location</label>
<input id="truck_location" name="current_location"
       value="<?php echo e($truck->current_location); ?>"
       class="w-full border px-3 py-2 mb-4 rounded">

<input type="hidden" name="current_lat" id="current_lat" value="<?php echo e($truck->current_lat); ?>">
<input type="hidden" name="current_lng" id="current_lng" value="<?php echo e($truck->current_lng); ?>">

    <button class="bg-blue-500 text-white px-4 py-2 rounded w-full">
        Update Truck
    </button>

</form>
</div>
<script>
function getCityFromPlace(place) {
    let city = '';

    for (const component of place.address_components) {
        if (component.types.includes('locality')) {
            city = component.long_name;
        }
    }

    if (!city) {
        for (const component of place.address_components) {
            if (component.types.includes('administrative_area_level_2')) {
                city = component.long_name;
            }
        }
    }

    return city;
}

function initTruckAutocomplete() {
    const input = document.getElementById('truck_location');
    const autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.addListener('place_changed', function () {
        const place = autocomplete.getPlace();

        if (!place.geometry) {
            alert("Please select a valid location");
            input.value = '';
            return;
        }

        document.getElementById('current_lat').value = place.geometry.location.lat();
        document.getElementById('current_lng').value = place.geometry.location.lng();

        input.value = getCityFromPlace(place);
    });
}

google.maps.event.addDomListener(window, 'load', initTruckAutocomplete);
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\utsav\indinox\resources\views/trucks/edit.blade.php ENDPATH**/ ?>