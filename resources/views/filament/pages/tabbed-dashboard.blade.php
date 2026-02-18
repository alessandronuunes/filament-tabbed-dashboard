<x-filament-panels::page>
    @php
        $data = $this->getTabbedDashboardViewData();
        $hasMultipleTabs = count($data['visibleTabs']) > 1;
        $isVertical = $data['tabsVertical'];
    @endphp

    @if ($hasMultipleTabs && $isVertical)
        <div class="flex flex-row gap-6">
            <div class="shrink-0">
                <x-filament::tabs
                    :contained="$data['tabsContained']"
                    :label="__('filament-panels::pages/dashboard.title')"
                    :vertical="true"
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
            </div>
            <div class="min-w-0 flex-1">
                {{ $this->content }}
            </div>
        </div>
    @else
        @if ($hasMultipleTabs)
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
    @endif
</x-filament-panels::page>
