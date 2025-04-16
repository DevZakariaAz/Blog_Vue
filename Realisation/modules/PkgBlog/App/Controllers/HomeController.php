<?php

namespace Modules\PkgBlog\App\Controllers;

use Modules\Core\App\Controllers\BaseController;
use Modules\PkgBlog\App\Services\HomeService;

class HomeController extends BaseController
{
    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index()
    {
        try {
            return response()->json($this->homeService->getHomePageData());
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch home data',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
