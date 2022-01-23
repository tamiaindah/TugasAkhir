<?php

namespace App\Http\Controllers\Api;

use Midtrans\Snap;
use App\Models\Keranjang;
use App\Models\Transaksi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller {
    protected $request;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct(Request $request) {
        $this -> middleware('auth:api') -> except('notificationHandler');
        $this -> request = $request;
        // Set midtrans configuration
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');
    }
    public function store() {
        DB::transaction(function () {
            /**
             * algorithm create no invoice
             */
            $length = 10;
            $random = '';
            for ($i = 0; $i < $length; $i++) {
                $random = rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
            }
            $kode_transaksi = 'INV-'.Str::upper($random).time();

            $transaksi = Transaksi::create([
                'kode_transaksi' => $kode_transaksi,
                'customer_id' => auth() -> guard('api') -> user() -> id,
                'kurir' => $this -> request -> courier,
                'service' => $this -> request -> service,
                'ongkir' => $this -> request -> cost,
                'berat' => $this -> request -> weight,
                'nama' => $this -> request -> name,
                'no_hp' => $this -> request -> phone,
                'provinsi' => $this -> request -> province,
                'kota' => $this -> request -> city,
                'alamat' => $this -> request -> address,
                'total' => $this -> request -> grand_total,
                'snap_token' => 0,
                'status' => 'pending',
            ]);

            foreach(Keranjang::where('customer_id', auth() -> guard('api') -> user() -> id) -> get() as $keranjang) {
                //insert product ke table order
                $transaksi -> orders() -> create([
                    'transaksi_id' => $transaksi -> id,
                    'invoice' => $kode_transaksi,
                    'produk_id' => $keranjang -> produk_id,
                    'nama_produk' => $keranjang -> produk -> nama,
                    'foto' => $keranjang -> produk -> foto,
                    'qty' => $keranjang -> qty,
                    'harga' => $keranjang -> harga,
                ]);
            }

            // Buat transaksi ke midtrans kemudian save snap tokennya.
            $payload = [
                'transaction_details' => [
                    'order_id' => $transaksi -> kode_transaksi,
                    'gross_amount' => $transaksi -> total,
                ],
                'customer_details' => [
                    'first_name' => $transaksi -> nama,
                    'email' => auth() -> guard('api') -> user() -> email,
                    'phone' => $transaksi -> no_hp,
                    'shipping_address' => $transaksi -> alamat
                ]
            ];
            //create snap token
            $snapToken = Snap::getSnapToken($payload);
            $transaksi -> snap_token = $snapToken;
            $transaksi -> save();
            $this -> response['snap_token'] = $snapToken;
        });
        return response() -> json([
            'success' => true,
            'message' => 'Order Successfully',
            $this -> response
        ]);
    }
    /**
     * notificationHandler
     *
     * @param mixed $request
     * @return void
     */
    public function notificationHandler(Request $request) {
        $payload = $request -> getContent();
        $notification = json_decode($payload);
        $validSignatureKey = hash("sha512", $notification -> order_id.$notification -> status_code.$notification -> gross_amount.config('services.midtrans.serverKey'));
        if ($notification -> signature_key != $validSignatureKey) {
            return response(['message' => 'Invalid signature'], 403);
        }
        $transaction = $notification -> transaction_status;
        $type = $notification -> payment_type;
        $orderId = $notification -> order_id;
        $fraud = $notification -> fraud_status;

        //data tranaction
        $data_transaction = Transaksi::where('kode_transaksi', $orderId) -> first();
        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    /**
                     * update invoice to pending
                     */
                    $data_transaction -> update([
                        'status' => 'pending'
                    ]);
                } else {
                    /**
                     * update invoice to success
                     */
                    $data_transaction -> update([
                        'status' => 'sukses'
                    ]);
                }
            }
        }
        elseif($transaction == 'settlement') {
            /**
             * update invoice to success
             */
            $data_transaction -> update([
                'status' => 'sukses'
            ]);
        }
        elseif($transaction == 'pending') {
            /**
             * update invoice to pending
             */
            $data_transaction -> update([
                'status' => 'pending'
            ]);
        }
        elseif($transaction == 'deny') {
            /**
             * update invoice to failed
             */
            $data_transaction -> update([
                'status' => 'gagal'
            ]);
        }
        elseif($transaction == 'expire') {
            /**
             * update invoice to expired
             */
            $data_transaction -> update([
                'status' => 'expired'
            ]);
        }
        elseif($transaction == 'cancel') {
            /**
             * update invoice to failed
             */
            $data_transaction -> update([
                'status' => 'gagal'
            ]);
        }
    }
}
