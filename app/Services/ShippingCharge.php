<?php
namespace App\Services;
use App\Models\ShippingchargeModel;
class ShippingCharge{
    public function calculate($cartTotal, $state)
    {
        $model = new ShippingchargeModel();

        // Normalize state
        $state = ucfirst(strtolower(trim($state)));

        // ✅ Free shipping (optional)
        if ($cartTotal >= 10000) {
            return 0;
        }
        if($state) {
             // ✅ 1. Match exact state (Kerala)
            $rule = $model->where('state', $state)
                        ->where('is_active', 1)
                        ->first();

            if ($rule) {
                return $rule['charge'];
            }

            // ✅ 2. Outside state rule
            $rule = $model->where('is_outside', 1)
                        ->where('is_active', 1)
                        ->first();

            if ($rule) {
                return $rule['charge'];
            }

        }
        // ✅ 3. Default fallback
        return 0;
    }
}