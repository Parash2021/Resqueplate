<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    exit;
}

$name = $input['name'];
$mobile = $input['mobile'];
$donation = $input['donation'];
$address = $input['address'];
$message = $input['message'];

try {
    $db = new PDO('sqlite:database/rescueplate.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $db->prepare("INSERT INTO submissions (name, mobile, donation_type, address, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $mobile, $donation, $address, $message]);

    echo json_encode(['status' => 'success', 'message' => 'Form submitted successfully']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
