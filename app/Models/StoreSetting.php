<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    protected $table = 'store_settings';
    protected $fillable = [
        'store_name', 'address', 'phone',
        'notif_email', 'notif_stock', 'notif_daily_report'
    ];
}
