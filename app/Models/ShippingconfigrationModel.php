<?php
namespace App\Models;
use CodeIgniter\Model;
class ShippingconfigrationModel extends Model{
    protected $table = 'shipping_configration';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'product_id',
        'shipping_cost',
        'length',
        'breadth',
        'height',
        'weight',
        'shipping_status',
        'is_multiple'
    ];
}