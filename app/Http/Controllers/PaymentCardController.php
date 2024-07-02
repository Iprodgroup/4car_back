<?php

namespace App\Http\Controllers;

use App\Models\PaymentCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentCardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return $this->response($user->paymentCards);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required',
            'icon' => 'required',
        ]);
    

    $user = Auth::user();
    
    $paymentCard = $user->paymentCards()->create($request->all()); //PaymentCard::create($request->all());

    return $this->response($paymentCard, 201);
}

    public function destroy(PaymentCard $paymentCard)
    {
        $this->authorize('delete', $paymentCard);
        $paymentCard->delete();

        return $this->success("Карта успешно удалена", 201);
    }
}
