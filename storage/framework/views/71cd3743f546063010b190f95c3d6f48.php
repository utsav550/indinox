

<?php $__env->startSection('content'); ?>
<div class="flex h-screen bg-gray-100">

    
    <div class="w-60 bg-white shadow-md p-4">
        <h2 class="text-xl font-bold mb-6">Indinox</h2>

        <nav class="space-y-3">
            <a href="#" class="block font-medium text-gray-700">Dashboard</a>
            <a href="#" class="block font-medium text-gray-700">Customers</a>
            <a href="#" class="block font-medium text-gray-700">Loads</a>
            <a href="#" class="block font-medium text-gray-700">Drivers</a>
            <a href="#" class="block font-medium text-gray-700">Trucks</a>
        </nav>
    </div>

    
    <div class="w-48 bg-gray-50 border-r p-4">
        <h3 class="font-semibold mb-4">Status</h3>

        <div class="space-y-2">
            <button class="w-full text-left px-3 py-2 rounded bg-white shadow">
                All (<?php echo e($loads->count()); ?>)
            </button>
            <button class="w-full text-left px-3 py-2 rounded hover:bg-gray-200">
                Pending
            </button>
            <button class="w-full text-left px-3 py-2 rounded hover:bg-gray-200">
                Assigned
            </button>
            <button class="w-full text-left px-3 py-2 rounded hover:bg-gray-200">
                In Transit
            </button>
            <button class="w-full text-left px-3 py-2 rounded hover:bg-gray-200">
                Delivered
            </button>
        </div>
    </div>

    
    <div class="flex-1 overflow-y-auto p-6 space-y-4">

        <?php $__currentLoopData = $loads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $load): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div x-data="{ open: false }"
                 class="rounded-xl shadow p-4
                 <?php echo e($load->is_today ? 'bg-red-100' : ($load->is_tomorrow ? 'bg-yellow-100' : 'bg-green-100')); ?>">

                
                <div @click="open = !open" class="flex justify-between items-center cursor-pointer">

                    <div>
                        <div class="font-semibold text-lg">
                            <?php echo e($load->pickup_date); ?> • <?php echo e($load->time_slot); ?>

                            — <?php echo e($load->pickup); ?> → <?php echo e($load->drop); ?>

                        </div>

                        <div class="text-sm text-gray-600">
                            <?php echo e($load->customer); ?> • <?php echo e($load->material); ?> • <?php echo e($load->weight); ?>

                        </div>

                        <div class="text-sm mt-1">
                            ₹<?php echo e(number_format($load->price)); ?> • <?php echo e($load->truck_type); ?>

                            • <?php echo e(ucfirst($load->status)); ?>

                        </div>
                    </div>

                    <button class="text-blue-600 font-medium">
                        <span x-text="open ? 'Collapse' : 'Expand'"></span>
                    </button>
                </div>

                
                <div x-show="open" x-transition class="mt-6 border-t pt-4">

                    
                    <div class="grid grid-cols-3 gap-4">

                        
                        <div class="col-span-2 bg-white p-4 rounded shadow">
                            <h4 class="font-semibold mb-2">Load Info</h4>

                            <p><strong>Customer:</strong> <?php echo e($load->customer); ?></p>
                            <p><strong>Pickup:</strong> <?php echo e($load->pickup_date); ?> (<?php echo e($load->time_slot); ?>)</p>
                            <p><strong>Delivery:</strong> <?php echo e($load->delivery_date); ?></p>
                            <p><strong>Route:</strong> <?php echo e($load->pickup); ?> → <?php echo e($load->drop); ?></p>
                            <p><strong>Material:</strong> <?php echo e($load->material); ?></p>
                            <p><strong>Weight:</strong> <?php echo e($load->weight); ?></p>
                            <p><strong>Price:</strong> ₹<?php echo e(number_format($load->price)); ?></p>
                            <p><strong>Priority:</strong> <?php echo e($load->priority); ?></p>
                        </div>

                        
                        <div class="bg-gray-200 rounded flex items-center justify-center">
                            Map Coming Soon
                        </div>
                    </div>

                    
                    <div x-data="{ selectedTruck: null }" class="mt-4">
                        <h4 class="font-semibold mb-2">Select Truck</h4>

                        <div class="flex gap-3 overflow-x-auto">

                            <?php $__currentLoopData = $load->suggestedTrucks ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $truck): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div
                                    @click="selectedTruck = <?php echo e($truck->id); ?>"
                                    :class="selectedTruck === <?php echo e($truck->id); ?> 
                                        ? 'border-blue-600 ring-2 ring-blue-300' 
                                        : 'border-gray-200'"
                                    class="min-w-[180px] bg-white p-3 rounded shadow cursor-pointer border transition">

                                    <div class="font-semibold"><?php echo e($truck->name); ?></div>

                                    <div class="text-sm mt-1">
                                        <?php if($truck->status == 'available'): ?>
                                            🟢 Available
                                        <?php elseif($truck->status == 'reaching'): ?>
                                            🔵 Reaching
                                        <?php else: ?>
                                            🟣 Busy
                                        <?php endif; ?>
                                    </div>

                                    <div class="text-xs text-gray-500 mt-1">
                                        <?php echo e($truck->eta ?? 'N/A'); ?>

                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>

                        
                        <div class="mt-4 flex justify-between items-center">

                            <div class="text-sm">
                                Driver: <strong>Auto Assigned</strong>
                            </div>

                            <form method="POST" action="<?php echo e(route('dispatch.assign', $load->id)); ?>">
                                <?php echo csrf_field(); ?>

                                <input type="hidden" name="truck_id" :value="selectedTruck">

                                <button 
                                    :disabled="!selectedTruck"
                                    class="bg-blue-600 text-white px-4 py-2 rounded shadow disabled:opacity-50">
                                    Assign Load
                                </button>
                            </form>
                        </div>

                        
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\utsav\indinox\resources\views/dispatch/index.blade.php ENDPATH**/ ?>