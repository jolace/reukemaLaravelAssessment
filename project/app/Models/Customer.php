<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    function VisitReports()
    {
        return $this->hasMany(VisitReports::class,'customer_id','id');
    }
}
