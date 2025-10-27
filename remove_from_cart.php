<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $cart_id = $_POST['cart_id'];
  $user_id = $_SESSION['user_id'];

  $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
  $stmt->bind_param("ii", $cart_id, $user_id);
  $stmt->execute();
  $stmt->close();

  header("Location: my_cart.php");
  exit();
}
?>
