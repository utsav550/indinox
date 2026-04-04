@extends('layout')

@section('content')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC65AaWhsi_FNGW6KY7WXFoA-YB41UQhyI&libraries=places"></script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&family=IBM+Plex+Sans:wght@400;500;600;700&display=swap');

    .form-wrap {
        max-width: 720px;
    }

    .page-title {
        font-size: 20px; font-weight: 700; letter-spacing: -0.02em;
        color: #1C1917; margin-bottom: 20px;
    }

    .form-card {
        background: #fff; border: 1px solid #E7E5E4;
        border-radius: 10px; overflow: hidden;
    }

    .form-section {
        padding: 20px 24px;
        border-bottom: 1px solid #F5F5F4;
    }
    .form-section:last-child { border-bottom: none; }

    .section-title {
        font-size: 10px; font-weight: 700; letter-spacing: 0.12em;
        text-transform: uppercase; color: #A8A29E; margin-bottom: 14px;
    }

    .form-grid {
        display: grid; gap: 14px;
    }
    .form-grid-2 { grid-template-columns: 1fr 1fr; }

    .form-group { display: flex; flex-direction: column; gap: 5px; }

    .form-label {
        font-size: 12px; font-weight: 600; color: #57534E;
        letter-spacing: 0.01em;
    }

    .form-input, .form-select, .form-textarea {
        padding: 9px 12px; border: 1px solid #E7E5E4;
        border-radius: 7px; font-size: 13px; font-family: inherit;
        color: #1C1917; background: #fff; outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
        width: 100%;
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        border-color: #E85D2F;
        box-shadow: 0 0 0 3px rgba(232, 93, 47, 0.08);
    }
    .form-textarea { resize: vertical; min-height: 80px; }

    .form-hint {
        font-size: 11px; color: #A8A29E; margin-top: 2px;
    }

    .location-group { position: relative; }
    .location-icon {
        position: absolute; left: 10px; top: 50%; transform: translateY(-50%);
        color: #A8A29E; font-size: 13px; pointer-events: none;
    }
    .location-input { padding-left: 28px !important; }

    .form-footer {
        padding: 16px 24px;
        display: flex; align-items: center; justify-content: space-between;
        border-top: 1px solid #F5F5F4; background: #FAFAF9;
    }

    .btn-primary {
        background: #E85D2F; color: #fff; border: none;
        padding: 9px 24px; border-radius: 7px; font-size: 13px;
        font-weight: 600; cursor: pointer; font-family: inherit;
        transition: background 0.15s;
    }
    .btn-primary:hover { background: #D4522A; }

    .btn-cancel {
        color: #78716C; font-size: 13px; font-weight: 500;
        text-decoration: none; padding: 9px 16px; border-radius: 7px;
        transition: background 0.1s;
    }
    .btn-cancel:hover { background: #F5F5F4; }
</style>

<div class="form-wrap">

    <div class="page-title">New Load</div>

    <form method="POST" action="{{ route('loads.store') }}" class="form-card">
        @csrf

        {{-- CUSTOMER --}}
        <div class="form-section">
            <div class="section-title">Customer</div>
            <div class="form-group">
                <label class="form-label">Select Customer</label>
                <select name="customer_id" class="form-select" required>
                    <option value="">Choose a customer…</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">
                            {{ $customer->name }}{{ $customer->company_name ? ' — ' . $customer->company_name : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- ROUTE --}}
        <div class="form-section">
            <div class="section-title">Route</div>
            <div class="form-grid form-grid-2">

                <div class="form-group">
                    <label class="form-label">Pickup Location</label>
                    <div class="location-group">
                        <span class="location-icon">⬆</span>
                        <input id="pickup_location" name="pickup_address"
                               class="form-input location-input"
                               placeholder="Search pickup city or address…" autocomplete="off">
                    </div>
                    <input type="hidden" name="pickup_lat"  id="pickup_lat">
                    <input type="hidden" name="pickup_lng"  id="pickup_lng">
                    <input type="hidden" name="pickup_city" id="pickup_city">
                </div>

                <div class="form-group">
                    <label class="form-label">Delivery Location</label>
                    <div class="location-group">
                        <span class="location-icon">⬇</span>
                        <input id="delivery_location" name="delivery_address"
                               class="form-input location-input"
                               placeholder="Search delivery city or address…" autocomplete="off">
                    </div>
                    <input type="hidden" name="delivery_lat"  id="delivery_lat">
                    <input type="hidden" name="delivery_lng"  id="delivery_lng">
                    <input type="hidden" name="delivery_city" id="delivery_city">
                </div>

            </div>
        </div>

        {{-- CARGO --}}
        <div class="form-section">
            <div class="section-title">Cargo</div>
            <div class="form-grid form-grid-2">

                <div class="form-group">
                    <label class="form-label">Material</label>
                    <input name="material" class="form-input" placeholder="e.g. Steel, Cement…">
                </div>

                <div class="form-group">
                    <label class="form-label">Weight (Tonnes)</label>
                    <input name="weight" type="number" step="0.1" class="form-input" placeholder="0.0">
                </div>

                <div class="form-group">
                    <label class="form-label">Truck Type Required</label>
                    <select name="truck_type_required_id" class="form-select" required>
                        <option value="">Select type…</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Price (₹)</label>
                    <input name="price" type="number" class="form-input" placeholder="0">
                </div>

            </div>
        </div>

        {{-- SCHEDULE --}}
        <div class="form-section">
            <div class="section-title">Schedule</div>
            <div class="form-grid form-grid-2">

                <div class="form-group">
                    <label class="form-label">Pickup Date</label>
                    <input type="date" name="pickup_date" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Pickup Time Slot</label>
                    <select name="pickup_time_slot" class="form-select" required>
                        <option value="">Select slot…</option>
                        <option value="early_morning">Early Morning (4AM – 8AM)</option>
                        <option value="morning">Morning (8AM – 12PM)</option>
                        <option value="afternoon">Afternoon (12PM – 4PM)</option>
                        <option value="evening">Evening (4PM – 8PM)</option>
                        <option value="night">Night (8PM – 12AM)</option>
                        <option value="late_night">Late Night (12AM – 4AM)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Trip Days</label>
                    <input type="number" name="trip_days" value="1" min="1" class="form-input">
                    <span class="form-hint">Used to calculate delivery date</span>
                </div>

                <div class="form-group">
                    <label class="form-label">Priority</label>
                    <select name="priority" class="form-select">
                        <option value="normal">Normal</option>
                        <option value="high">High</option>
                        <option value="low">Low</option>
                    </select>
                </div>

            </div>
        </div>

        {{-- NOTES --}}
        <div class="form-section">
            <div class="section-title">Additional Info</div>
            <div class="form-group">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-textarea"
                          placeholder="Any special instructions, requirements, or notes…"></textarea>
            </div>
        </div>

        {{-- FOOTER --}}
        <div class="form-footer">
            <a href="{{ route('loads.index') }}" class="btn-cancel">Cancel</a>
            <button type="submit" class="btn-primary">Save Load</button>
        </div>

    </form>
</div>

<script>
function getCityFromPlace(place) {
    for (const c of place.address_components) {
        if (c.types.includes('locality')) return c.long_name;
    }
    for (const c of place.address_components) {
        if (c.types.includes('administrative_area_level_2')) return c.long_name;
    }
    return '';
}

function initAutocomplete() {
    const pickupInput = document.getElementById('pickup_location');
    const pickupAC = new google.maps.places.Autocomplete(pickupInput);
    pickupAC.addListener('place_changed', function () {
        const place = pickupAC.getPlace();
        if (!place.geometry) { pickupInput.value = ''; return; }
        document.getElementById('pickup_lat').value  = place.geometry.location.lat();
        document.getElementById('pickup_lng').value  = place.geometry.location.lng();
        document.getElementById('pickup_city').value = getCityFromPlace(place);
    });

    const deliveryInput = document.getElementById('delivery_location');
    const deliveryAC = new google.maps.places.Autocomplete(deliveryInput);
    deliveryAC.addListener('place_changed', function () {
        const place = deliveryAC.getPlace();
        if (!place.geometry) { deliveryInput.value = ''; return; }
        document.getElementById('delivery_lat').value  = place.geometry.location.lat();
        document.getElementById('delivery_lng').value  = place.geometry.location.lng();
        document.getElementById('delivery_city').value = getCityFromPlace(place);
    });
}

google.maps.event.addDomListener(window, 'load', initAutocomplete);
</script>

@endsection