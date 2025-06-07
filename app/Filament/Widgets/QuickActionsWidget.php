<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class QuickActionsWidget extends Widget
{
    protected static string $view = 'filament.widgets.quick-actions';

    protected int | string | array $columnSpan = 1;

    protected function getViewData(): array
    {
        return [
            'canCreateDocuments' => auth()->user()->isAdmin(),
            'canManageUsers' => auth()->user()->isAdmin(),
        ];
    }
}
