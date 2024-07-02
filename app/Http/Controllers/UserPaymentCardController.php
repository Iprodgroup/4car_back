<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserPaymentCardRequest;
use App\Http\Resources\UserPaymentCard;
use Illuminate\Http\Request;

class UserPaymentCardController extends Controller
{
    public function index()
    {
        return response(UserPaymentCard::collection(auth()->user()->paymentCards));

    }

    public function store(StoreUserPaymentCardRequest $request){
        $card = auth()->user()->paymentCards()->create([
            "name" => encrypt($request->name),
            "number" => encrypt($request->number),
            'exp_date' => encrypt($request->exp_date),
            'holder_name' => encrypt($request->holder_name),
            'last_four_numbers' => encrypt($request->last_four_numbers, -4),
            'payment_card_type_id' => encrypt($request->payment_card_type_id),
        ]);

        return $this->success('Карта добавлена');
}
    public function destroy(UserPaymentCard $userPaymentCard){
        $userPaymentCard->delete();
        return $this->success('Карта успешно удалена!');
    }
}
