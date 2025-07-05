<?php
// This is just for very basic implementation reference, in production, you should validate the incoming requests and implement your backend more securely.
// Please refer to this docs for snap popup:
// https://docs.midtrans.com/en/snap/integration-guide?id=integration-steps-overview

namespace Midtrans;

require_once dirname(__FILE__) . '/../../Midtrans.php';
// Set Your server key
// can find in Merchant Portal -> Settings -> Access keys
Config::$serverKey = 'SB-Mid-server-xUTMwapgBQlA0kQ-zPgXLizT';
Config::$clientKey = 'SB-Mid-client-YpvTaAr8aG9w4Ast';

// non-relevant function only used for demo/example purpose
printExampleWarningMessage();

// Uncomment for production environment
// Config::$isProduction = true;
Config::$isSanitized = Config::$is3ds = true;

// Required

include "../../koneksi.php";
// Ambil data dari database berdasarkan order_id
$order_id = $_GET['order_id'];
$query = "SELECT * FROM pembayaran WHERE order_id='$order_id'";
$sql = mysqli_query($con, $query);
$data = mysqli_fetch_array($sql);

$nama = $data['nama'];
$email = $data['email'];
$biaya = $data['biaya']; // Total harga dari database

$transaction_details = array(
    'order_id' => $order_id,
    'gross_amount' => $biaya, // Gunakan total harga dari database
);

$item_details = array(
    array(
        'id' => 'a1',
        'price' => $biaya,
        'quantity' => 1,
        'name' => "PEMBAYARAN SEMINAR"
    ),
);

$customer_details = array(
    'first_name' => $nama,
    'last_name' => "",
    'email' => $email,
    'phone' => "",
);

$transaction = array(
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details,
    'item_details' => $item_details,
);

$snap_token = '';
try {
    $snap_token = Snap::getSnapToken($transaction);
} catch (\Exception $e) {
    echo $e->getMessage();
}



function printExampleWarningMessage() {
    if (strpos(Config::$serverKey, 'your ') != false ) {
        echo "<code>";
        echo "<h4>Please set your server key from sandbox</h4>";
        echo "In file: " . __FILE__;
        echo "<br>";
        echo "<br>";
        echo htmlspecialchars('Config::$serverKey = \'<server key>\';');
        die();
    } 
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(132deg, rgb(31, 207, 195) 0.00%, rgb(31, 145, 207) 100.00%);
            background-size: cover;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #ffffff;
        }

        .card {
            border: none;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .card-body {
            text-align: center;
            padding: 2rem;
        }

        .btn-primary {
            background: linear-gradient(90deg, #0062cc, #004085);
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            transition: all 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }

        h5 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        p {
            font-size: 1.1rem;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Registrasi Berhasil!</h5>
                <p class="card-text">Selesaikan pembayaran Anda sekarang untuk melanjutkan.</p>
                <button id="pay-button" class="btn btn-primary">Pilih Metode Pembayaran</button>

                <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
                <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo Config::$clientKey; ?>"></script>
                <script type="text/javascript">
                    document.getElementById('pay-button').onclick = function () {
                        // SnapToken acquired from previous step
                        snap.pay('<?php echo $snap_token; ?>');
                    };
                </script>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>
</html>

