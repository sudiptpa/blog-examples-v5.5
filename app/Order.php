<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * @package App
 */
class Order extends Model
{
    /**
     * @var string
     */
    protected $table = 'orders';

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = ['transaction_id', 'amount', 'payment_status'];
}
