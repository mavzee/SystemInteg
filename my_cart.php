<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
include 'db.php';

$user_id = $_SESSION['user_id'];

// Get cart items
$query = $conn->prepare("
  SELECT cart.id AS cart_id, items.name, items.price, items.image, cart.quantity
  FROM cart
  INNER JOIN items ON cart.item_id = items.id
  WHERE cart.user_id = ?
");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();

$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Cart | Crochet Ni Ate</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #fff8f5;
      font-family: 'Poppins', sans-serif;
    }

    .navbar {
      background-color: #ffffff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .navbar-brand {
      font-weight: 700;
      color: #b56576 !important;
    }

    .nav-link {
      color: #7b4b64 !important;
      font-weight: 500;
    }

    .nav-link:hover {
      color: #b56576 !important;
    }

    .btn-logout {
      background-color: #b56576;
      color: #fff;
      border-radius: 10px;
      padding: 8px 16px;
      font-weight: 600;
      border: none;
    }

    .btn-logout:hover {
      background-color: #9a4a60;
    }

    h2 {
      color: #b56576;
      font-weight: 700;
      margin: 40px 0 20px;
      text-align: center;
    }

    /* CART LAYOUT */
    .cart-container {
      max-width: 1200px;
      margin: auto;
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 25px;
    }

    .cart-list {
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      padding: 20px;
    }

    .cart-item {
      display: flex;
      align-items: center;
      gap: 20px;
      border-bottom: 1px solid #f0e0e0;
      padding: 15px 0;
    }

    .cart-item:last-child {
      border-bottom: none;
    }

    .cart-item img {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 12px;
    }

    .item-info {
      flex: 1;
    }

    .item-info h5 {
      font-weight: 600;
      margin-bottom: 5px;
      color: #333;
    }

    .item-info p {
      margin: 0;
      color: #7b4b64;
      font-size: 0.9rem;
    }

    .item-price {
      font-weight: 700;
      color: #b56576;
      margin-top: 5px;
    }

    /* Quantity buttons */
    .quantity-control {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-top: 8px;
    }

    .quantity-control button {
      background-color: #b56576;
      border: none;
      color: #fff;
      font-size: 18px;
      width: 30px;
      height: 30px;
      border-radius: 6px;
      transition: 0.2s;
    }

    .quantity-control button:hover {
      background-color: #9a4a60;
    }

    .quantity-control span {
      font-weight: 600;
      min-width: 25px;
      text-align: center;
    }

    /* Remove button */
    .btn-remove {
      background: #e63946;
      border: none;
      color: #fff;
      border-radius: 8px;
      padding: 6px 12px;
      font-weight: 500;
      transition: all 0.3s;
    }

    .btn-remove:hover {
      background: #c82333;
    }

    /* Total summary */
    .cart-summary {
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      padding: 25px;
      position: sticky;
      top: 100px;
      height: fit-content;
    }

    .cart-summary h4 {
      color: #b56576;
      font-weight: 700;
      margin-bottom: 20px;
    }

    .summary-item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
      color: #333;
    }

    .summary-total {
      border-top: 1px solid #ddd;
      margin-top: 15px;
      padding-top: 15px;
      font-weight: 700;
      font-size: 1.2rem;
      color: #7b4b64;
    }

    .btn-checkout {
      background-color: #b56576;
      color: #fff;
      border: none;
      border-radius: 12px;
      width: 100%;
      padding: 12px;
      font-weight: 600;
      margin-top: 20px;
      transition: 0.3s;
    }

    .btn-checkout:hover {
      background-color: #9a4a60;
    }

    @media (max-width: 991px) {
      .cart-container {
        grid-template-columns: 1fr;
      }

      .cart-summary {
        position: relative;
        top: 0;
      }
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container">
    <a class="navbar-brand" href="user_home.php">🧶 Crochet Ni Ate</a>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item"><a class="nav-link" href="user_home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="shop.php">Shop</a></li>
        <li class="nav-item"><a class="nav-link active" href="my_cart.php">My Cart 🛒</a></li>
        <li class="nav-item ms-3">
          <a href="logout.php" class="btn btn-logout">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<h2>🛍️ My Shopping Cart</h2>

<div class="container cart-container">
  <!-- Cart List -->
  <div class="cart-list">
    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): 
        $subtotal = $row['price'] * $row['quantity'];
        $total += $subtotal;
      ?>
      <div class="cart-item">
        <img src="img/<?php echo htmlspecialchars($row['image']); ?>" alt="Product Image">
        <div class="item-info">
          <h5><?php echo htmlspecialchars($row['name']); ?></h5>
          <p class="item-price">₱<?php echo number_format($row['price'], 2); ?></p>

          <div class="quantity-control">
            <form action="update_cart.php" method="POST" style="display:flex;align-items:center;">
              <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
              <button type="submit" name="action" value="decrease">−</button>
              <span><?php echo $row['quantity']; ?></span>
              <button type="submit" name="action" value="increase">+</button>
            </form>
          </div>
          <p class="mt-2"><strong>Subtotal:</strong> ₱<?php echo number_format($subtotal, 2); ?></p>
        </div>
        <form action="remove_from_cart.php" method="POST">
          <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
          <button class="btn-remove">Remove</button>
        </form>
      </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="text-center text-muted py-5">Your cart is empty 🧺</p>
    <?php endif; ?>
  </div>

  <!-- Summary -->
  <div class="cart-summary">
    <h4>Order Summary</h4>
    <div class="summary-item"><span>Items Total:</span><span>₱<?php echo number_format($total, 2); ?></span></div>
    <div class="summary-item"><span>Shipping:</span><span>₱50.00</span></div>
    <div class="summary-total"><span>Total:</span><span>₱<?php echo number_format($total + 50, 2); ?></span></div>
<br>
    <a href="#" class="btn-checkout">Proceed to Checkout</a>
  </div>
</div>

</body>
</html>
