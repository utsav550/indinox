<h2>Add Customer</h2>

<form method="POST" action="<?php echo e(route('customers.store')); ?>">
    <?php echo csrf_field(); ?>

    <input name="name" placeholder="Name">
    <input name="phone" placeholder="Phone">
    <input name="email" placeholder="Email">
    <input name="company_name" placeholder="Company">
    <textarea name="address" placeholder="Address"></textarea>

    <button type="submit">Save</button>
</form><?php /**PATH C:\Users\utsav\indinox\resources\views/customers/create.blade.php ENDPATH**/ ?>