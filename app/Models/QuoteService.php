<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteService extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'quote_id',
        'service_id',
    ];

    // Define the relationship to the Quote model
    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    // Define the relationship to the Service model
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

}
