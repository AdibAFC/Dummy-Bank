<?php

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    $response = [
        'response_code' => 405,
        'response_message' => 'Method Not Allowed. Only POST is allowed.',
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
        'response_code' => 422,
        'response_message' => "Wrong bank credentials.",
        'data' => []
    ];
    http_response_code(422);
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
}

//Check order id is not empty
$orderId = $_POST['order_id'] ?? null;
if (empty($orderId)) {
    $response = [
        'response_code' => 422,
        'response_message' => "Order id cannot be empty.",
        'data' => []
    ];
    http_response_code(422);
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
}

//Check amount is grater than 0
$amount = $_POST['amount'] ?? null;
$refundAmount = $_POST['refund_amount'] ?? null;
if (empty($amount) || $amount <= 0 || empty($refundAmount) || $refundAmount <= 0) {
    $response = [
        'response_code' => 422,
        'response_message' => "Amount or refund amount can't be less than or equal 0.",
        'data' => []
    ];
    http_response_code(422);
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
}

//check refund  amount can't grater than amount
if ($amount < $refundAmount) {
    $response = [
        'response_code' => 422,
        'response_message' => "Refund amount can't be grater than amount.",
        'data' => []
    ];
    http_response_code(422);
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
}

//if everything ok move forward for success response
$response = [
    'response_code' => 100,
    'response_message' => "Success",
    'data' => [
        'bank_order_id' => $orderId,
        'amount' => $amount,
        'refunded_amount' => $refundAmount,
        'remaining_amount' => $amount-$refundAmount,
        'refund_at' => date("Y-m-d H:i:s")
    ]
];


echo json_encode($response, JSON_PRETTY_PRINT);
exit;
