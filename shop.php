<?php
session_start();

// 🔒 Ensure user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

include 'db.php';
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crochet Ni Ate | Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #fdf6f0;
      font-family: 'Poppins', sans-serif;
    }

    .navbar {
      background-color: #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .navbar-brand {
      font-weight: 700;
      color: #b56576 !important;
    }

    .nav-link {
      color: #7b4b64 !important;
      font-weight: 500;
      transition: 0.3s;
    }

    .nav-link:hover {
      color: #b56576 !important;
    }

    .btn-logout {
      background-color: #b56576;
      border: none;
      color: white;
      border-radius: 10px;
      padding: 8px 16px;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-logout:hover {
      background-color: #9a4a60;
    }

    h2 {
      color: #b56576;
      font-weight: 700;
      text-align: center;
      margin: 40px 0 20px;
    }

    .product-card {
      border: none;
      border-radius: 14px;
      overflow: hidden;
      background: #fff;
      box-shadow: 0 4px 15px rgba(0,0,0,0.06);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
      height: 100%;
    }

    .product-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }

    .product-card img {
      width: 100%;
      height: 250px;
      object-fit: cover;
    }

    .product-card .card-body {
      text-align: center;
      padding: 15px;
    }

    .product-card h5 {
      font-size: 1.1rem;
      font-weight: 600;
      color: #333;
      margin-bottom: 8px;
    }

    .product-card p.price {
      color: #b56576;
      font-weight: 700;
      margin-bottom: 6px;
      font-size: 1.1rem;
    }

    .product-card p.stock {
      color: #7b4b64;
      font-size: 0.9rem;
      margin-bottom: 0;
    }

    .modal-content {
      border-radius: 15px;
      overflow: hidden;
      border: none;
    }

    .modal-body {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      align-items: center;
    }

    .modal-body img {
      flex: 1 1 350px;
      max-width: 100%;
      border-radius: 12px;
      object-fit: cover;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .modal-info {
      flex: 1 1 300px;
    }

    .modal-info h3 {
      font-weight: 700;
      color: #b56576;
    }

    .modal-info .price {
      color: #b56576;
      font-size: 1.6rem;
      font-weight: 700;
    }

    .modal-info .stock {
      color: #6c757d;
      margin-bottom: 15px;
    }

    .modal-info .btn-buy {
      background-color: #b56576;
      color: white;
      border: none;
      padding: 10px 25px;
      border-radius: 10px;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .modal-info .btn-buy:hover {
      background-color: #9a4a60;
    }

    @media (max-width: 768px) {
      .modal-body {
        flex-direction: column;
        text-align: center;
      }
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <a class="navbar-brand" href="user_home.php">🧶 Crochet Ni Ate</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center">
          <li class="nav-item"><a class="nav-link" href="user_home.php">Home</a></li>
          <li class="nav-item"><a class="nav-link active" href="shop.php">Shop</a></li>
          <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
          <li class="nav-item"><a class="nav-link" href="my_cart.php">My Cart 🛒</a></li>
           
          <li class="nav-item ms-3">
            <a href="logout.php" class="btn btn-logout">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Product Section -->
  <div class="container">
    <h2>🧵 Our Crochet Creations</h2>
    <div class="row g-4">
      <?php
      $result = $conn->query("SELECT * FROM items");
      if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "
          <div class='col-xl-3 col-lg-4 col-md-6 col-sm-6'>
            <div class='card product-card'
              data-bs-toggle='modal'
              data-bs-target='#itemModal'
              data-id='{$row['id']}'
              data-name='{$row['name']}'
              data-price='{$row['price']}'
              data-quantity='{$row['quantity']}'
              data-image='img/{$row['image']}'>
              <img src='img/{$row['image']}' alt='{$row['name']}'>
              <div class='card-body'>
                <h5>{$row['name']}</h5>
                <p class='price'>₱{$row['price']}</p>
                <p class='stock'>Stock: {$row['quantity']}</p>
              </div>
            </div>
          </div>";
        }
      } else {
        echo "<p class='text-center text-muted'>No products available yet.</p>";
      }
      ?>
    </div>
  </div>

  <!-- Product Modal -->
  <div class="modal fade" id="itemModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-body">
          <img id="modalImage" src="" alt="Product Image">
          <div class="modal-info">
            <h3 id="modalName"></h3>
            <p class="price" id="modalPrice"></p>
            <p class="stock" id="modalStock"></p>
            <<form method="POST" action="add_to_cart.php" class="d-flex flex-column gap-3">
                <input type="hidden" name="item_id" id="modalItemId">
                <div class="d-flex align-items-center justify-content-start gap-3">
                    <label for="quantity" class="fw-semibold">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control w-25 text-center">
                </div>
                <button type="submit" class="btn btn-buy w-100">🛒 Add to Cart</button>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const itemModal = document.getElementById('itemModal');
    itemModal.addEventListener('show.bs.modal', event => {
      const card = event.relatedTarget;
      document.getElementById('modalItemId').value = card.dataset.id;
      document.getElementById('modalName').textContent = card.dataset.name;
      document.getElementById('modalPrice').textContent = '₱' + card.dataset.price;
      document.getElementById('modalStock').textContent = 'Available Stock: ' + card.dataset.quantity;
      document.getElementById('modalImage').src = card.dataset.image;
    });
  </script>
</body>
</html>
