<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'description', 'preliminary_price', 'status'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function services(){
        return $this->belongsToMany(Service::class, 'quote_services');
    }
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
