<h2>Add Customer</h2>

<form method="POST" action="{{ route('customers.store') }}">
    @csrf

    <input name="name" placeholder="Name">
    <input name="phone" placeholder="Phone">
    <input name="email" placeholder="Email">
    <input name="company_name" placeholder="Company">
    <textarea name="address" placeholder="Address"></textarea>

    <button type="submit">Save</button>
</form>