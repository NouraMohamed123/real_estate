<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;

    protected $fillable = ['apartment_id', 'amount', 'description','end_date','start_date','discount_percentage','total_amount','percentage'];

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}
