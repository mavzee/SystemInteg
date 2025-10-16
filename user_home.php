<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crochet Ni Ate| Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #f9e4e0 0%, #fdf6f0 100%);
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
    }

    .pattern {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: url('img/crochet-pattern-bg.png');
      background-repeat: repeat;
      background-size: cover;
      opacity: 0.1;
      z-index: -1;
    }

    /* Navbar */
    .navbar {
      background-color: #fffaf7;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .navbar-brand {
      font-weight: 700;
      color: #b56576 !important;
    }
    .nav-link {
      color: #7b4b64 !important;
      font-weight: 500;
      transition: all 0.3s ease;
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

    /* Hero Section */
    .hero {
      text-align: center;
      padding: 80px 20px;
    }
    .hero h1 {
      font-weight: 700;
      color: #b56576;
    }
    .hero p {
      color: #7b4b64;
      font-size: 1.1rem;
      max-width: 600px;
      margin: 10px auto 30px;
    }
    .btn-shop {
      background-color: #b56576;
      color: white;
      border-radius: 12px;
      padding: 12px 28px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s ease;
    }
    .btn-shop:hover {
      background-color: #9a4a60;
      text-decoration: none;
    }

    /* Product cards */
    .product-card {
      border: none;
      border-radius: 20px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.05);
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .product-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .product-card img {
      height: 220px;
      object-fit: cover;
    }
    .product-card .card-body {
      padding: 1rem 1.2rem;
    }
    .product-card h5 {
      color: #b56576;
      font-weight: 600;
    }
    .product-card p {
      color: #7b4b64;
      font-size: 0.9rem;
    }

    /* Footer */
    footer {
      background-color: #fffaf7;
      color: #7b4b64;
      text-align: center;
      padding: 15px;
      margin-top: 40px;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <div class="pattern"></div>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <a class="navbar-brand" href="#">🧶 Crochet Ni Ate</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center">
          <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Shop</a></li>
          <li class="nav-item"><a class="nav-link" href="#">My Orders</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Profile</a></li>
          <li class="nav-item ms-3">
            <a href="logout.php" class="btn btn-logout"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero -->
  <section class="hero">
    <h1>Welcome, <?= htmlspecialchars($username) ?>!</h1>
    <p>Continue your creative journey with Crochet Ni Ate — where every thread tells a story of comfort and craftsmanship.</p>
    <a href="#" class="btn-shop">Shop Handmade Items</a>
  </section>

  <!-- Product showcase -->
  <div class="container my-5">
    <h3 class="text-center mb-4" style="color:#b56576; font-weight:700;">✨ Featured Creations</h3>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card product-card">
          <img src="img/item1.jpg" class="card-img-top" alt="Crochet Bag">
          <div class="card-body">
            <h5>Crochet Bear</h5>
            <p>Handcrafted with love — perfect for cuddle.</p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card product-card">
          <img src="img/item2.jpg" class="card-img-top" alt="Cozy Blanket">
          <div class="card-body">
            <h5>Cozy Blanket</h5>
            <p>Soft, warm, and comforting — made with premium yarn.</p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card product-card">
          <img src="img/item3.jpg" class="card-img-top" alt="Crochet Plushie">
          <div class="card-body">
            <h5>Crochet scarf</h5>
            <p>Adorable handcrafted scarf.</p>
          </div>
        </div>
        
      </div>
    </div>
  </div>

  <footer>
    © 2025 Crochet Ni Ate• Crafted with love 🧶
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
