<div style="display:flex; flex-direction:column; gap:1.25rem; padding:0.25rem 0;">

    {{-- ── Cliente ─────────────────────────────────────────────────────────── --}}
    <div>
        <p style="font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:#6b7280; margin-bottom:0.35rem;">
            {{ __('tickets.modal.client') }}
        </p>
        <p style="font-size:0.875rem; font-weight:600; color:inherit; margin:0;">{{ $ticket->creator->name }}</p>
        <p style="font-size:0.875rem; color:#6b7280; margin:0.1rem 0 0;">{{ $ticket->creator->email }}</p>
    </div>

    {{-- ── Azienda ──────────────────────────────────────────────────────────── --}}
    <div>
        <p style="font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:#6b7280; margin-bottom:0.35rem;">
            {{ __('tickets.modal.company') }}
        </p>
        <p style="font-size:0.875rem; font-weight:600; color:inherit; margin:0;">{{ $ticket->company->name }}</p>
        @if($ticket->company->vat_number)
            <p style="font-size:0.875rem; color:#6b7280; margin:0.1rem 0 0;">P.IVA {{ $ticket->company->vat_number }}</p>
        @endif
        @if($ticket->company->email)
            <p style="font-size:0.875rem; color:#6b7280; margin:0.1rem 0 0;">{{ $ticket->company->email }}</p>
        @endif
        @if($ticket->company->phone)
            <p style="font-size:0.875rem; color:#6b7280; margin:0.1rem 0 0;">{{ $ticket->company->phone }}</p>
        @endif
    </div>

    {{-- ── Operatore assegnato ─────────────────────────────────────────────── --}}
    <div>
        <p style="font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:#6b7280; margin-bottom:0.35rem;">
            {{ __('tickets.modal.assignee') }}
        </p>
        @if($ticket->assignee)
            <p style="font-size:0.875rem; font-weight:600; color:inherit; margin:0;">{{ $ticket->assignee->name }}</p>
            <p style="font-size:0.875rem; color:#6b7280; margin:0.1rem 0 0;">{{ $ticket->assignee->email }}</p>
        @else
            <p style="font-size:0.875rem; color:#6b7280; margin:0;">{{ __('tickets.dashboard.unassigned') }}</p>
        @endif
    </div>

    {{-- ── Abbonamento e minuti residui ────────────────────────────────────── --}}
    <div>
        <p style="font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:#6b7280; margin-bottom:0.35rem;">
            {{ __('tickets.modal.subscription') }}
        </p>

        @if($subscription)
            @php
                $minutes  = $subscription->minutes_remaining;
                $isNeg    = $minutes <= 0;
                $isLow    = ! $isNeg && $subscription->isBelowWarningThreshold();
                $pct      = $subscription->remainingPercentage();

                $minutesColor = $isNeg ? '#dc2626' : ($isLow ? '#d97706' : '#16a34a');
                $badgeBg      = $isNeg ? '#fee2e2' : '#fef3c7';
                $badgeColor   = $isNeg ? '#b91c1c' : '#92400e';
                $barColor     = $isNeg ? '#ef4444' : ($isLow ? '#f59e0b' : '#22c55e');
            @endphp

            <p style="font-size:0.875rem; font-weight:600; color:inherit; margin:0;">{{ $subscription->plan->name }}</p>
            <p style="font-size:0.875rem; color:#6b7280; margin:0.1rem 0 0;">
                {{ $subscription->starts_at->format('d/m/Y') }} &rarr; {{ $subscription->expires_at->format('d/m/Y') }}
            </p>

            <div style="display:flex; align-items:center; gap:0.5rem; margin-top:0.4rem;">
                <span style="font-size:0.875rem; font-weight:700; color:{{ $minutesColor }};">
                    {{ $minutes }} {{ __('tickets.modal.minutes_remaining') }}
                </span>
                @if($isNeg || $isLow)
                    <span style="font-size:0.7rem; font-weight:600; padding:0.15rem 0.5rem; border-radius:9999px; background:{{ $badgeBg }}; color:{{ $badgeColor }};">
                        {{ $isNeg ? __('tickets.modal.negative_balance') : __('tickets.modal.low_balance') }}
                    </span>
                @endif
            </div>

            <div style="margin-top:0.5rem;">
                <div style="height:6px; width:100%; border-radius:9999px; background:#e5e7eb; overflow:hidden;">
                    <div style="height:6px; border-radius:9999px; background:{{ $barColor }}; width:{{ $pct }}%;"></div>
                </div>
                <p style="font-size:0.7rem; color:#9ca3af; margin:0.25rem 0 0;">{{ $pct }}% {{ __('tickets.modal.remaining') }}</p>
            </div>

        @else
            <p style="font-size:0.875rem; color:#6b7280; margin:0;">{{ __('tickets.modal.no_subscription') }}</p>
        @endif
    </div>

</div>
