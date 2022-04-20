<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\PaymentSchedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Unicodeveloper\Paystack\Paystack;
use App\Notifications\VerifyPhoneNumber;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Notification;

class PaymentController extends Controller
{
    public $paystack;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->paystack = new Paystack();
    }


    public function redirectToGateway(Request $request)
    {
        return $this->paystack->getAuthorizationUrl()->redirectNow();
    }
    public function handleGatewayCallback()
    {

        $paymentDetails = $this->paystack->getPaymentData(); //this comes with all the data needed to process the transaction
        // Getting the value via an array method
        $inv_id = $paymentDetails['data']['metadata']['invoiceId']; // Getting InvoiceId I passed from the form
        $status = $paymentDetails['data']['status']; // Getting the status of the transaction
        $amount = $paymentDetails['data']['amount']; //Getting the Amount


        if ($status == "success") {
            $order = Order::whereOrderNumber($inv_id)->first();
            $order->payment_status = 1;
            $order->status = Order::ORDER_RECEIVED;
            $order->save();

            toastr()->success('Payment for order, ' . $order->order_number . ' has been created successfully');

            return redirect()->route('order', $inv_id);
        }
    }
}
