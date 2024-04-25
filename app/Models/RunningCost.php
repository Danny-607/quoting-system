<?php

namespace App\Models;

use App\Models\Category;
use App\Models\RunningCostCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RunningCost extends Model
{
    use HasFactory;

    protected $fillable = ['running_cost_category_id', 'name', 'cost', 'date_incurred', 'repeating'];
    
    public function runningCostCategory()
    {
        return $this->belongsTo(RunningCostCategory::class, 'running_cost_category_id');
    }
}
