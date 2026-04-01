<h2>Edit Load</h2>

<form method="POST" action="{{ route('loads.update', $load->id) }}">
    @csrf
    @method('PUT')

    <label>Customer</label>
    <select name="customer_id">
        @foreach($customers as $customer)
            <option value="{{ $customer->id }}"
                {{ $customer->id == $load->customer_id ? 'selected' : '' }}>
                {{ $customer->name }}
            </option>
        @endforeach
    </select>

    <input name="pickup_location" value="{{ $load->pickup_location }}">
    <input name="delivery_location" value="{{ $load->delivery_location }}">
    <input name="material" value="{{ $load->material }}">
    <input name="weight" value="{{ $load->weight }}">
    <input name="pickup_date" type="date" value="{{ $load->pickup_date }}">
    <input name="price" value="{{ $load->price }}">
    <label>Status</label>
<select name="status" class="border px-2 py-1 w-full mb-3">
    <option value="pending" {{ $load->status == 'pending' ? 'selected' : '' }}>Pending</option>
    <option value="assigned" {{ $load->status == 'assigned' ? 'selected' : '' }}>Assigned</option>
    <option value="in_transit" {{ $load->status == 'in_transit' ? 'selected' : '' }}>In Transit</option>
    <option value="delivered" {{ $load->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
</select>
    <input name="expense" value="{{ $load->expense }}" class="w-full border px-3 py-2 mb-4 rounded">

    <button type="submit">Update Load</button>
</form>