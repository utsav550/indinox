@extends('layout')

@section('content')

<style>
    .form-wrap { max-width: 480px; }
    .page-title { font-size: 20px; font-weight: 700; letter-spacing: -0.02em; color: #1C1917; margin-bottom: 20px; }
    .form-card { background: #fff; border: 1px solid #E7E5E4; border-radius: 10px; overflow: hidden; }
    .form-section { padding: 20px 24px; border-bottom: 1px solid #F5F5F4; }
    .form-section:last-child { border-bottom: none; }
    .section-title { font-size: 10px; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: #A8A29E; margin-bottom: 14px; }
    .form-group { display: flex; flex-direction: column; gap: 5px; margin-bottom: 14px; }
    .form-group:last-child { margin-bottom: 0; }
    .form-label { font-size: 12px; font-weight: 600; color: #57534E; }
    .form-input, .form-select {
        padding: 9px 12px; border: 1px solid #E7E5E4; border-radius: 7px;
        font-size: 13px; font-family: inherit; color: #1C1917;
        outline: none; transition: border-color 0.15s, box-shadow 0.15s; width: 100%;
    }
    .form-input:focus, .form-select:focus {
        border-color: #E85D2F; box-shadow: 0 0 0 3px rgba(232,93,47,0.08);
    }
    .form-footer {
        padding: 16px 24px; display: flex; align-items: center; justify-content: space-between;
        border-top: 1px solid #F5F5F4; background: #FAFAF9;
    }
    .btn-primary {
        background: #E85D2F; color: #fff; border: none;
        padding: 9px 24px; border-radius: 7px; font-size: 13px;
        font-weight: 600; cursor: pointer; font-family: inherit; transition: background 0.15s;
    }
    .btn-primary:hover { background: #D4522A; }
    .btn-cancel {
        color: #78716C; font-size: 13px; text-decoration: none;
        padding: 9px 16px; border-radius: 7px; transition: background 0.1s;
    }
    .btn-cancel:hover { background: #F5F5F4; }
    .notice {
        background: #FEF3C7; border: 1px solid #FDE68A; border-radius: 8px;
        padding: 10px 14px; font-size: 12px; color: #92400E; margin-bottom: 20px;
        display: flex; gap: 8px; align-items: flex-start;
    }
</style>

<div class="form-wrap">

    <div class="page-title">Add Driver</div>

    <div class="notice">
        ⚡ This adds a driver directly as approved (internal use). To let drivers self-register, share the <a href="{{ route('drivers.join') }}" style="font-weight:700; color:#92400E;">signup link</a>.
    </div>

    <form method="POST" action="{{ route('drivers.store') }}" class="form-card">
        @csrf

        <div class="form-section">
            <div class="section-title">Driver Details</div>

            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input name="name" class="form-input" placeholder="Driver's full name" required>
            </div>

            <div class="form-group">
                <label class="form-label">Phone Number</label>
                <input name="phone" class="form-input" placeholder="10-digit mobile number" required>
            </div>

            <div class="form-group">
                <label class="form-label">License Number</label>
                <input name="license_number" class="form-input"
                       placeholder="e.g. GJ01 20110012345"
                       style="font-family:'IBM Plex Mono',monospace;">
            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('drivers.index') }}" class="btn-cancel">Cancel</a>
            <button type="submit" class="btn-primary">Add Driver</button>
        </div>

    </form>
</div>

@endsection