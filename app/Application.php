<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'applications';

    protected $fillable = [
        'state',
        'user_id',
        'order_id',
    ];

    public function order()
    {
        return $this->hasOne('App\Order', 'id', 'order_id');
    }
}
