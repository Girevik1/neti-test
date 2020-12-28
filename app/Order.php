<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'name',
        'description',
        'mediator_percent',
        'state',
        'user_id',
        'execute_at',
    ];

    public function user()
    {
        return $this->hasOne('App/User', 'user_id', 'id');
    }
}
