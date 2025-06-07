<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Illuminate\Contracts\View\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Register Khmer font for Filament
        FilamentView::registerRenderHook(
            'panels::head.end',
            fn (): string => '<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">'
        );

        FilamentView::registerRenderHook(
            'panels::head.end',
            fn (): string => '
                <style>
                    :root { --font-sans: "Noto Sans Khmer", ui-sans-serif, system-ui, sans-serif; }
                    body, .fi-main, .fi-sidebar, .fi-topbar { font-family: "Noto Sans Khmer", sans-serif !important; }
                    .khmer-text { font-family: "Noto Sans Khmer", sans-serif !important; line-height: 1.7; }
                </style>
            '
        );
    }
}
