<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $item_id = $_POST['item_id'];
    $quantity = isset($_POST['quantity']) && $_POST['quantity'] > 0 ? (int)$_POST['quantity'] : 1;

    // Check if item already exists in the user's cart
    $check = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND item_id = ?");
    $check->bind_param("ii", $user_id, $item_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // Update quantity if already in cart
        $update = $conn->prepare("UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND item_id = ?");
        $update->bind_param("iii", $quantity, $user_id, $item_id);
        $update->execute();
        $update->close();
    } else {
        // Insert new item into cart
        $stmt = $conn->prepare("INSERT INTO cart (user_id, item_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $user_id, $item_id, $quantity);
        $stmt->execute();
        $stmt->close();
    }

    $check->close();
    header("Location: my_cart.php");
    exit();
}
?>
