<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Indinox — Driver Signup</title>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;600&family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'IBM Plex Sans', sans-serif;
            background: #0E0E0D;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        .mono { font-family: 'IBM Plex Mono', monospace; }

        /* CARD */
        .card {
            background: #fff;
            border-radius: 14px;
            width: 100%;
            max-width: 480px;
            overflow: hidden;
        }

        /* HEADER */
        .card-header {
            background: #111110;
            padding: 24px 28px;
        }

        .logo {
            display: flex; align-items: center; gap: 8px;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 16px; font-weight: 600; color: #fff;
            margin-bottom: 16px;
        }

        .logo-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: #E85D2F; flex-shrink: 0;
        }

        .card-title {
            font-size: 22px; font-weight: 700; color: #fff;
            letter-spacing: -0.02em; line-height: 1.2;
        }

        .card-sub {
            font-size: 13px; color: #6B6B69; margin-top: 6px;
        }

        /* BODY */
        .card-body { padding: 24px 28px; }

        /* TYPE SELECTOR */
        .type-selector {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 10px; margin-bottom: 20px;
        }

        .type-option {
            border: 2px solid #E7E5E4;
            border-radius: 10px; padding: 14px 12px;
            cursor: pointer; transition: all 0.15s;
            text-align: center;
        }

        .type-option:hover { border-color: #E85D2F; }

        .type-option.selected {
            border-color: #E85D2F;
            background: #FFF7F5;
        }

        .type-option input[type="radio"] { display: none; }

        .type-icon { font-size: 24px; margin-bottom: 6px; }

        .type-label {
            font-size: 13px; font-weight: 700; color: #1C1917;
            margin-bottom: 3px;
        }

        .type-desc { font-size: 11px; color: #A8A29E; line-height: 1.4; }

        /* FORM */
        .form-group { margin-bottom: 14px; }

        .form-label {
            display: block; font-size: 12px; font-weight: 600;
            color: #57534E; margin-bottom: 5px; letter-spacing: 0.01em;
        }

        .form-input, .form-select {
            width: 100%; padding: 10px 13px;
            border: 1px solid #E7E5E4; border-radius: 8px;
            font-size: 14px; font-family: inherit; color: #1C1917;
            outline: none; transition: border-color 0.15s, box-shadow 0.15s;
            background: #fff;
        }

        .form-input:focus, .form-select:focus {
            border-color: #E85D2F;
            box-shadow: 0 0 0 3px rgba(232, 93, 47, 0.08);
        }

        .form-hint { font-size: 11px; color: #A8A29E; margin-top: 4px; }

        /* TRUCK SECTION */
        .truck-section {
            background: #F9FAFB;
            border: 1px solid #E7E5E4;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 14px;
            display: none;
        }

        .truck-section.visible { display: block; }

        .truck-section-title {
            font-size: 10px; font-weight: 700; letter-spacing: 0.12em;
            text-transform: uppercase; color: #A8A29E; margin-bottom: 12px;
        }

        /* DIVIDER */
        .divider {
            height: 1px; background: #F5F5F4; margin: 18px 0;
        }

        /* SUBMIT */
        .btn-submit {
            width: 100%; background: #E85D2F; color: #fff;
            border: none; padding: 13px; border-radius: 8px;
            font-size: 15px; font-weight: 700; font-family: inherit;
            cursor: pointer; transition: background 0.15s;
            letter-spacing: -0.01em;
        }
        .btn-submit:hover { background: #D4522A; }

        .footer-note {
            text-align: center; font-size: 12px; color: #A8A29E;
            margin-top: 14px; line-height: 1.5;
        }

        /* ERROR */
        .error-msg {
            background: #FEF2F2; border: 1px solid #FECACA;
            color: #DC2626; border-radius: 6px; padding: 8px 12px;
            font-size: 12px; margin-bottom: 10px;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .card-header { padding: 20px; }
            .card-body   { padding: 20px; }
        }
    </style>
</head>
<body>

<div class="card">

    
    <div class="card-header">
        <div class="logo">
            <span class="logo-dot"></span> INDINOX
        </div>
        <div class="card-title">Join the Indinox Network</div>
        <div class="card-sub">Register as a driver and start earning with India's smartest logistics platform.</div>
    </div>

    
    <div class="card-body">

        <?php if($errors->any()): ?>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="error-msg"><?php echo e($error); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('drivers.join.store')); ?>" id="joinForm">
            <?php echo csrf_field(); ?>

            
            <div style="margin-bottom:20px;">
                <div style="font-size:12px; font-weight:700; color:#57534E; letter-spacing:0.01em; margin-bottom:10px;">
                    I want to…
                </div>

                <div class="type-selector">
                    <label class="type-option" id="opt-fleet" onclick="selectType('fleet_driver')">
                        <input type="radio" name="driver_type" value="fleet_driver" checked>
                        <div class="type-icon">👤</div>
                        <div class="type-label">Drive for Indinox</div>
                        <div class="type-desc">Use Indinox's own trucks. No truck needed.</div>
                    </label>

                    <label class="type-option" id="opt-owner" onclick="selectType('owner_operator')">
                        <input type="radio" name="driver_type" value="owner_operator">
                        <div class="type-icon">🚛</div>
                        <div class="type-label">Bring My Own Truck</div>
                        <div class="type-desc">Register your truck and drive independently.</div>
                    </label>
                </div>
            </div>

            <div class="divider"></div>

            
            <div style="font-size:10px; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:#A8A29E; margin-bottom:12px;">
                Personal Details
            </div>

            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-input"
                       placeholder="Your full name" value="<?php echo e(old('name')); ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Phone Number</label>
                <input type="tel" name="phone" class="form-input"
                       placeholder="10-digit mobile number" value="<?php echo e(old('phone')); ?>" required>
                <div class="form-hint">We'll use this to contact you about your application</div>
            </div>

            <div class="form-group">
                <label class="form-label">Driving License Number</label>
                <input type="text" name="license_number" class="form-input"
                       placeholder="e.g. GJ01 20110012345" value="<?php echo e(old('license_number')); ?>" required
                       style="font-family:'IBM Plex Mono',monospace;">
            </div>

            
            <div class="truck-section" id="truckSection">
                <div class="truck-section-title">Your Truck Details</div>

                <div class="form-group">
                    <label class="form-label">Truck Registration Number</label>
                    <input type="text" name="registration_number" class="form-input"
                           placeholder="e.g. GJ01AB1234" value="<?php echo e(old('registration_number')); ?>"
                           style="font-family:'IBM Plex Mono',monospace;">
                </div>

                <div class="form-group">
                    <label class="form-label">Truck Type</label>
                    <select name="truck_type_id" class="form-select">
                        <option value="">Select truck type…</option>
                        <?php $__currentLoopData = $truckTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($type->id); ?>"
                                <?php echo e(old('truck_type_id') == $type->id ? 'selected' : ''); ?>>
                                <?php echo e($type->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Capacity (Tonnes)</label>
                    <input type="number" name="capacity" class="form-input"
                           placeholder="e.g. 20" value="<?php echo e(old('capacity')); ?>" step="0.5">
                </div>
            </div>

            <div class="divider"></div>

            <button type="submit" class="btn-submit">Submit Application →</button>

        </form>

        <div class="footer-note">
            Our team will review your application and call you within 24–48 hours.<br>
            Already registered? Contact us on WhatsApp.
        </div>

    </div>
</div>

<script>
    function selectType(type) {
        const truckSection = document.getElementById('truckSection');
        const optFleet = document.getElementById('opt-fleet');
        const optOwner = document.getElementById('opt-owner');

        if (type === 'owner_operator') {
            truckSection.classList.add('visible');
            optOwner.classList.add('selected');
            optFleet.classList.remove('selected');
            document.querySelector('input[value="owner_operator"]').checked = true;
        } else {
            truckSection.classList.remove('visible');
            optFleet.classList.add('selected');
            optOwner.classList.remove('selected');
            document.querySelector('input[value="fleet_driver"]').checked = true;
        }
    }

    // Set initial selected state
    selectType('fleet_driver');
</script>

</body>
</html><?php /**PATH C:\Users\utsav\indinox\resources\views/drivers/join.blade.php ENDPATH**/ ?>