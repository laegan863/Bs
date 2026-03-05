<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = Auth::user()->paymentMethods()->latest()->get();

        return view('payment.index', compact('paymentMethods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'card_name'   => ['required', 'string', 'max:255'],
            'card_number' => ['required', 'string', 'min:13', 'max:19'],
            'expiry'      => ['required', 'string', 'regex:/^\d{2}\s?\/\s?\d{2,4}$/'],
            'cvv'         => ['required', 'string', 'min:3', 'max:4'],
            'text_alerts' => ['nullable', 'boolean'],
        ]);

        $expiryParts = preg_split('/\s*\/\s*/', $validated['expiry']);
        $month = str_pad($expiryParts[0], 2, '0', STR_PAD_LEFT);
        $year = $expiryParts[1];

        if (strlen($year) === 2) {
            $year = '20' . $year;
        }

        $cardNumber = preg_replace('/\s+/', '', $validated['card_number']);
        $brand = $this->detectCardBrand($cardNumber);
        $last4 = substr($cardNumber, -4);

        Auth::user()->paymentMethods()->create([
            'card_name'             => $validated['card_name'],
            'card_number_encrypted' => $cardNumber,
            'card_number_last4'     => $last4,
            'card_brand'            => $brand,
            'expiry_month'          => $month,
            'expiry_year'           => $year,
            'cvv_encrypted'         => $validated['cvv'],
            'text_alerts'           => $request->boolean('text_alerts'),
        ]);

        return redirect()->route('payment.index')->with('success', 'Payment method added successfully!');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        if ($paymentMethod->user_id !== Auth::id()) {
            abort(403);
        }

        $paymentMethod->delete();

        return redirect()->route('payment.index')->with('success', 'Payment method removed.');
    }

    private function detectCardBrand(string $number): string
    {
        $patterns = [
            'visa'       => '/^4/',
            'mastercard' => '/^(5[1-5]|2[2-7])/',
            'amex'       => '/^3[47]/',
            'discover'   => '/^6(?:011|5)/',
        ];

        foreach ($patterns as $brand => $pattern) {
            if (preg_match($pattern, $number)) {
                return $brand;
            }
        }

        return 'unknown';
    }
}
