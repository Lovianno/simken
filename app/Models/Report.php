<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /** @use HasFactory<\Database\Factories\ReportFactory> */
    use HasFactory;

    protected $guarded = ['id'];


    public function Vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function User(){
        return $this->belongsTo(User::class);
    }
    public function ReportIssue(){
        return $this->hasMany(ReportIssue::class);
    }
}
