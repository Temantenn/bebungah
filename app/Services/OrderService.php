<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Theme;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderService
{
    /**
     * Calculate price from theme
     */
    public function calculatePrice(Theme $theme): int
    {
        return $theme->effective_price;
    }

    /**
     * Generate unique 3-digit code for pending orders
     */
    public function generateUniqueCode(): int
    {
        do {
            $code = rand(1, 999);
        } while (Order::where('status', 'pending')->where('unique_code', $code)->exists());

        return $code;
    }

    /**
     * Generate Order Number
     */
    public function generateOrderNumber(): string
    {
        return 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6));
    }
}
