<x-filament-panels::page>
    @php
        $data = $this->getTabbedDashboardViewData();
    @endphp

    @if (count($data['visibleTabs']) > 1)
        <x-filament::tabs
            :contained="$data['tabsContained']"
            :label="__('filament-panels::pages/dashboard.title')"
            :vertical="$data['tabsVertical']"
            class="{{ $data['tabsClass'] }}"
        >
            @foreach ($data['visibleTabs'] as $tab)
                <x-filament::tabs.item
                    :active="$tab['isActive']"
                    :badge="$tab['badge']"
                    :badge-color="$tab['badgeColor']"
                    :badge-tooltip="$tab['badgeTooltip']"
                    :icon="$tab['icon']"
                    tag="button"
                    type="button"
                    wire:click="setActiveTab('{{ e($tab['id']) }}')"
                >
                    {{ $tab['label'] }}
                </x-filament::tabs.item>
            @endforeach
        </x-filament::tabs>
    @endif

    {{ $this->content }}
</x-filament-panels::page>
