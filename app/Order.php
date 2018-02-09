<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Order
 * @package App
 */
class Order extends Model
{
    use SoftDeletes;

    const COMPLETED = 1;
    const PENDING = 0;

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

    /**
     * @param Builder $query
     * @param string $transaction_id
     * @return mixed
     */
    public function scopeFindByTransactionId($query, $transaction_id)
    {
        return $query->where('transaction_id', $transaction_id);
    }

    /**
     * @param Builder $query
     * @param $order_id
     * @return mixed
     */
    public function scopeFindById($query, $order_id)
    {
        return $query->where('id', $order_id);
    }

    /**
     * Payment completed.
     *
     * @return boolean
     */
    public function paid()
    {
        return in_array($this->payment_status, [self::COMPLETED]);
    }

    /**
     * Payment is still pending.
     *
     * @return boolean
     */
    public function unpaid()
    {
        return in_array($this->payment_status, [self::PENDING]);
    }
}
