<div class="d-flex flex-wrap gap-2 mb-4">
    @php
        $tabs = [
            'invoices' => [
                'label' => 'Invoices',
                'route' => route('dashboard.finance.invoices'),
                'routes' => ['dashboard.finance.invoices'],
            ],
            'revenues' => [
                'label' => 'Revenues',
                'route' => route('dashboard.finance.revenues.index'),
                'routes' => [
                    'dashboard.finance.revenues.index',
                    'dashboard.finance.revenues.create',
                    'dashboard.finance.revenues.edit',
                ],
            ],
            'expenses' => [
                'label' => 'Expenses',
                'route' => route('dashboard.finance.expenses.index'),
                'routes' => [
                    'dashboard.finance.expenses.index',
                    'dashboard.finance.expenses.create',
                    'dashboard.finance.expenses.edit',
                ],
            ],
            'company-capital' => [
                'label' => 'Company Capital',
                'route' => route('dashboard.finance.company-capital.index'),
                'routes' => [
                    'dashboard.finance.company-capital.index',
                    'dashboard.finance.company-capital.edit',
                ],
            ],
        ];

        $currentKey = $active
            ?? collect(array_keys($tabs))
                ->first(function ($key) use ($tabs) {
                    return collect($tabs[$key]['routes'] ?? [])
                        ->contains(fn ($route) => request()->routeIs($route));
                })
            ?? 'invoices';
    @endphp

    @foreach ($tabs as $key => $tab)
        <a href="{{ $tab['route'] }}"
            class="btn {{ $key === $currentKey ? 'btn-primary text-white' : 'btn-outline-secondary' }} px-4 py-2 rounded-pill">
            {{ $tab['label'] }}
        </a>
    @endforeach
</div>
