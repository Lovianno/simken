<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportIssue extends Model
{
    /** @use HasFactory<\Database\Factories\ReportIssueFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function Report()
    {
        return $this->belongsTo(Report::class);
    }
    public function ReportItem()
    {
        return $this->hasMany(ReportItem::class);
    }

}
