<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catagory extends Model
{
    use HasFactory;

    protected $fillable = ["name"];

    public function runningCosts(){
        return $this->hasMany(RunningCost::class);
    }
}
