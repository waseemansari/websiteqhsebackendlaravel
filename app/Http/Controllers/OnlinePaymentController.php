<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OnlinePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('online-payments.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('online-payments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string',
            'amount'=>'required|string',

        ]);

        
        require_once app_path('Helpers/Crypto.php');
        $app_url = env('APP_URL');
        $orderid = time();

        $amount = $request->amount;
        $billing_name = $request->first_name . ' ' . $request->last_name;
        $billing_tel = $request->phone;
        $billing_email = $request->email;

        $merchant_data =
            'merchant_id=46422' .
            '&order_id=' . $orderid .
            '&billing_name=' . urlencode($billing_name) .
            '&billing_tel=' . urlencode($billing_tel) .
            '&billing_email=' . urlencode($billing_email) .
            '&amount=' . $amount .
            '&currency=AED' .
            '&redirect_url=' . urlencode($app_url.'/online_payment/response') .
            '&cancel_url='. urlencode($app_url.'/online_payment/response') .

        $working_key = env('CCAVENU_PUBLIC_KEY');
        $access_code = env('CCAVENU_PRIVATE_KEY');

        $encrypted_data = ccaEncrypt($merchant_data, $working_key);

        return view('online-payments.ccavenue', [
            'encrypted_data' => $encrypted_data,
            'access_code' => $access_code,
        ]);
    }


    public function response(Request $request)
    {
        require_once app_path('Helpers/Crypto.php');
        $workingKey = env('CCAVENU_PUBLIC_KEY');

        $encResponse = $request->encResp;

        $rcvdString = Crypto::decryptData($encResponse, $workingKey);

        $decryptValues = explode('&', $rcvdString);

        $response = [];

        foreach ($decryptValues as $value) {
            $data = explode('=', $value);

            if (count($data) == 2) {
                $response[$data[0]] = urldecode($data[1]);
            }
        }

        $status = $response['order_status'] ?? '';

        if ($status == 'Success') {

            // Update database
            // Send email
            // Create invoice

            return view('online-payments.success', compact('response'));

        } elseif ($status == 'Failure') {

            return view('online-payments.failed', compact('response'));

        } elseif ($status == 'Aborted') {

            return view('online-payments.aborted', compact('response'));
        }

        abort(403);
    }
}
