<?php

namespace App\Models;

use CodeIgniter\Model;

class ShiprocketTokenModel extends Model
{
    protected $table = 'shiprocket_tokens';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'token',
        'expires_at'
    ];

    public $timestamps = false;
}