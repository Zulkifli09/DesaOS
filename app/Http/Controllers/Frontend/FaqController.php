<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        $faqs = Faq::where('is_active', true)
                    ->orderBy('order', 'asc')
                    ->orderBy('created_at', 'desc')
                    ->get();
                    
        return view('frontend.faq.index', compact('faqs'));
    }
}
