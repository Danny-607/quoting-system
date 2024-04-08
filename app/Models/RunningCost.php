<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RunningCost extends Model
{
    use HasFactory;

    protected $fillable = ['catagory_id', 'name', 'cost', 'type', 'date_incurred', 'reapting'];
    
    public function catagory(){
        return $this->belongsTo(Catagory::class);
    }
}
