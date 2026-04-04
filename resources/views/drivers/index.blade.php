@extends('layout')

@section('content')

<style>
    .mono { font-family: 'IBM Plex Mono', monospace; }

    .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
    .page-title  { font-size: 20px; font-weight: 700; letter-spacing: -0.02em; color: #1C1917; }

    .btn-primary {
        background: #E85D2F; color: #fff; border: none; padding: 8px 18px;
        border-radius: 7px; font-size: 13px; font-weight: 600; text-decoration: none;
        cursor: pointer; transition: background 0.15s;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-primary:hover { background: #D4522A; }

    /* TABS */
    .tab-bar { display: flex; gap: 4px; margin-bottom: 20px; border-bottom: 2px solid #E7E5E4; flex-wrap: wrap; }
    .tab {
        padding: 9px 16px; font-size: 13px; font-weight: 600; color: #78716C;
        border: none; background: none; border-bottom: 2px solid transparent;
        margin-bottom: -2px; display: inline-flex; align-items: center; gap: 7px;
        transition: color 0.15s; text-decoration: none; cursor: pointer;
    }
    .tab:hover { color: #1C1917; }
    .tab.active { color: #E85D2F; border-bottom-color: #E85D2F; }

    .badge      { background: #E85D2F; color: #fff; font-size: 10px; font-weight: 700; padding: 1px 6px; border-radius: 99px; font-family: 'IBM Plex Mono', monospace; }
    .badge-gray { background: #F5F5F4; color: #78716C; font-size: 10px; font-weight: 700; padding: 1px 6px; border-radius: 99px; font-family: 'IBM Plex Mono', monospace; }

    /* TABLE */
    .drivers-table { width: 100%; border-collapse: separate; border-spacing: 0; background: #fff; border-radius: 10px; border: 1px solid #E7E5E4; font-size: 13px; overflow: hidden; }
    .drivers-table thead tr { background: #FAFAF9; }
    .drivers-table th { padding: 10px 14px; text-align: left; font-size: 10px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: #A8A29E; border-bottom: 1px solid #E7E5E4; }
    .drivers-table td { padding: 11px 14px; border-bottom: 1px solid #F5F5F4; color: #1C1917; vertical-align: middle; }
    .drivers-table tbody tr:last-child td { border-bottom: none; }
    .drivers-table tbody tr:hover td { background: #FAFAF9; }

    /* STATUS CHANGE DROPDOWN INLINE */
    .status-form { display: flex; align-items: center; gap: 6px; }
    .status-select {
        padding: 5px 8px; border: 1px solid #E7E5E4; border-radius: 6px;
        font-size: 12px; font-family: inherit; background: #fff;
        outline: none; cursor: pointer; color: #1C1917;
    }
    .status-select:focus { border-color: #E85D2F; }
    .btn-status {
        background: #F5F5F4; border: 1px solid #E7E5E4; border-radius: 6px;
        padding: 5px 10px; font-size: 11px; font-weight: 600; cursor: pointer;
        font-family: inherit; color: #57534E; transition: all 0.1s;
        white-space: nowrap;
    }
    .btn-status:hover { background: #E7E5E4; color: #1C1917; }

    /* NOTE INPUT */
    .note-input {
        padding: 5px 8px; border: 1px solid #E7E5E4; border-radius: 6px;
        font-size: 12px; font-family: inherit; outline: none; width: 140px;
    }
    .note-input:focus { border-color: #E85D2F; }

    /* PILLS */
    .pill { display: inline-flex; align-items: center; padding: 2px 9px; border-radius: 99px; font-size: 11px; font-weight: 600; }
    .pill-approved    { background: #D1FAE5; color: #065F46; }
    .pill-rejected    { background: #FEE2E2; color: #991B1B; }
    .pill-on_leave    { background: #FEF3C7; color: #92400E; }
    .pill-unavailable { background: #F3F4F6; color: #374151; }
    .pill-left_company{ background: #FEE2E2; color: #6B7280; }

    .type-badge { display: inline-flex; align-items: center; gap: 4px; padding: 2px 10px; border-radius: 99px; font-size: 11px; font-weight: 600; }
    .type-owner { background: #EDE9FE; color: #5B21B6; }
    .type-fleet { background: #DBEAFE; color: #1E40AF; }

    .truck-link { font-family: 'IBM Plex Mono', monospace; font-size: 12px; color: #6366F1; font-weight: 600; }

    /* PENDING CARDS */
    .pending-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 12px; }
    .pending-card { background: #fff; border: 1px solid #FDE68A; border-top: 3px solid #F59E0B; border-radius: 10px; padding: 16px; }
    .driver-name  { font-size: 15px; font-weight: 700; color: #1C1917; margin-bottom: 4px; }
    .driver-meta  { font-size: 12px; color: #78716C; display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 12px; }

    .truck-info { background: #FAFAF9; border-radius: 7px; padding: 10px 12px; font-size: 12px; color: #57534E; margin-bottom: 12px; border: 1px solid #E7E5E4; }
    .truck-info-row { display: flex; justify-content: space-between; padding: 3px 0; }
    .truck-info-label { color: #A8A29E; }
    .truck-info-val   { font-weight: 600; font-family: 'IBM Plex Mono', monospace; }

    .form-input-sm  { padding: 7px 10px; border: 1px solid #E7E5E4; border-radius: 6px; font-size: 12px; font-family: inherit; outline: none; width: 100%; margin-bottom: 6px; }
    .form-select-sm { padding: 7px 10px; border: 1px solid #E7E5E4; border-radius: 6px; font-size: 12px; font-family: inherit; outline: none; width: 100%; background: #fff; cursor: pointer; margin-bottom: 6px; }
    .action-row { display: flex; gap: 8px; margin-top: 4px; }
    .btn-approve { flex: 1; background: #10B981; color: #fff; border: none; padding: 8px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; font-family: inherit; }
    .btn-approve:hover { background: #059669; }
    .btn-reject  { background: #FEE2E2; color: #991B1B; border: none; padding: 8px 14px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; font-family: inherit; }
    .btn-reject:hover { background: #FECACA; }
    .applied-time { font-size: 11px; color: #A8A29E; margin-top: 10px; font-family: 'IBM Plex Mono', monospace; }

    .empty-state { text-align: center; padding: 48px 20px; color: #A8A29E; }
    .empty-state .icon  { font-size: 32px; margin-bottom: 10px; }
    .empty-state .label { font-weight: 600; color: #78716C; font-size: 14px; }
    .empty-state .sub   { font-size: 12px; margin-top: 4px; }

    .link-box { background: #F5F5F4; border: 1px solid #E7E5E4; border-radius: 8px; padding: 10px 14px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
    .link-url { font-family: 'IBM Plex Mono', monospace; font-size: 12px; color: #57534E; }
    .copy-btn { background: #fff; border: 1px solid #E7E5E4; border-radius: 5px; padding: 4px 12px; font-size: 12px; font-weight: 600; cursor: pointer; color: #57534E; white-space: nowrap; }
    .copy-btn:hover { background: #E7E5E4; }
    .section-label { font-size: 10px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: #A8A29E; margin-bottom: 4px; }

    .info-note { font-size: 11px; color: #A8A29E; font-style: italic; }
</style>

@php
    $tab = request('tab', $pending->count() ? 'applications' : 'drivers');

    $inactiveCount = $onLeave->count() + $unavailable->count() + $leftCompany->count();
@endphp

<div class="page-header">
    <div>
        <div class="page-title">Drivers</div>
        <div style="font-size:12px; color:#A8A29E; margin-top:2px;" class="mono">
            {{ $approved->count() }} active · {{ $pending->count() }} pending · {{ $inactiveCount }} inactive
        </div>
    </div>
    <a href="{{ route('drivers.create') }}" class="btn-primary">+ Add Driver</a>
</div>

{{-- TABS --}}
<div class="tab-bar">
    <a href="?tab=drivers" class="tab {{ $tab === 'drivers' ? 'active' : '' }}">
        Active <span class="badge-gray">{{ $approved->count() }}</span>
    </a>
    <a href="?tab=on_leave" class="tab {{ $tab === 'on_leave' ? 'active' : '' }}">
        On Leave <span class="badge-gray">{{ $onLeave->count() }}</span>
    </a>
    <a href="?tab=unavailable" class="tab {{ $tab === 'unavailable' ? 'active' : '' }}">
        Unavailable <span class="badge-gray">{{ $unavailable->count() }}</span>
    </a>
    <a href="?tab=left_company" class="tab {{ $tab === 'left_company' ? 'active' : '' }}">
        Left Company <span class="badge-gray">{{ $leftCompany->count() }}</span>
    </a>
    <a href="?tab=applications" class="tab {{ $tab === 'applications' ? 'active' : '' }}">
        Applications
        @if($pending->count())
            <span class="badge">{{ $pending->count() }}</span>
        @else
            <span class="badge-gray">0</span>
        @endif
    </a>
    @if($rejected->count())
    <a href="?tab=rejected" class="tab {{ $tab === 'rejected' ? 'active' : '' }}">
        Rejected <span class="badge-gray">{{ $rejected->count() }}</span>
    </a>
    @endif
</div>

{{-- ── HELPER MACRO for driver table rows ── --}}
@php
    // Status options available from each current status
    $statusOptions = [
        'approved'    => ['on_leave' => 'On Leave', 'unavailable' => 'Unavailable', 'left_company' => 'Left Company'],
        'on_leave'    => ['approved' => 'Set Active', 'unavailable' => 'Unavailable', 'left_company' => 'Left Company'],
        'unavailable' => ['approved' => 'Set Active', 'on_leave' => 'On Leave', 'left_company' => 'Left Company'],
        'left_company'=> [],
    ];
@endphp

{{-- ── ACTIVE DRIVERS ── --}}
@if($tab === 'drivers')
<table class="drivers-table">
    <thead>
        <tr>
            <th>Name</th><th>Phone</th><th>License</th>
            <th>Type</th><th>Truck</th><th>Change Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($approved as $driver)
        <tr>
            <td style="font-weight:600;">{{ $driver->name }}</td>
            <td class="mono" style="color:#57534E;">{{ $driver->phone }}</td>
            <td class="mono" style="color:#57534E;">{{ $driver->license_number ?? '—' }}</td>
            <td>
                <span class="type-badge {{ $driver->driver_type === 'owner_operator' ? 'type-owner' : 'type-fleet' }}">
                    {{ $driver->driver_type === 'owner_operator' ? '🚛 Owner' : '👤 Fleet' }}
                </span>
            </td>
            <td>
                @if($driver->truck)
                    <span class="truck-link">{{ $driver->truck->truck_code }}</span>
                @else
                    <span style="color:#A8A29E; font-size:12px;">Unassigned</span>
                @endif
            </td>
            <td>
                <form method="POST" action="{{ route('drivers.updateStatus', $driver->id) }}" class="status-form">
                    @csrf
                    <select name="status" class="status-select">
                        <option value="">Move to…</option>
                        @foreach($statusOptions['approved'] as $val => $label)
                            <option value="{{ $val }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="notes" class="note-input" placeholder="Reason (optional)">
                    <button type="submit" class="btn-status">Update</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6">
            <div class="empty-state">
                <div class="icon">👤</div>
                <div class="label">No active drivers</div>
                <div class="sub">Add a driver or approve an application</div>
            </div>
        </td></tr>
        @endforelse
    </tbody>
</table>

{{-- ── ON LEAVE ── --}}
@elseif($tab === 'on_leave')
<table class="drivers-table">
    <thead>
        <tr><th>Name</th><th>Phone</th><th>Type</th><th>Notes</th><th>Change Status</th></tr>
    </thead>
    <tbody>
        @forelse($onLeave as $driver)
        <tr>
            <td style="font-weight:600;">{{ $driver->name }}</td>
            <td class="mono" style="color:#57534E;">{{ $driver->phone }}</td>
            <td>
                <span class="type-badge {{ $driver->driver_type === 'owner_operator' ? 'type-owner' : 'type-fleet' }}">
                    {{ $driver->driver_type === 'owner_operator' ? '🚛 Owner' : '👤 Fleet' }}
                </span>
            </td>
            <td style="font-size:12px; color:#78716C;">{{ $driver->admin_notes ?? '—' }}</td>
            <td>
                <form method="POST" action="{{ route('drivers.updateStatus', $driver->id) }}" class="status-form">
                    @csrf
                    <select name="status" class="status-select">
                        <option value="">Move to…</option>
                        @foreach($statusOptions['on_leave'] as $val => $label)
                            <option value="{{ $val }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="notes" class="note-input" placeholder="Reason (optional)">
                    <button type="submit" class="btn-status">Update</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="5">
            <div class="empty-state">
                <div class="icon">🏖</div>
                <div class="label">No drivers on leave</div>
            </div>
        </td></tr>
        @endforelse
    </tbody>
</table>

{{-- ── UNAVAILABLE ── --}}
@elseif($tab === 'unavailable')
<table class="drivers-table">
    <thead>
        <tr><th>Name</th><th>Phone</th><th>Type</th><th>Notes</th><th>Change Status</th></tr>
    </thead>
    <tbody>
        @forelse($unavailable as $driver)
        <tr>
            <td style="font-weight:600;">{{ $driver->name }}</td>
            <td class="mono" style="color:#57534E;">{{ $driver->phone }}</td>
            <td>
                <span class="type-badge {{ $driver->driver_type === 'owner_operator' ? 'type-owner' : 'type-fleet' }}">
                    {{ $driver->driver_type === 'owner_operator' ? '🚛 Owner' : '👤 Fleet' }}
                </span>
            </td>
            <td style="font-size:12px; color:#78716C;">{{ $driver->admin_notes ?? '—' }}</td>
            <td>
                <form method="POST" action="{{ route('drivers.updateStatus', $driver->id) }}" class="status-form">
                    @csrf
                    <select name="status" class="status-select">
                        <option value="">Move to…</option>
                        @foreach($statusOptions['unavailable'] as $val => $label)
                            <option value="{{ $val }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="notes" class="note-input" placeholder="Reason (optional)">
                    <button type="submit" class="btn-status">Update</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="5">
            <div class="empty-state">
                <div class="icon">🔴</div>
                <div class="label">No unavailable drivers</div>
            </div>
        </td></tr>
        @endforelse
    </tbody>
</table>

{{-- ── LEFT COMPANY ── --}}
@elseif($tab === 'left_company')
<table class="drivers-table">
    <thead>
        <tr><th>Name</th><th>Phone</th><th>Type</th><th>Notes</th><th>Status</th></tr>
    </thead>
    <tbody>
        @forelse($leftCompany as $driver)
        <tr style="opacity:0.6;">
            <td style="font-weight:600;">{{ $driver->name }}</td>
            <td class="mono">{{ $driver->phone }}</td>
            <td>
                <span class="type-badge {{ $driver->driver_type === 'owner_operator' ? 'type-owner' : 'type-fleet' }}">
                    {{ $driver->driver_type === 'owner_operator' ? '🚛 Owner' : '👤 Fleet' }}
                </span>
            </td>
            <td style="font-size:12px; color:#A8A29E;">{{ $driver->admin_notes ?? '—' }}</td>
            <td><span class="pill pill-left_company">Left</span></td>
        </tr>
        @empty
        <tr><td colspan="5">
            <div class="empty-state">
                <div class="icon">👋</div>
                <div class="label">No drivers have left</div>
            </div>
        </td></tr>
        @endforelse
    </tbody>
</table>

{{-- ── APPLICATIONS ── --}}
@elseif($tab === 'applications')

<div class="link-box">
    <div>
        <div class="section-label">Driver Signup Link — share with drivers</div>
        <div class="link-url">{{ url('/join') }}</div>
    </div>
    <button class="copy-btn"
        onclick="navigator.clipboard.writeText('{{ url('/join') }}'); this.textContent='✓ Copied!'">
        Copy Link
    </button>
</div>

@if($pending->count())
<div class="pending-grid">
    @foreach($pending as $driver)
    @php
        $truckInfo = $driver->driver_type === 'owner_operator' && $driver->admin_notes
            ? json_decode($driver->admin_notes, true) : null;
    @endphp
    <div class="pending-card" x-data="{ open: false }">
        <div class="driver-name">{{ $driver->name }}</div>
        <div class="driver-meta">
            <span>📞 {{ $driver->phone }}</span>
            <span>🪪 {{ $driver->license_number ?? '—' }}</span>
        </div>
        <div style="margin-bottom:12px;">
            <span class="type-badge {{ $driver->driver_type === 'owner_operator' ? 'type-owner' : 'type-fleet' }}">
                {{ $driver->driver_type === 'owner_operator' ? '🚛 Owner Operator' : '👤 Fleet Driver' }}
            </span>
        </div>

        @if($truckInfo)
        <div class="truck-info">
            <div style="font-size:10px; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:#A8A29E; margin-bottom:6px;">Truck Details</div>
            <div class="truck-info-row">
                <span class="truck-info-label">Registration</span>
                <span class="truck-info-val">{{ $truckInfo['truck_registration'] ?? '—' }}</span>
            </div>
            <div class="truck-info-row">
                <span class="truck-info-label">Capacity</span>
                <span class="truck-info-val">{{ $truckInfo['truck_capacity'] ?? '—' }} T</span>
            </div>
        </div>
        @endif

        <div x-show="!open">
            <div class="action-row">
                <button class="btn-approve" @click="open = true">Review & Approve</button>
                <form method="POST" action="{{ route('drivers.reject', $driver->id) }}">
                    @csrf
                    <input type="hidden" name="admin_notes" value="Rejected without review">
                    <button type="submit" class="btn-reject">Reject</button>
                </form>
            </div>
        </div>

        <div x-show="open" x-transition style="margin-top:10px;">
            <form method="POST" action="{{ route('drivers.approve', $driver->id) }}">
                @csrf
                @if($driver->driver_type === 'owner_operator')
                <div style="font-size:10px; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:#A8A29E; margin-bottom:8px;">Confirm Truck Details</div>
                <input type="text" name="registration_number" class="form-input-sm"
                       placeholder="Registration number" value="{{ $truckInfo['truck_registration'] ?? '' }}">
                <select name="truck_type_id" class="form-select-sm">
                    <option value="">Select truck type</option>
                    @foreach(\App\Models\TruckType::all() as $type)
                        <option value="{{ $type->id }}"
                            {{ ($truckInfo['truck_type_id'] ?? '') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
                <input type="number" name="capacity" class="form-input-sm"
                       placeholder="Capacity (tonnes)" value="{{ $truckInfo['truck_capacity'] ?? '' }}">
                @endif
                <textarea name="admin_notes" class="form-input-sm" placeholder="Admin notes (optional)" rows="2"></textarea>
                <div class="action-row">
                    <button type="submit" class="btn-approve">✓ Confirm Approve</button>
                    <button type="button" class="btn-reject" @click="open = false">Cancel</button>
                </div>
            </form>
        </div>

        <div class="applied-time">
            Applied {{ $driver->applied_at ? \Carbon\Carbon::parse($driver->applied_at)->diffForHumans() : 'recently' }}
        </div>
    </div>
    @endforeach
</div>
@else
<div class="empty-state">
    <div class="icon">📋</div>
    <div class="label">No pending applications</div>
    <div class="sub">Share the signup link above so drivers can apply</div>
</div>
@endif

{{-- ── REJECTED ── --}}
@elseif($tab === 'rejected')
<table class="drivers-table">
    <thead>
        <tr><th>Name</th><th>Phone</th><th>Type</th><th>Notes</th><th>Status</th></tr>
    </thead>
    <tbody>
        @foreach($rejected as $driver)
        <tr>
            <td style="font-weight:600; color:#78716C;">{{ $driver->name }}</td>
            <td class="mono" style="color:#A8A29E;">{{ $driver->phone }}</td>
            <td>
                <span class="type-badge {{ $driver->driver_type === 'owner_operator' ? 'type-owner' : 'type-fleet' }}">
                    {{ $driver->driver_type === 'owner_operator' ? 'Owner' : 'Fleet' }}
                </span>
            </td>
            <td style="font-size:12px; color:#A8A29E;">{{ $driver->admin_notes ?? '—' }}</td>
            <td><span class="pill pill-rejected">Rejected</span></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

@endsection