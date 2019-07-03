<?php

namespace Marktstand\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Cart extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'shipping' => $this->shipping(),
            'subtotal' => $this->subtotal(),
            'total' => $this->total(),
            'vat' => $this->vat(),
            'deliveries' => $this->deliveries->map(function ($delivery) {
                return new Delivery($delivery);
            }),
        ];
    }
}
