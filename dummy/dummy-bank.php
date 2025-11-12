<?php

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    $response = [
        'code' => 405,
        'message' => 'Method Not Allowed. Only POST is allowed.',
        'data' => []
    ];

    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
}
//Check auth credentials
$userName = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;
if (empty($userName) || empty($password) || ($userName != "dummybank" || $password != "!apple")) {
    $response = [
        'code' => 422,
        'message' => "Wrong bank credentials.",
        'data' => []
    ];
    http_response_code(422);
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
}

//Check card information
$cardNo = $_POST['card_no'] ?? null;
$cardHolderName = $_POST['card_holder_name'] ?? null;
$cardCVV = $_POST['card_cvv'] ?? null;
$cardExp = $_POST['card_exp'] ?? null;
if (
    empty($cardNo) ||
    empty($cardHolderName) ||
    empty($cardCVV) ||
    empty($cardExp) ||
    strlen($cardExp) < 4 ||
    strlen($cardNo) < 16 ||
    strlen($cardCVV) < 3
) {
    $response = [
        'code' => 422,
        'message' => "Card number or cvv number is invalid.",
        'data' => []
    ];
    http_response_code(422);
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
}

//Check amount is grater than 0
$amount = $_POST['amount'] ?? null;
if (empty($amount) || $amount <= 0) {
    $response = [
        'code' => 422,
        'message' => "Amount can't be less than or equal 0",
        'data' => []
    ];
    http_response_code(422);
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
}

//if everything ok move forward for success response
$response = [
    'code' => 100,
    'message' => "Success",
    'data' => [
        'bank_order_id' => 'DBOI' . time() . rand(100, 999),
        'amount' => $amount,
        'payment_at' => date("Y-m-d H:i:s")
    ]
];


echo json_encode($response, JSON_PRETTY_PRINT);
exit;
