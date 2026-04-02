<!DOCTYPE html>
<html>
<head>
    <title>Indinox</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100">

    <div class="flex">

        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white min-h-screen p-5">
            <h2 class="text-2xl font-bold mb-6">Indinox</h2>

            <ul>
                <li class="mb-3"><a href="/dashboard">Dashboard</a></li>
                <li class="mb-3"><a href="/customers">Customers</a></li>
                <li class="mb-3"><a href="/loads">Loads</a></li>
                <li class="mb-3"><a href="/drivers">Drivers</a></li>
                <li class="mb-3"><a href="/dispatch">Dispatch</a></li>
                <li class="mb-3"><a href="/trucks">Trucks</a></li>
            </ul>
        </div>

       

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

    </div>

</body>
</html><?php /**PATH C:\Users\utsav\indinox\resources\views/layout.blade.php ENDPATH**/ ?>