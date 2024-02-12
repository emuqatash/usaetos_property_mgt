<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class SupplyItemController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Supply/SupplyItems');
    }
}
