<?php

namespace App\Http\Controllers\PurchaseOrders;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class DraftPurchaseOrdersController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('PurchaseOrders/DraftPurchaseOrders');
    }
}
