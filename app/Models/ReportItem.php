<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportItem extends Model
{
    /** @use HasFactory<\Database\Factories\ReportItemFactory> */
    use HasFactory;

    protected $guarded = ['id'];
    public function Part()
    {
        return $this->belongsTo(Part::class);
    }
    public function ReportIssue()
    {
        return $this->belongsTo(ReportIssue::class);
    }
}
