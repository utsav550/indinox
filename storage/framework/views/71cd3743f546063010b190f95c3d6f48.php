

<?php $__env->startSection('content'); ?>

<div class="flex h-screen bg-gray-100">

    <!-- STATUS PANEL -->
    <div class="w-48 bg-white border-r p-4">
        <h3 class="font-semibold mb-4">Status</h3>

        <a href="/dispatch?status=all"
   class="block px-3 py-2 rounded <?php echo e($status == 'all' ? 'bg-gray-200 font-semibold' : ''); ?>">
    All (<?php echo e($counts['all']); ?>)
</a>

<a href="/dispatch?status=pending"
   class="block px-3 py-2 rounded <?php echo e($status == 'pending' ? 'bg-gray-200 font-semibold' : ''); ?>">
    Pending (<?php echo e($counts['pending']); ?>)
</a>

<a href="/dispatch?status=assigned"
   class="block px-3 py-2 rounded <?php echo e($status == 'assigned' ? 'bg-gray-200 font-semibold' : ''); ?>">
    Assigned (<?php echo e($counts['assigned']); ?>)
</a>

<a href="/dispatch?status=in_transit"
   class="block px-3 py-2 rounded <?php echo e($status == 'in_transit' ? 'bg-gray-200 font-semibold' : ''); ?>">
    In Transit (<?php echo e($counts['in_transit']); ?>)
</a>

<a href="/dispatch?status=delivered"
   class="block px-3 py-2 rounded <?php echo e($status == 'delivered' ? 'bg-gray-200 font-semibold' : ''); ?>">
    Delivered (<?php echo e($counts['delivered']); ?>)
</a>
<a href="/dispatch?status=expired"
   class="block px-3 py-2 rounded <?php echo e($status == 'expired' ? 'bg-red-100 font-semibold text-red-700' : ''); ?>">
    Expired (<?php echo e($counts['expired'] ?? 0); ?>)
</a>

    </div>

    <!-- MAIN -->
    <div class="flex-1 overflow-y-auto p-6 space-y-4">

        <?php $__currentLoopData = $loads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $load): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <div x-data="{ open: false }"
             class="rounded-xl shadow p-4
             <?php echo e($load->is_today ? 'bg-red-100' : ($load->is_tomorrow ? 'bg-yellow-100' : 'bg-green-50')); ?>">

            <!-- COLLAPSED -->
            <div @click="open = !open" class="flex justify-between items-center cursor-pointer">

                <div>
                    <div class="font-semibold text-lg">
                        <?php echo e($load->pickup_date); ?> • <?php echo e(ucfirst($load->pickup_time_slot ?? '')); ?>

                        • <?php echo e($load->route); ?>

                    </div>

                    <div class="text-sm text-gray-600">
                        <?php echo e($load->customer_name); ?> • <?php echo e($load->material_display); ?>

                    </div>

                    <div class="text-sm mt-1">
                        ₹<?php echo e($load->price_display); ?> • <?php echo e($load->truck_type_name); ?>

                        • <?php echo e(ucfirst($load->status)); ?>

                    </div>
                </div>

                <button class="text-blue-600 font-medium">
                    <span x-text="open ? 'Collapse' : 'Expand'"></span>
                </button>
            </div>

            <!-- EXPANDED -->
            <div x-show="open" x-transition class="mt-6 border-t pt-4 space-y-6">

                <!-- TOP -->
                <div class="grid grid-cols-2 gap-4">

                    <!-- LEFT -->
                    <div class="bg-white p-4 rounded shadow text-sm space-y-1">
                        <p><strong>Customer:</strong> <?php echo e($load->customer_name); ?></p>
                        <p><strong>Pickup:</strong> <?php echo e($load->pickup_date); ?> (<?php echo e(ucfirst($load->pickup_time_slot ?? '')); ?>)</p>
                        <p><strong>Delivery:</strong> <?php echo e($load->delivery_date); ?></p>
                        <p><strong>Route:</strong> <?php echo e($load->route); ?></p>
                        <p><strong>Material:</strong> <?php echo e($load->material); ?></p>
                        <p><strong>Weight:</strong> <?php echo e($load->weight); ?></p>
                        <p><strong>Price:</strong> ₹<?php echo e($load->price_display); ?></p>
                        <p><strong>Priority:</strong> <?php echo e(ucfirst($load->priority ?? 'normal')); ?></p>

                        <?php if($load->notes): ?>
                            <p class="text-red-500"><strong>Note:</strong> <?php echo e($load->notes); ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- RIGHT (MAP PLACEHOLDER) -->
                    <div class="bg-gray-200 rounded flex items-center justify-center text-sm text-gray-600">
                        Map Coming Soon
                    </div>
                </div>

                <!-- TRUCKS -->
                <div x-data="{ selectedTruck: null }">

                    <h4 class="font-semibold mb-3">
                        Truck Type Required: <?php echo e($load->truck_type_name); ?>

                    </h4>

                    <div class="flex gap-3 overflow-x-auto">

                        <?php $__empty_1 = true; $__currentLoopData = $load->suggestedTrucks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $truck): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                            <div
                                @click="selectedTruck = <?php echo e($truck->id); ?>"
                                :class="selectedTruck === <?php echo e($truck->id); ?> 
                                    ? 'border-blue-600 ring-2 ring-blue-300' 
                                    : 'border-gray-200'"
                                class="min-w-[180px] bg-white p-3 rounded shadow cursor-pointer border transition">

                                <div class="font-semibold"><?php echo e($truck->truck_code); ?></div>

                                <div class="text-sm mt-1">
                                    <?php if($truck->status == 'available'): ?>
                                        🟢 Available
                                    <?php elseif($truck->status == 'reaching'): ?>
                                        🔵 <?php echo e($truck->eta); ?>

                                    <?php else: ?>
                                        🟣 <?php echo e($truck->eta); ?>

                                    <?php endif; ?>
                                </div>

                            </div>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-sm text-gray-500">
                                No trucks available
                            </div>
                        <?php endif; ?>

                    </div>

                    <!-- ASSIGN -->
                    <div class="mt-5 flex justify-between items-center">

                        <div class="text-sm">
                            Driver: <strong>Auto Assigned</strong>
                        </div>

                        <form method="POST" action="<?php echo e(route('dispatch.assign', $load->id)); ?>">
                            <?php echo csrf_field(); ?>

                            <input type="hidden" name="truck_id" :value="selectedTruck">

                            <button 
                                :disabled="!selectedTruck"
                                class="bg-blue-600 text-white px-5 py-2 rounded shadow disabled:opacity-50">
                                Assign Load
                            </button>
                        </form>
                    </div>

                    <!-- WARNING -->
                    <div x-show="!selectedTruck" class="text-xs text-red-500 mt-2">
                        Please select a truck before assigning
                    </div>

                </div>

            </div>
        </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\utsav\indinox\resources\views/dispatch/index.blade.php ENDPATH**/ ?>