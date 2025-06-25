<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repayment extends Model
{
    protected $fillable = ['loan_id', 'user_id', 'amount', 'channel', 'reference', 'paid_at'];
}
