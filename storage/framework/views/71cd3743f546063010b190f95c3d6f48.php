

<?php $__env->startSection('content'); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC65AaWhsi_FNGW6KY7WXFoA-YB41UQhyI"></script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&family=IBM+Plex+Sans:wght@400;500;600&display=swap');

    .dispatch-root { font-family: 'IBM Plex Sans', sans-serif; }
    .mono { font-family: 'IBM Plex Mono', monospace; }

    .status-pill {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 2px 10px; border-radius: 99px; font-size: 11px;
        font-weight: 600; letter-spacing: 0.04em; text-transform: uppercase;
    }
    .pill-pending  { background: #FEF3C7; color: #92400E; }
    .pill-assigned { background: #DBEAFE; color: #1E40AF; }
    .pill-expired  { background: #FEE2E2; color: #991B1B; }
    .pill-delivered{ background: #D1FAE5; color: #065F46; }

    .priority-high   { border-left: 3px solid #EF4444; }
    .priority-normal { border-left: 3px solid #E5E7EB; }
    .priority-low    { border-left: 3px solid #93C5FD; }

    .load-card {
        background: #fff;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        transition: box-shadow 0.15s;
    }
    .load-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.07); }

    .load-card.today  { border-top: 3px solid #EF4444; }
    .load-card.tomorrow { border-top: 3px solid #F59E0B; }
    .load-card.future { border-top: 3px solid #10B981; }

    .truck-chip {
        border: 1.5px solid #E5E7EB;
        border-radius: 8px;
        padding: 10px 14px;
        cursor: pointer;
        transition: all 0.15s;
        min-width: 160px;
        background: #fff;
    }
    .truck-chip:hover { border-color: #6366F1; }
    .truck-chip.selected { border-color: #6366F1; background: #EEF2FF; box-shadow: 0 0 0 2px #C7D2FE; }
    .truck-chip.no-driver { opacity: 0.55; cursor: not-allowed; }

    .badge-recommended {
        background: #6366F1; color: #fff;
        font-size: 10px; padding: 1px 7px; border-radius: 99px;
        font-weight: 600; letter-spacing: 0.05em;
    }

    .nav-tab {
        padding: 6px 14px; border-radius: 6px; font-size: 13px;
        font-weight: 500; color: #6B7280; cursor: pointer;
        display: flex; align-items: center; gap: 6px;
        text-decoration: none; transition: background 0.1s;
    }
    .nav-tab:hover { background: #F3F4F6; color: #111; }
    .nav-tab.active { background: #111; color: #fff; }
    .nav-tab .count {
        background: rgba(255,255,255,0.2); border-radius: 99px;
        font-size: 11px; padding: 0 6px; font-family: 'IBM Plex Mono', monospace;
    }
    .nav-tab:not(.active) .count {
        background: #F3F4F6; color: #374151;
    }

    .dot { width: 7px; height: 7px; border-radius: 50%; display: inline-block; }
    .dot-green  { background: #10B981; }
    .dot-yellow { background: #F59E0B; }
    .dot-red    { background: #EF4444; }
    .dot-gray   { background: #9CA3AF; }
    .dot-blue   { background: #6366F1; }

    .assign-btn {
        background: #6366F1; color: #fff; border: none;
        padding: 8px 22px; border-radius: 7px; font-weight: 600;
        font-size: 13px; cursor: pointer; transition: background 0.15s;
    }
    .assign-btn:hover:not(:disabled) { background: #4F46E5; }
    .assign-btn:disabled { background: #C7D2FE; cursor: not-allowed; }

    .unassign-btn {
        background: #FEE2E2; color: #991B1B; border: none;
        padding: 6px 16px; border-radius: 6px; font-size: 12px;
        font-weight: 600; cursor: pointer; transition: background 0.15s;
    }
    .unassign-btn:hover { background: #FECACA; }

    .info-row { display: flex; justify-content: space-between; padding: 5px 0; border-bottom: 1px solid #F3F4F6; font-size: 13px; }
    .info-row:last-child { border-bottom: none; }
    .info-label { color: #6B7280; font-weight: 500; }
    .info-val { color: #111; font-weight: 500; text-align: right; }

    .section-label {
        font-size: 10px; font-weight: 700; letter-spacing: 0.1em;
        text-transform: uppercase; color: #9CA3AF; margin-bottom: 8px;
    }

    .expand-btn {
        background: none; border: 1px solid #E5E7EB; border-radius: 6px;
        padding: 4px 12px; font-size: 12px; font-weight: 600;
        color: #6B7280; cursor: pointer; transition: all 0.1s;
    }
    .expand-btn:hover { background: #F3F4F6; color: #111; }

    [x-cloak] { display: none !important; }
</style>

<div class="dispatch-root" style="padding: 0; margin: -24px;">

    <!-- TOP BAR -->
    <div style="background:#fff; border-bottom:1px solid #E5E7EB; padding: 14px 28px; display:flex; align-items:center; justify-content:space-between;">
        <div style="display:flex; align-items:center; gap:8px;">
            <span style="font-size:18px; font-weight:700; letter-spacing:-0.02em;">Dispatch</span>
            <span class="mono" style="font-size:12px; color:#9CA3AF; margin-left:4px;"><?php echo e(today()->format('d M Y')); ?></span>
        </div>

        <!-- STATUS TABS -->
        <div style="display:flex; gap:4px; align-items:center;">
            <a href="/dispatch?status=pending"   class="nav-tab <?php echo e($status=='pending'   ? 'active' : ''); ?>">Pending   <span class="count"><?php echo e($counts['pending']); ?></span></a>
            <a href="/dispatch?status=assigned"  class="nav-tab <?php echo e($status=='assigned'  ? 'active' : ''); ?>">Assigned  <span class="count"><?php echo e($counts['assigned']); ?></span></a>
            <a href="/dispatch?status=in_transit"class="nav-tab <?php echo e($status=='in_transit'? 'active' : ''); ?>">In Transit<span class="count"><?php echo e($counts['in_transit']); ?></span></a>
            <a href="/dispatch?status=delivered" class="nav-tab <?php echo e($status=='delivered' ? 'active' : ''); ?>">Delivered <span class="count"><?php echo e($counts['delivered']); ?></span></a>
            <?php if($counts['expired'] > 0): ?>
            <a href="/dispatch?status=expired"   class="nav-tab <?php echo e($status=='expired'   ? 'active' : ''); ?>" style="<?php echo e($status!='expired' ? 'color:#EF4444' : ''); ?>">Expired   <span class="count"><?php echo e($counts['expired']); ?></span></a>
            <?php endif; ?>
            <a href="/dispatch?status=all"       class="nav-tab <?php echo e($status=='all'       ? 'active' : ''); ?>">All       <span class="count"><?php echo e($counts['all']); ?></span></a>
        </div>
    </div>

    <!-- LOAD LIST -->
    <div style="padding: 20px 28px; display:flex; flex-direction:column; gap:10px; max-width:1100px;">

        <?php $__empty_1 = true; $__currentLoopData = $loads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $load): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

        <?php
            $cardClass = $load->is_today ? 'today' : ($load->is_tomorrow ? 'tomorrow' : 'future');
            $priorityClass = match($load->priority ?? 'normal') {
                'high' => 'priority-high',
                'low'  => 'priority-low',
                default => 'priority-normal'
            };
        ?>

        <div x-data="{ open: false }"
             class="load-card <?php echo e($cardClass); ?> <?php echo e($priorityClass); ?>">

            
            <div @click="
                    open = !open;
                    if(open){
                        $nextTick(() => loadMap(
                            <?php echo e($load->id); ?>,
                            <?php echo e($load->pickup_lat ?? 0); ?>,
                            <?php echo e($load->pickup_lng ?? 0); ?>,
                            <?php echo e($load->delivery_lat ?? 0); ?>,
                            <?php echo e($load->delivery_lng ?? 0); ?>,
                            [
                                <?php $__currentLoopData = $load->suggestedTrucks ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $truck): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                { lat: <?php echo e($truck->current_lat ?? 0); ?>, lng: <?php echo e($truck->current_lng ?? 0); ?>, code: '<?php echo e($truck->truck_code); ?>' },
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            ]
                        ))
                    }
                 "
                 style="padding:14px 18px; display:flex; align-items:center; gap:16px; cursor:pointer;">

                
                <div class="mono" style="min-width:80px; text-align:center; line-height:1;">
                    <div style="font-size:22px; font-weight:600; color:#111;"><?php echo e(\Carbon\Carbon::parse($load->pickup_date)->format('d')); ?></div>
                    <div style="font-size:11px; color:#9CA3AF; text-transform:uppercase; letter-spacing:0.06em;"><?php echo e(\Carbon\Carbon::parse($load->pickup_date)->format('M')); ?></div>
                    <?php if($load->is_today): ?>
                        <div style="font-size:9px; font-weight:700; color:#EF4444; letter-spacing:0.08em; margin-top:2px;">TODAY</div>
                    <?php elseif($load->is_tomorrow): ?>
                        <div style="font-size:9px; font-weight:700; color:#F59E0B; letter-spacing:0.08em; margin-top:2px;">TOMORROW</div>
                    <?php endif; ?>
                </div>

                
                <div style="width:1px; height:40px; background:#E5E7EB;"></div>

                
                <div style="flex:1; min-width:0;">
                    <div style="font-weight:600; font-size:14px; color:#111; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        <?php echo e($load->pickup_location); ?> → <?php echo e($load->delivery_location); ?>

                    </div>
                    <div style="font-size:12px; color:#6B7280; margin-top:2px;">
                        <?php echo e($load->customer_name); ?> &nbsp;·&nbsp; <?php echo e($load->material); ?> &nbsp;·&nbsp; <?php echo e($load->weight); ?> T
                    </div>
                </div>

                
                <div style="min-width:110px;">
                    <div class="section-label" style="margin-bottom:2px;">Truck Type</div>
                    <div style="font-size:13px; font-weight:500; color:#374151;"><?php echo e($load->truck_type_name); ?></div>
                </div>

                
                <div style="min-width:90px;">
                    <div class="section-label" style="margin-bottom:2px;">Time Slot</div>
                    <div style="font-size:13px; font-weight:500; color:#374151;"><?php echo e(ucfirst(str_replace('_',' ', $load->pickup_time_slot ?? '—'))); ?></div>
                </div>

                
                <div class="mono" style="min-width:80px; text-align:right;">
                    <div style="font-size:15px; font-weight:600; color:#111;">₹<?php echo e($load->price_display); ?></div>
                    <div style="font-size:11px; color:#9CA3AF;">price</div>
                </div>

                
                <div style="min-width:90px; text-align:right;">
                    <?php
                        $pillClass = match($load->status) {
                            'pending'  => 'pill-pending',
                            'assigned' => 'pill-assigned',
                            'expired'  => 'pill-expired',
                            'delivered'=> 'pill-delivered',
                            default    => 'pill-pending'
                        };
                    ?>
                    <span class="status-pill <?php echo e($pillClass); ?>"><?php echo e(ucfirst($load->status)); ?></span>
                </div>

                
                <button class="expand-btn" @click.stop="open = !open">
                    <span x-text="open ? '▲ Close' : '▼ Open'">▼ Open</span>
                </button>
            </div>

            
            <div x-show="open" x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 style="border-top:1px solid #F3F4F6; padding:18px; display:grid; grid-template-columns:260px 1fr; gap:18px;">

                
                <div style="display:flex; flex-direction:column; gap:14px;">

                    
                    <div>
                        <div class="section-label">Load Details</div>
                        <div style="background:#F9FAFB; border-radius:8px; padding:12px;">
                            <div class="info-row"><span class="info-label">Customer</span><span class="info-val"><?php echo e($load->customer_name); ?></span></div>
                            <div class="info-row"><span class="info-label">Pickup</span><span class="info-val"><?php echo e($load->pickup_date); ?> · <?php echo e(ucfirst(str_replace('_',' ',$load->pickup_time_slot ?? ''))); ?></span></div>
                            <div class="info-row"><span class="info-label">Delivery</span><span class="info-val"><?php echo e($load->delivery_date); ?></span></div>
                            <div class="info-row"><span class="info-label">Material</span><span class="info-val"><?php echo e($load->material); ?></span></div>
                            <div class="info-row"><span class="info-label">Weight</span><span class="info-val"><?php echo e($load->weight); ?> T</span></div>
                            <div class="info-row"><span class="info-label">Price</span><span class="info-val mono">₹<?php echo e($load->price_display); ?></span></div>
                            <div class="info-row"><span class="info-label">Trip Days</span><span class="info-val"><?php echo e($load->trip_days ?? 1); ?> days</span></div>
                            <div class="info-row"><span class="info-label">Priority</span>
                                <span class="info-val" style="color: <?php echo e(match($load->priority ?? 'normal') { 'high' => '#EF4444', 'low' => '#6366F1', default => '#374151' }); ?>">
                                    <?php echo e(ucfirst($load->priority ?? 'normal')); ?>

                                </span>
                            </div>
                            <?php if($load->notes): ?>
                            <div style="margin-top:8px; padding:8px; background:#FEF9C3; border-radius:6px; font-size:12px; color:#713F12;">
                                📝 <?php echo e($load->notes); ?>

                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div>
                        <div class="section-label">Route Map</div>
                        <div id="map-<?php echo e($load->id); ?>" style="width:100%; height:200px; border-radius:8px; background:#F3F4F6;"></div>
                    </div>
                </div>

                
                <div>

                    <?php if($load->status === 'assigned'): ?>

                        
                        <div class="section-label">Assigned Truck</div>
                        <div style="background:#F0FDF4; border:1px solid #BBF7D0; border-radius:8px; padding:14px; display:flex; gap:16px; align-items:flex-start;">
                            <div style="flex:1;">
                                <div style="display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                                    <span class="mono" style="font-size:18px; font-weight:700; color:#111;"><?php echo e($load->assignedTruck->truck_code ?? 'N/A'); ?></span>
                                    <span class="status-pill" style="background:#D1FAE5; color:#065F46;">✓ Assigned</span>
                                </div>
                                <div style="display:grid; grid-template-columns:1fr 1fr; gap:6px;">
                                    <div class="info-row"><span class="info-label">Driver</span><span class="info-val"><?php echo e($load->assignedTruck->driver->name ?? '—'); ?></span></div>
                                    <div class="info-row"><span class="info-label">Location</span><span class="info-val"><?php echo e($load->assignedTruck->current_location ?? '—'); ?></span></div>
                                    <div class="info-row"><span class="info-label">Distance</span><span class="info-val mono"><?php echo e($load->assignedTruck->distance ?? '—'); ?> km</span></div>
                                    <div class="info-row"><span class="info-label">Start</span><span class="info-val mono"><?php echo e($load->dispatchDetails->start_date ?? '—'); ?></span></div>
                                    <div class="info-row"><span class="info-label">End</span><span class="info-val mono"><?php echo e($load->dispatchDetails->end_date ?? '—'); ?></span></div>
                                </div>
                            </div>
                            <form method="POST" action="<?php echo e(route('dispatch.unassign', $load->id)); ?>">
                                <?php echo csrf_field(); ?>
                                <button class="unassign-btn">Unassign</button>
                            </form>
                        </div>

                    <?php else: ?>

                        
                        <div x-data="{ selectedTruck: null, hasDriver: false }">

                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
                                <div class="section-label" style="margin-bottom:0;">
                                    Suggested Trucks &nbsp;·&nbsp; <?php echo e($load->truck_type_name); ?>

                                </div>
                                <div style="font-size:11px; color:#9CA3AF;">Click a truck to select · Only trucks with drivers can be assigned</div>
                            </div>

                            <div style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:14px;">

                                <?php $__empty_2 = true; $__currentLoopData = $load->suggestedTrucks ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $truck): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>

                                <?php
                                    $hasDriver = (bool)$truck->driver_id;
                                    $dotClass = match(true) {
                                        !$hasDriver => 'dot-gray',
                                        $truck->status === 'available' => 'dot-green',
                                        $truck->status === 'reaching'  => 'dot-yellow',
                                        default => 'dot-red'
                                    };
                                ?>

                                <div
                                    <?php if($hasDriver): ?>
                                        @click="selectedTruck = <?php echo e($truck->id); ?>; hasDriver = true"
                                    <?php endif; ?>
                                    :class="selectedTruck === <?php echo e($truck->id); ?> ? 'truck-chip selected' : 'truck-chip <?php echo e(!$hasDriver ? 'no-driver' : ''); ?>'"
                                    class="truck-chip <?php echo e(!$hasDriver ? 'no-driver' : ''); ?>">

                                    <div style="display:flex; align-items:center; gap:6px; margin-bottom:4px;">
                                        <span class="dot <?php echo e($dotClass); ?>"></span>
                                        <span class="mono" style="font-weight:600; font-size:13px;"><?php echo e($truck->truck_code); ?></span>
                                        <?php if(isset($truck->is_recommended) && $truck->is_recommended && $hasDriver): ?>
                                            <span class="badge-recommended">Best</span>
                                        <?php endif; ?>
                                    </div>

                                    <div style="font-size:11px; color:#6B7280; line-height:1.5;">
                                        <?php if(!$hasDriver): ?>
                                            <span style="color:#EF4444; font-weight:500;">No driver</span>
                                        <?php elseif($truck->status === 'available'): ?>
                                            <span style="color:#10B981; font-weight:500;">Available</span>
                                        <?php else: ?>
                                            <span><?php echo e($truck->eta); ?></span>
                                        <?php endif; ?>
                                        <br>
                                        <span class="mono"><?php echo e($truck->distance != 9999 ? $truck->distance . ' km away' : 'No location'); ?></span>
                                    </div>
                                </div>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                    <div style="padding:16px; background:#F9FAFB; border-radius:8px; color:#6B7280; font-size:13px; width:100%;">
                                        No matching trucks available for this load.
                                    </div>
                                <?php endif; ?>

                            </div>

                            
                            <div style="display:flex; align-items:center; justify-content:space-between; padding-top:12px; border-top:1px solid #F3F4F6;">
                                <div style="font-size:12px; color:#6B7280;">
                                    <span x-show="!selectedTruck">Select a truck above to assign</span>
                                    <span x-show="selectedTruck && hasDriver" style="color:#10B981; font-weight:500;">✓ Ready to assign</span>
                                </div>
                                <form method="POST" action="<?php echo e(route('dispatch.assign', $load->id)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="truck_id" :value="selectedTruck">
                                    <button class="assign-btn" :disabled="!selectedTruck || !hasDriver">
                                        Assign Truck
                                    </button>
                                </form>
                            </div>

                        </div>

                    <?php endif; ?>

                </div>

            </div>
        </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div style="text-align:center; padding:60px; color:#9CA3AF;">
                <div style="font-size:32px; margin-bottom:8px;">📦</div>
                <div style="font-weight:600; color:#374151;">No loads found</div>
                <div style="font-size:13px; margin-top:4px;">Try a different status filter</div>
            </div>
        <?php endif; ?>

    </div>
</div>

<script>
function loadMap(loadId, pickupLat, pickupLng, deliveryLat, deliveryLng, trucks) {
    const mapElement = document.getElementById("map-" + loadId);
    if (!mapElement || mapElement.dataset.loaded) return;
    mapElement.dataset.loaded = true;

    const pickup   = { lat: pickupLat,   lng: pickupLng   };
    const delivery = { lat: deliveryLat, lng: deliveryLng };

    const map = new google.maps.Map(mapElement, { zoom: 7, center: pickup });

    if (pickupLat && deliveryLat) {
        const directionsService  = new google.maps.DirectionsService();
        const directionsRenderer = new google.maps.DirectionsRenderer({ suppressMarkers: true });
        directionsRenderer.setMap(map);
        directionsService.route({
            origin: pickup, destination: delivery, travelMode: 'DRIVING'
        }, (result, status) => {
            if (status === 'OK') directionsRenderer.setDirections(result);
        });
    }

    if (pickupLat) new google.maps.Marker({ position: pickup,   map, label: { text:'P', color:'#fff' }, icon: { path: google.maps.SymbolPath.CIRCLE, scale:10, fillColor:'#10B981', fillOpacity:1, strokeColor:'#fff', strokeWeight:2 } });
    if (deliveryLat) new google.maps.Marker({ position: delivery, map, label: { text:'D', color:'#fff' }, icon: { path: google.maps.SymbolPath.CIRCLE, scale:10, fillColor:'#6366F1', fillOpacity:1, strokeColor:'#fff', strokeWeight:2 } });

    (trucks || []).forEach(truck => {
        if (truck.lat && truck.lng) {
            new google.maps.Marker({
                position: { lat: truck.lat, lng: truck.lng },
                map,
                title: truck.code,
                icon: { url: "https://maps.google.com/mapfiles/kml/shapes/truck.png", scaledSize: new google.maps.Size(32, 32) }
            });
        }
    });
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\utsav\indinox\resources\views/dispatch/index.blade.php ENDPATH**/ ?>