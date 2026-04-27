<?php

namespace App\Models;

use CodeIgniter\Model;

class ShippingchargeModel extends Model
{
    protected $table = 'shipping_charge';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'rule_type',
        'state',
        'is_outside',
        'charge',
        'is_active'
    ];
}