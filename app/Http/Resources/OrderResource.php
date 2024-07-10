<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'district' => $this->district,
            'city' => $this->city,
            'delivery_method' => $this->deliveryMethod,
            'town' => $this->town,
            'adres' => $this->adres,
            'orient' => $this->orient,
            'work_adres' => $this->wordAdres,
            'comment' => $this->comment,
            'coupon' => $this->coupon,
            'payment_method' => $this->paymentMethod,
            'status_id' => $this->status_id,
            'tires' => $this->tires,
        ];
    }
}
