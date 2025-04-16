<?php

namespace Modules\PkgBlog\App\Services;

use Carbon\Carbon;
use Modules\PkgBlog\App\Models\Article;

class ChartDataService
{
    public function getChartData($model, $dateColumn)
    {
        // Fetch the total views for each month of the current year (for line chart)
        $viewsData = $model::selectRaw("MONTH($dateColumn) as month, SUM(view_count) as total_views")
            ->whereYear($dateColumn, Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Fetch the article count for each month of the current year (for bar chart)
        $articleData = $model::selectRaw("MONTH($dateColumn) as month, COUNT(*) as article_count")
            ->whereYear($dateColumn, Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Initialize arrays for monthly data, defaulting all months to 0
        $months = range(1, 12);
        $monthlyArticleCount = array_fill(1, 12, 0);
        $monthlyViewCount = array_fill(1, 12, 0);

        // Populate the monthly data for article count
        foreach ($articleData as $item) {
            $monthlyArticleCount[$item->month] = $item->article_count;
        }

        // Populate the monthly data for view count
        foreach ($viewsData as $item) {
            $monthlyViewCount[$item->month] = $item->total_views;
        }

        // Map months to short format names (Jan, Feb, etc.)
        $labels = collect($months)->map(fn($month) => Carbon::create()->month($month)->format('M'));

        // Return chart datasets for both article count and view count
        return [
            'labels' => $labels,
            'datasets' => [
                // Bar chart dataset for article count
                [
                    'label' => 'Articles Created',
                    'data' => collect($months)->map(fn($month) => $monthlyArticleCount[$month]),
                    'backgroundColor' => 'rgba(75, 192, 192, 0.6)',
                ],
                // Line chart dataset for view count
                [
                    'label' => 'Total Views',
                    'data' => collect($months)->map(fn($month) => $monthlyViewCount[$month]),
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 2,
                    'fill' => false,
                ],
            ],
        ];
    }
}
