<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['apartment_id', 'description', 'amount','end_date','start_date','category_id'];

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
