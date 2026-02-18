# FilamentTabbedDashboard

A Filament plugin for FilamentTabbedDashboard.

> **Screenshot / README image:** Use an image that highlights your plugin's functionality, rather than a full-panel screenshot. Zoom and crop to the sidebar and top bar so the plugin stands out more.

## Requirements

- PHP 8.2 or higher
- Laravel 11.x or 12.x
- Filament 4.x or 5.x

## Installation

Install the package via Composer:

```bash
composer require alessandro-nuunes/filament-tabbed-dashboard
```


## Configuration

### Register the Plugin

Add the plugin to your Filament panel configuration:

```php
use AlessandroNuunes\FilamentTabbedDashboard\FilamentTabbedDashboardPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            FilamentTabbedDashboardPlugin::make(),
        ]);
}
```



## Theme / Styling (required)

For the plugin styles to work correctly, add the `@source` directive to your theme file (e.g. `resources/css/filament/admin/theme.css`):

**If installed via Composer (vendor):**

```css
@source '../../../../vendor/alessandro-nuunes/filament-tabbed-dashboard/resources/views/**/*';
```

**If the package is local (e.g. `packages/filament-tabbed-dashboard`):**

```css
@source '../../../../packages/filament-tabbed-dashboard/resources/views/**/*';
```

Then run:

```bash
npm run build
```

## Usage

Use the trait in your Dashboard page and define the tabs:

```php
use AlessandroNuunes\FilamentTabbedDashboard\HasTabbedDashboard;
use Filament\Pages\Dashboard;

class Dashboard extends Dashboard
{
    use HasTabbedDashboard;

    public function getView(): string
    {
        return 'filament-tabbed-dashboard::filament.pages.tabbed-dashboard';
    }

    public function getTabDefinitions(): array
    {
        return [
            [
                'id' => 'geral',
                'label' => 'Geral',
                'icon' => 'heroicon-o-home',
                'widgets' => [StatsOverview::class],
                'visible' => true,
            ],
            [
                'id' => 'outros',
                'label' => 'Outros',
                'icon' => 'heroicon-o-chart-bar',
                'widgets' => [OtherWidget::class],
                'visible' => true,
            ],
        ];
    }
}
```

Or extend the package's `TabbedDashboard` and only implement `getTabDefinitions()`.

---

## Customizing tab appearance

You can override these methods in your Dashboard to change how tabs look (no config — each page can have different styles):

| Method | Default | Description |
|--------|---------|-------------|
| `getTabbedTabsContained(): bool` | `false` | When `true`, tabs are rendered inside a box (Filament contained style). |
| `getTabbedTabsStyle(): string` | `'default'` | Visual style: `'default'`, `'pills'`, or `'boxed'`. Adds CSS class `fi-tabbed-dashboard--{style}`. |
| `getTabbedTabsShowIcons(): bool` | `true` | When `false`, icons are hidden in tab items. |
| `getTabbedTabsVertical(): bool` | `false` | When `true`, tabs are vertical (Filament vertical style). |

Example override:

```php
public function getTabbedTabsContained(): bool
{
    return true;
}

public function getTabbedTabsStyle(): string
{
    return 'pills';
}

public function getTabbedTabsShowIcons(): bool
{
    return false;
}
```

---

## Tab styles (pills, boxed)

The plugin **only adds CSS classes** for `pills` and `boxed` (e.g. `fi-tabbed-dashboard--pills`). It does **not** ship CSS that changes the look. To see a visual difference, add custom CSS in your theme (e.g. `resources/css/filament/admin/theme.css`).

**Example — pills style (rounded, filled active tab):**

```css
/* Pills: rounded tabs, filled active state */
.fi-tabbed-dashboard--pills .fi-tabs-item {
    border-radius: 9999px;
    padding: 0.5rem 1rem;
}
.fi-tabbed-dashboard--pills .fi-tabs-item.fi-active {
    background: var(--primary-500);
    color: white;
}
.fi-tabbed-dashboard--pills .dark .fi-tabs-item.fi-active {
    background: var(--primary-400);
    color: var(--gray-900);
}
```

**Example — boxed style (bordered container):**

```css
/* Boxed: tabs inside a bordered container */
.fi-tabbed-dashboard--boxed .fi-tabs {
    border: 1px solid var(--gray-200);
    border-radius: 0.5rem;
    padding: 0.25rem;
}
.fi-tabbed-dashboard--boxed .dark .fi-tabs {
    border-color: var(--gray-700);
}
.fi-tabbed-dashboard--boxed .fi-tabs-item.fi-active {
    background: var(--gray-100);
    border-radius: 0.375rem;
}
.fi-tabbed-dashboard--boxed .dark .fi-tabs-item.fi-active {
    background: var(--gray-700);
}
```

After editing the theme CSS, run `npm run build` (or `npm run dev`).

---

## License

This package is open-sourced software licensed under the [MIT license](LICENSE.md).

## Author

**AlessandroNuunes**
