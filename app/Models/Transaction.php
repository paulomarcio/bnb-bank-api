<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id', 'amount', 'description', 'check_image', 'transaction_date', 'type', 'status'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'account_id', 'created_at', 'updated_at'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
