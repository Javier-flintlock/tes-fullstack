<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Inventory extends Model
{
    use HasApiTokens, Notifiable, HasFactory;

    protected $table = 'inventory';

    protected $fillable = [
        'inventaris_id',
        'barang',
        'type',
        'serial_number',
        'spesifikasi',
        'status',
        'user_id',
        'department',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
