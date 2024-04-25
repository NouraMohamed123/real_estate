<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;
    protected $fillable = [
        'apartment_name',
        'apartment_number',
        'photo',
        'owner_id',
        'apartment_address',
        'owner_phone',
        'total_amount'
    ];
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
    public function rents()
    {
        return $this->hasMany(Rent::class);
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id')->select('id', 'name');
    }
}
