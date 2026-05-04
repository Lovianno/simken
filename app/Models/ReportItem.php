<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportItem extends Model
{
    /** @use HasFactory<\Database\Factories\ReportItemFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function part(): BelongsTo
    {   
        return $this->belongsTo(Part::class);
    }

    public function reportIssue(): BelongsTo
    {
        return $this->belongsTo(ReportIssue::class);
    }
}
