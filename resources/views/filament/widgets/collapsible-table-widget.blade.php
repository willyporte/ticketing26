<x-filament-widgets::widget class="fi-wi-table">
    <div x-data="{ open: false }">

        {{-- Toggle bar --}}
        <div
            @click="open = !open"
            class="fi-cw-toggle"
            style="display:flex; align-items:center; justify-content:space-between; padding:0.875rem 1.25rem; border-radius:0.75rem; cursor:pointer; user-select:none; box-shadow:0 1px 3px rgba(0,0,0,0.08);"
        >
            <span class="fi-cw-title" style="font-size:0.9375rem; font-weight:600; display:inline-flex; align-items:center; gap:8px;">
                <x-dynamic-component
                    :component="$this->getCollapsibleIcon()"
                    style="width:18px; height:18px; flex-shrink:0;"
                />
                {{ $this->getCollapsibleHeading() }}
            </span>

            {{-- Arrow — `:style` as object so it MERGES with static style instead of replacing it --}}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                 class="fi-cw-arrow"
                 style="width:18px; height:18px; flex-shrink:0;"
                 :style="{ transform: open ? 'rotate(180deg)' : 'rotate(0deg)', transition: 'transform 0.2s ease' }">
                <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
            </svg>
        </div>

        {{-- Table content --}}
        <div x-show="open" style="margin-top:0.5rem;">
            {{ $this->table ?? null }}
        </div>

    </div>
</x-filament-widgets::widget>
