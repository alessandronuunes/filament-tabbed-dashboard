<?php

declare(strict_types=1);

namespace AlessandroNuunes\FilamentTabbedDashboard;

use Filament\Widgets\Widget;
use Filament\Widgets\WidgetConfiguration;

trait HasTabbedDashboard
{
    public ?string $activeTab = null;

    /**
     * Cached result of getVisibleTabs(). Cleared when tab changes.
     *
     * @var array<int, array<string, mixed>>|null
     */
    protected ?array $cachedVisibleTabs = null;

    /**
     * Tab definition: id, label, icon?, widgets, visible?, badge?, badgeColor?, badgeTooltip?, footer_widgets?.
     *
     * @return array<int, array<string, mixed>>
     */
    abstract public function getTabDefinitions(): array;

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getVisibleTabs(): array
    {
        if ($this->cachedVisibleTabs !== null) {
            return $this->cachedVisibleTabs;
        }

        $this->cachedVisibleTabs = collect($this->getTabDefinitions())
            ->filter(fn (array $tab): bool => $this->resolveTabVisible($tab))
            ->filter(fn (array $tab): bool => $this->canViewTab((string) ($tab['id'] ?? '')))
            ->values()
            ->all();

        return $this->cachedVisibleTabs;
    }

    public function setActiveTab(string $tabId): void
    {
        $this->activeTab = $tabId;
        $this->cachedVisibleTabs = null;
        unset(
            $this->cachedFooterWidgetsSchemaComponents,
            $this->cachedHeaderWidgetsSchemaComponents
        );
    }

    public function getEffectiveActiveTab(): string
    {
        $visible = $this->getVisibleTabs();
        $defaultId = $this->getDefaultTabId();
        if ($defaultId !== null && collect($visible)->contains('id', $defaultId)) {
            return $defaultId;
        }
        if ($this->activeTab !== null && collect($visible)->contains('id', $this->activeTab)) {
            return $this->activeTab;
        }
        $first = $visible[0] ?? null;

        return $first !== null ? (string) $first['id'] : '';
    }

    /**
     * @return array<class-string<Widget> | WidgetConfiguration>
     */
    public function getWidgets(): array
    {
        $tabs = $this->getVisibleTabs();
        $activeId = $this->getEffectiveActiveTab();
        $active = collect($tabs)->firstWhere('id', $activeId);
        $widgets = $active['widgets'] ?? [];

        return is_array($widgets) ? $widgets : [];
    }

    /**
     * @return array<class-string<Widget> | WidgetConfiguration>
     */
    protected function getFooterWidgets(): array
    {
        $tabs = $this->getVisibleTabs();
        $activeId = $this->getEffectiveActiveTab();
        $active = collect($tabs)->firstWhere('id', $activeId);
        $footer = $active['footer_widgets'] ?? [];

        return is_array($footer) ? $footer : [];
    }

    public function resolveTabBadge(array $tab): mixed
    {
        $badge = $tab['badge'] ?? null;
        if (is_callable($badge)) {
            return $badge($this);
        }

        return $badge;
    }

    public function resolveTabVisible(array $tab): bool
    {
        $visible = $tab['visible'] ?? true;
        if (is_callable($visible)) {
            return (bool) $visible($this);
        }

        return (bool) $visible;
    }

    public function canViewTab(string $tabId): bool
    {
        return true;
    }

    public function getDefaultTabId(): ?string
    {
        return null;
    }

    public function mountHasTabbedDashboard(): void
    {
        $visible = $this->getVisibleTabs();
        if ($this->activeTab === null && ($first = $visible[0] ?? null) !== null) {
            $this->activeTab = (string) $first['id'];
        }
    }

    /**
     * Whether the tabs container is contained (boxed). Override in your Dashboard to change.
     */
    public function getTabbedTabsContained(): bool
    {
        return false;
    }

    /**
     * Visual style of the tabs: 'default', 'pills', or 'boxed'. Override in your Dashboard to change.
     * Adds CSS class fi-tabbed-dashboard--{style} for custom styling.
     */
    public function getTabbedTabsStyle(): string
    {
        return 'default';
    }

    /**
     * Whether to show icons in tab items. Override in your Dashboard to change.
     */
    public function getTabbedTabsShowIcons(): bool
    {
        return true;
    }

    /**
     * Whether tabs are vertical. Override in your Dashboard to change.
     */
    public function getTabbedTabsVertical(): bool
    {
        return false;
    }

    public function getView(): string
    {
        return 'filament-tabbed-dashboard::filament.pages.tabbed-dashboard';
    }

    /**
     * Data for the tabbed dashboard view (single place for view logic, avoids XSS and duplicate calls).
     *
     * @return array{visibleTabs: array<int, array{id: string, label: string, isActive: bool, badge: mixed, badgeColor: mixed, badgeTooltip: mixed, icon: mixed}>, tabsContained: bool, tabsStyle: string, tabsShowIcons: bool, tabsVertical: bool, tabsClass: string}
     */
    public function getTabbedDashboardViewData(): array
    {
        $visibleTabs = $this->getVisibleTabs();
        $effectiveActiveTab = $this->getEffectiveActiveTab();
        $tabsStyle = $this->getTabbedTabsStyle();
        $tabsShowIcons = $this->getTabbedTabsShowIcons();

        $tabsClass = 'fi-page-sub-navigation-tabs mb-6';
        if ($tabsStyle !== 'default') {
            $tabsClass .= ' fi-tabbed-dashboard fi-tabbed-dashboard--'.$tabsStyle;
        }

        $tabsForView = [];
        foreach ($visibleTabs as $tab) {
            $tabId = (string) ($tab['id'] ?? '');
            $tabsForView[] = [
                'id' => $tabId,
                'label' => (string) ($tab['label'] ?? $tabId),
                'isActive' => $effectiveActiveTab === $tabId,
                'badge' => $this->resolveTabBadge($tab),
                'badgeColor' => $tab['badgeColor'] ?? null,
                'badgeTooltip' => $tab['badgeTooltip'] ?? null,
                'icon' => $tabsShowIcons ? ($tab['icon'] ?? null) : null,
            ];
        }

        return [
            'visibleTabs' => $tabsForView,
            'tabsContained' => $this->getTabbedTabsContained(),
            'tabsStyle' => $tabsStyle,
            'tabsShowIcons' => $tabsShowIcons,
            'tabsVertical' => $this->getTabbedTabsVertical(),
            'tabsClass' => $tabsClass,
        ];
    }
}
