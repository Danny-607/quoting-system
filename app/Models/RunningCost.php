<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RunningCost extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'cost', 'date_incurred', 'repeating'];
    
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
