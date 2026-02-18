# Filament Tabbed Dashboard

Dashboard com abas no Filament via trait. Sem config, usa componentes padrão do Filament.

## Requisitos

- PHP 8.2+
- Laravel 11 ou 12
- Filament 4 ou 5

## Instalação

```bash
composer require alessandro-nuunes/filament-tabbed-dashboard
```

O ServiceProvider é registrado automaticamente. Nenhum registro de plugin no painel é obrigatório.

## Uso

No seu Dashboard (ex.: `app/Filament/Admin/Pages/Dashboard.php`):

1. Use o trait `HasTabbedDashboard`.
2. Implemente `getTabDefinitions()` com as abas.

```php
use AlessandroNuunes\FilamentTabbedDashboard\HasTabbedDashboard;
use Filament\Pages\Dashboard;

class Dashboard extends Dashboard
{
    use HasTabbedDashboard;

    public function getTabDefinitions(): array
    {
        return [
            [
                'id'      => 'geral',
                'label'   => 'Geral',
                'icon'    => 'heroicon-o-home',
                'widgets' => [StatsOverview::class],
                'visible' => true,
            ],
            [
                'id'      => 'outros',
                'label'   => 'Outros',
                'icon'    => 'heroicon-o-chart-bar',
                'widgets' => [OtherWidget::class],
                'visible' => true,
            ],
        ];
    }
}
```

O trait já define a view do pacote. Opcionalmente você pode estender `AlessandroNuunes\FilamentTabbedDashboard\Pages\TabbedDashboard` e implementar só `getTabDefinitions()`.

### Estrutura de uma aba

| Chave          | Obrigatório | Descrição                          |
|----------------|-------------|------------------------------------|
| `id`           | sim         | Identificador único                |
| `label`        | sim         | Texto da aba                       |
| `widgets`       | sim         | Array de classes de Widget         |
| `visible`       | não         | `true` (default) ou `false`       |
| `icon`         | não         | Ícone Heroicon                     |
| `badge`        | não         | Número, string ou callable         |
| `badgeColor`   | não         | Ex.: `'primary'`, `'warning'`      |
| `badgeTooltip` | não         | Tooltip do badge                   |

## Aparência das abas (opcional)

Sobrescreva no seu Dashboard:

| Método                      | Padrão   | Efeito                                      |
|-----------------------------|----------|---------------------------------------------|
| `getTabbedTabsContained()`  | `false`  | `true` = tabs dentro de uma caixa           |
| `getTabbedTabsStyle()`      | `'default'` | `'default'`, `'pills'` ou `'boxed'`      |
| `getTabbedTabsShowIcons()`  | `true`   | `false` = esconde ícones                    |
| `getTabbedTabsVertical()`   | `false`  | `true` = tabs na vertical                   |

Para `pills` ou `boxed`, o plugin só adiciona a classe CSS `fi-tabbed-dashboard--{style}`. Para mudar o visual, adicione CSS no seu tema (ex.: `resources/css/filament/admin/theme.css`). Sem esse CSS, as abas usam o estilo padrão do Filament.

## Licença

MIT.
