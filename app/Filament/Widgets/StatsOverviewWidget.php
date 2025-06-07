<?php

namespace App\Filament\Widgets;

use App\Models\Document;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '15s';

    protected function getStats(): array
    {
        $totalDocuments = Document::count();
        $todayDocuments = Document::whereDate('created_at', today())->count();
        $thisMonthDocuments = Document::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $lastMonthDocuments = Document::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $outgoingCount = Document::where('type', 'លិខិតចេញ')->count();
        $incomingCount = Document::where('type', 'លិខិតចូល')->count();
        $totalUsers = User::count();

        // Calculate growth
        $monthlyGrowth = $lastMonthDocuments > 0
            ? (($thisMonthDocuments - $lastMonthDocuments) / $lastMonthDocuments) * 100
            : 0;

        return [
            Stat::make('សរុបឯកសារ', $totalDocuments)
                ->description('ឯកសារទាំងអស់ក្នុងប្រព័ន្ធ')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary')
                ->chart([7, 12, 18, 25, 30, 42, $totalDocuments])
                ->url(route('filament.admin.resources.documents.index')),

            Stat::make('ឯកសារថ្ងៃនេះ', $todayDocuments)
                ->description('ឯកសារបានបន្ថែមថ្ងៃនេះ')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success'),

            Stat::make('ឯកសារប្រចាំខែ', $thisMonthDocuments)
                ->description($monthlyGrowth >= 0 ? "កើនឡើង {$monthlyGrowth}%" : "ថយចុះ " . abs($monthlyGrowth) . "%")
                ->descriptionIcon($monthlyGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($monthlyGrowth >= 0 ? 'success' : 'danger')
                ->chart([
                    $lastMonthDocuments - 10,
                    $lastMonthDocuments - 5,
                    $lastMonthDocuments,
                    $thisMonthDocuments - 5,
                    $thisMonthDocuments
                ]),

            Stat::make('លិខិតចេញ', $outgoingCount)
                ->description('ឯកសារប្រភេទលិខិតចេញ')
                ->descriptionIcon('heroicon-m-arrow-up-right')
                ->color('info'),

            Stat::make('លិខិតចូល', $incomingCount)
                ->description('ឯកសារប្រភេទលិខិតចូល')
                ->descriptionIcon('heroicon-m-arrow-down-left')
                ->color('warning'),

            Stat::make('អ្នកប្រើប្រាស់', $totalUsers)
                ->description('អ្នកប្រើប្រាស់ទាំងអស់')
                ->descriptionIcon('heroicon-m-users')
                ->color('gray')
                ->url(auth()->user()->isAdmin() ? route('filament.admin.resources.users.index') : null),
        ];
    }

    protected function getColumns(): int
    {
        return 3;
    }
}
