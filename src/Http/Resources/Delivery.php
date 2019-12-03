<?php

namespace Marktstand\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Config;

class Delivery extends JsonResource
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
           'days' => $this->days(Config::get('marktstand.period')),
           'subtotal' => $this->subtotal(),
           'shipping' => $this->shipping(),
           'minimum_order_value' => $this->minimumOrderValue(),
           'vat' => $this->vat(),
           'supplier' => $this->supplier(),
           'items' => $this->items(),
        ];
    }
}
