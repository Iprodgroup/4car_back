<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'district' => $this->district,
            'city' => $this->city,
            'delivery_method' => $this->delively_method,
            'town' => $this->town,
            'adres' => $this->adres,
            'orient' => $this->orient,
            'work_adres' => $this->work_adres,
            'comment' => $this->comment,
            'coupon' => $this->coupon,
            'payment_method' => $this->payment_method,
            'status_id' => $this->status ? $this->status->name : null,
            'products' => $this->products,
        ];
    }
}
