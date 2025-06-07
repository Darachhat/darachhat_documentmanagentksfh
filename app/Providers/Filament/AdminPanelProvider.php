<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Support\Facades\FilamentView;
use Illuminate\Contracts\View\View;
use App\Filament\Widgets\StatsOverviewWidget;
use App\Filament\Widgets\RecentDocumentsWidget;
use App\Filament\Widgets\QuickActionsWidget;

class AdminPanelProvider extends PanelProvider
{

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->font('Noto Sans Khmer')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                \App\Filament\Widgets\StatsOverviewWidget::class,
                \App\Filament\Widgets\RecentDocumentsWidget::class,
                \App\Filament\Widgets\QuickActionsWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->brandName('ប្រព័ន្ធគ្រប់គ្រងឯកសារ')
            ->navigationGroups([
                'ការគ្រប់គ្រងឯកសារ',
                'ការគ្រប់គ្រងអ្នកប្រើប្រាស់',
            ]);
    }

    public function boot(): void
    {
        FilamentView::registerRenderHook(
            'panels::head.end',
            fn (): string => '
                <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
                <style>
                    :root {
                        --font-sans: "Noto Sans Khmer", ui-sans-serif, system-ui, sans-serif;
                    }

                    .fi-main,
                    .fi-sidebar,
                    .fi-topbar,
                    .fi-body,
                    body {
                        font-family: "Noto Sans Khmer", ui-sans-serif, system-ui, sans-serif !important;
                    }

                    .fi-ta-text,
                    .fi-fo-field-wrp,
                    .fi-input,
                    .fi-select-input,
                    .fi-textarea,
                    .fi-btn,
                    .fi-badge,
                    .fi-ta-header-cell,
                    .fi-ta-cell,
                    .fi-fo-label {
                        font-family: "Noto Sans Khmer", sans-serif !important;
                        line-height: 1.7;
                    }

                    .khmer-text {
                        font-family: "Noto Sans Khmer", sans-serif !important;
                        line-height: 1.7;
                        font-feature-settings: "kern" 1;
                        text-rendering: optimizeLegibility;
                    }
                </style>
            '
        );
    }
}
