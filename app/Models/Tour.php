<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'travel_id',
        'name',
        'start_date',
        'end_date',
        'price',
        'currency'
    ];

    public function travel() : BelongsTo
    {
        return $this->belongsTo(Travel::class);
    }
    
}
