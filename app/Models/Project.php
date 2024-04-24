<?php

namespace App\Models;

use App\Models\Quote;
use App\Models\Service;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    protected $fillable = ['quote_id', 'start_date','expected_end_date', 'actual_end_date', 'project_cost', 'project_revenue', 'status'];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'project_services');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'project_employees');
    }
}
