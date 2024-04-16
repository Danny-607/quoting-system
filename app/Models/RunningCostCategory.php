<?php

namespace App\Models;

use App\Models\RunningCost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RunningCostCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function runningCosts()
    {
        return $this->hasMany(RunningCost::class, 'running_cost_category_id');
    }
}
