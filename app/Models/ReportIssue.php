<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReportIssue extends Model
{
    /** @use HasFactory<\Database\Factories\ReportIssueFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function Report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    public function reportItem(): HasMany
    {
        return $this->hasMany(ReportItem::class);
    }

}
