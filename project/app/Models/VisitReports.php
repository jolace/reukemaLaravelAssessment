<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitReports extends Model
{
    use HasFactory;

    protected $table = 'visit_report';

    function customer()
    {
        return $this->hasOne(Customer::class,'id','customer_id');
    }

}
