<?php

namespace Modules\PkgBlog\App\Controllers;

use Illuminate\Http\Request;
use Modules\Core\App\Controllers\BaseController;
use Modules\PkgBlog\App\Models\Article;
use Modules\PkgBlog\App\Services\ChartDataService;

class ChartDataController extends BaseController
{
    protected $chartService;

    public function __construct(ChartDataService $chartService)
    {
        $this->chartService = $chartService;
    }

    public function articles()
    {
        return response()->json($this->chartService->getChartData(Article::class, 'created_at'));
    }
}
