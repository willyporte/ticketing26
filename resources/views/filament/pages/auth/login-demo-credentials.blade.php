@php
$credentials = [
    ['role' => 'Administrator', 'color' => 'violet',  'email' => 'admin@demo.com',        'password' => 'password'],
    ['role' => 'Supervisor',    'color' => 'blue',     'email' => 'supervisore@demo.com',   'password' => 'password'],
    ['role' => 'Operator',      'color' => 'emerald',  'email' => 'operatore1@demo.com',    'password' => 'password'],
    ['role' => 'Operator',      'color' => 'emerald',  'email' => 'operatore2@demo.com',    'password' => 'password'],
    ['role' => 'Client',        'color' => 'amber',    'email' => 'cliente1@demo.com',      'password' => 'password'],
    ['role' => 'Client',        'color' => 'amber',    'email' => 'cliente2@demo.com',      'password' => 'password'],
];

$badge = [
    'violet'  => 'background:#ede9fe;color:#6d28d9;',
    'blue'    => 'background:#dbeafe;color:#1d4ed8;',
    'emerald' => 'background:#d1fae5;color:#065f46;',
    'amber'   => 'background:#fef3c7;color:#92400e;',
];

$border = [
    'violet'  => '#c4b5fd',
    'blue'    => '#93c5fd',
    'emerald' => '#6ee7b7',
    'amber'   => '#fcd34d',
];
@endphp

<div style="margin-top:1.25rem;border-radius:0.75rem;border:1.5px dashed #fbbf24;background:#fffbeb;overflow:hidden;">

    {{-- Header --}}
    <div style="display:flex;align-items:center;gap:0.5rem;padding:0.6rem 1rem;background:#fef3c7;border-bottom:1px solid #fde68a;">
        <svg style="width:1rem;height:1rem;color:#d97706;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
        </svg>
        <span style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#b45309;">
            Accessi Demo
        </span>
        <span style="margin-left:auto;font-size:0.7rem;font-style:italic;color:#d97706;">
            clicca per compilare
        </span>
    </div>

    {{-- Grid credenziali --}}
    <div style="padding:0.75rem;display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;">
        @foreach($credentials as $cred)
        <button
            type="button"
            x-on:click="
                $wire.set('data.email', '{{ $cred['email'] }}');
                $wire.set('data.password', '{{ $cred['password'] }}');
            "
            style="text-align:left;border-radius:0.5rem;padding:0.625rem;
                   background:#fff;border:1px solid #e5e7eb;cursor:pointer;
                   transition:border-color 0.15s,box-shadow 0.15s;"
            onmouseover="this.style.borderColor='{{ $border[$cred['color']] }}';this.style.boxShadow='0 1px 3px rgba(0,0,0,0.08)';"
            onmouseout="this.style.borderColor='#e5e7eb';this.style.boxShadow='none';"
            onmousedown="this.style.transform='scale(0.97)';"
            onmouseup="this.style.transform='scale(1)';">

            <span style="display:inline-flex;align-items:center;border-radius:9999px;
                         padding:0.1rem 0.5rem;margin-bottom:0.35rem;
                         font-size:0.65rem;font-weight:700;{{ $badge[$cred['color']] }}">
                {{ $cred['role'] }}
            </span>
            <p style="font-size:0.7rem;font-family:monospace;color:#374151;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                {{ $cred['email'] }}
            </p>
            <p style="font-size:0.7rem;font-family:monospace;color:#9ca3af;margin:0.1rem 0 0;">
                {{ $cred['password'] }}
            </p>
        </button>
        @endforeach
    </div>

</div>
