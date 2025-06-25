<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'amount', 'reason', 'duration', 'status', 'score', 'approved_by_admin', 'scored_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
