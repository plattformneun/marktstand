<?php

namespace Marktstand\Managers;

use Marktstand\Payment\Payment;

class PaymentsManager extends Manager
{
    /**
     * Create a new payment.
     *
     * @param array $data
     * @return Marktstand\Payment\Payment
     */
    public function create(array $data)
    {
        $payment = new Payment;

        $this->makeFillable($payment)->fill($data)->save();

        return $payment;
    }

    /**
     * Set the fillable fields.
     *
     * @return array
     */
    protected function fillable()
    {
        return [
            'amount',
            'delivery_id',
            'user_id',
            'user_type',
        ];
    }
}
