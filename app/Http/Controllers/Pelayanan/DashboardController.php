<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pelayanan;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService,
    ) {}

    public function index()
    {
        $data = $this->dashboardService->getDashboardData(auth()->id());

        return view('pelayanan.dashboard.index', $data);
    }
}
