<h2>Edit Customer</h2>

<form method="POST" action="{{ route('customers.update', $customer->id) }}">
    @csrf
    @method('PUT')

    <input name="name" value="{{ $customer->name }}">
    <input name="phone" value="{{ $customer->phone }}">
    <input name="email" value="{{ $customer->email }}">
    <input name="company_name" value="{{ $customer->company_name }}">
    <textarea name="address">{{ $customer->address }}</textarea>

    <button type="submit">Update</button>
</form>