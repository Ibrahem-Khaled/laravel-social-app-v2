<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\SellCoins;
use Illuminate\Http\Request;

class sellCoinsController extends Controller
{
    public function index()
    {
        $coins = SellCoins::where('is_active', true)
            ->where('platform', 'mobile') // Assuming you want to filter by platform
            ->select('id', 'amount', 'price', 'icon')
            ->orderBy('amount', 'asc')
            ->get();

        if ($coins->isEmpty()) {
            return response()->json(['message' => 'لا توجد عملات مباعة متاحة'], 404);
        }

        return response()->json(['message' => 'قائمة العملات المباعة', 'data' => $coins]);
    }
}
