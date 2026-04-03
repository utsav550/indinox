

<?php $__env->startSection('content'); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC65AaWhsi_FNGW6KY7WXFoA-YB41UQhyI&libraries=places"></script>

<h2 class="text-xl font-bold mb-4">Create Load</h2>

<div class="flex justify-center">
<form method="POST" action="<?php echo e(route('loads.store')); ?>" class="bg-white p-6 rounded shadow w-full max-w-lg">
    <?php echo csrf_field(); ?>

    <!-- Customer -->
    <label class="block mb-1 font-medium">Customer</label>
    <select name="customer_id" class="w-full border px-3 py-2 mb-4 rounded">
        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($customer->id); ?>"><?php echo e($customer->name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <!-- Pickup -->
    <label class="block mb-1 font-medium">Pickup Location</label>
    <input id="pickup_location" name="pickup_address" class="w-full border px-3 py-2 mb-4 rounded">

    <input type="hidden" name="pickup_lat" id="pickup_lat">
    <input type="hidden" name="pickup_lng" id="pickup_lng">
    <input type="hidden" name="pickup_city" id="pickup_city"> <!-- ✅ NEW -->

    <!-- Delivery -->
    <label class="block mb-1 font-medium">Delivery Location</label>
    <input id="delivery_location" name="delivery_address" class="w-full border px-3 py-2 mb-4 rounded">

    <input type="hidden" name="delivery_lat" id="delivery_lat">
    <input type="hidden" name="delivery_lng" id="delivery_lng">
    <input type="hidden" name="delivery_city" id="delivery_city"> <!-- ✅ NEW -->

    <!-- Material -->
    <label class="block mb-1 font-medium">Material</label>
    <input name="material" class="w-full border px-3 py-2 mb-4 rounded">

    <!-- Weight -->
    <label class="block mb-1 font-medium">Weight</label>
    <input name="weight" class="w-full border px-3 py-2 mb-4 rounded">

    <!-- Date -->
    <label class="block mb-1 font-medium">Pickup Date</label>
    <input type="date" name="pickup_date" class="w-full border px-3 py-2 mb-4 rounded">

    <label class="block mb-1 font-medium">Pickup Time Slot</label>
    <select name="pickup_time_slot" class="w-full border px-3 py-2 mb-4 rounded" required>
        <option value="">Select Time Slot</option>
        <option value="early_morning">Early Morning (4AM–8AM)</option>
        <option value="morning">Morning (8AM–12PM)</option>
        <option value="afternoon">Afternoon (12PM–4PM)</option>
        <option value="evening">Evening (4PM–8PM)</option>
        <option value="night">Night (8PM–12AM)</option>
        <option value="late_night">Late Night (12AM–4AM)</option>
    </select>

    <!-- Price -->
    <label class="block mb-1 font-medium">Price</label>
    <input name="price" class="w-full border px-3 py-2 mb-4 rounded">

    <!-- Truck Type -->
    <label class="block mb-1 font-medium">Truck Type Required</label>
    <select name="truck_type_required_id" class="w-full border px-3 py-2 mb-4 rounded">
        <option value="">Select Type</option>
        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <!-- Priority -->
    <label class="block mb-1 font-medium">Priority</label>
    <select name="priority" class="w-full border px-3 py-2 mb-4 rounded">
        <option value="normal">Normal</option>
        <option value="high">High</option>
        <option value="low">Low</option>
    </select>

    <!-- Trip Days -->
    <label class="block mb-1 font-medium">Trip Days</label>
    <input type="number" name="trip_days" value="1" class="w-full border px-3 py-2 mb-4 rounded">

    <!-- Notes -->
    <label class="block mb-1 font-medium">Notes</label>
    <textarea name="notes" class="w-full border px-3 py-2 mb-4 rounded"></textarea>

    <!-- Submit -->
    <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded w-full">
        Save Load
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

function initAutocomplete() {

    // PICKUP
    const pickupInput = document.getElementById('pickup_location');
    const pickupAutocomplete = new google.maps.places.Autocomplete(pickupInput);

    pickupAutocomplete.addListener('place_changed', function () {
        const place = pickupAutocomplete.getPlace();

        if (!place.geometry) {
            alert("Please select a valid pickup location");
            pickupInput.value = '';
            return;
        }

        document.getElementById('pickup_lat').value = place.geometry.location.lat();
        document.getElementById('pickup_lng').value = place.geometry.location.lng();

        // ✅ STORE CITY (NOT overwrite input)
        document.getElementById('pickup_city').value = getCityFromPlace(place);
    });

    // DELIVERY
    const deliveryInput = document.getElementById('delivery_location');
    const deliveryAutocomplete = new google.maps.places.Autocomplete(deliveryInput);

    deliveryAutocomplete.addListener('place_changed', function () {
        const place = deliveryAutocomplete.getPlace();

        if (!place.geometry) {
            alert("Please select a valid delivery location");
            deliveryInput.value = '';
            return;
        }

        document.getElementById('delivery_lat').value = place.geometry.location.lat();
        document.getElementById('delivery_lng').value = place.geometry.location.lng();

        // ✅ STORE CITY
        document.getElementById('delivery_city').value = getCityFromPlace(place);
    });
}

google.maps.event.addDomListener(window, 'load', initAutocomplete);
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\utsav\indinox\resources\views/loads/create.blade.php ENDPATH**/ ?>