<?php
namespace App\Repositories;

use App\Order;
use App\PayPalIPN;
use Illuminate\Http\Request;

/**
 * Class IPNRepository
 * @package App\Repositories
 */
class IPNRepository
{
    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $event
     * @param $verified
     * @param $order_id
     */
    public function handle($event, $verified, $order_id)
    {
        $object = $event->getMessage();

        if (is_numeric($order_id)) {
            $order = Order::find($order_id);
        }

        if (empty($order)) {
            $order = Order::findByTransactionId(
                $object->get('txn_id')
            )->first();
        }

        $paypal = PayPalIPN::create([
            'verified' => $verified,
            'transaction_id' => $object->get('txn_id'),
            'order_id' => $order ? $order->id : null,
            'payment_status' => $object->get('payment_status'),
            'request_method' => $this->request->method(),
            'request_url' => $this->request->url(),
            'request_headers' => json_encode($this->request->header()),
            'payload' => json_encode($this->request->all()),
        ]);

        if ($paypal->isVerified() && $paypal->isCompleted()) {
            if ($order && $order->unpaid()) {
                $order->update([
                    'payment_status' => $order::COMPLETED,
                ]);

                // notify customer
                // notify order handling staff
                // update database logic
            }
        }
    }
}
