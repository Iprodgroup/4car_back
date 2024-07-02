<?php

namespace App\Http\Controllers;

use App\Models\PaymentCard;
use Illuminate\Http\Request;

class PaymentCardController extends Controller
{
    public function index()
    {
        return $this->response(PaymentCard::all());
    }
}
