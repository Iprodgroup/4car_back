<?php

namespace App\Policies;
use App\Models\PaymentCard;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentCardPolicy
{
    use HandlesAuthorization;
    public function delete(User $user, PaymentCard $paymentCard)
    {
        return $user->id === $paymentCard->user_id;
    }
}
