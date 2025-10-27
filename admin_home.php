<?php
session_start();
include 'db.php';

// Redirect if not admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch some summary data
$itemCount = $conn->query("SELECT COUNT(*) as total FROM items")->fetch_assoc()['total'] ?? 0;
$totalStock = $conn->query("SELECT SUM(quantity) as total FROM items")->fetch_assoc()['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | Crochet Ni Ate</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: #fff8f6;
      font-family: 'Poppins', sans-serif;
      color: #4a4a4a;
    }
    .navbar {
      background: #ffe6e0;
    }
    .navbar-brand {
      color: #b56576;
      font-weight: 700;
    }
    .card {
      border: none;
      border-radius: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      transition: transform 0.3s ease;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    footer {
      margin-top: 40px;
      color: #999;
    }
  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
      <a class="navbar-brand" href="#">🧶 Crochet Ni Ate Admin</a>
      <div class="collapse navbar-collapse justify-content-end">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="items.php">Manage Items</a></li>
        <li class="nav-item ms-3">
            <a href="logout.php" class="btn btn-logout"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
        </li> 
      </div>
    </div>
  </nav>

  <div class="container mt-5">
    <h2 class="text-center text-danger mb-4">Welcome, Admin <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
    <div class="row g-4 justify-content-center">

      <div class="col-md-4">
        <div class="card p-4 text-center">
          <i class="bi bi-basket2-fill fs-1 text-danger mb-2"></i>
          <h4><?= $itemCount ?></h4>
          <p>Total Items</p>
          <a href="items.php" class="btn btn-outline-danger btn-sm">Manage Items</a>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card p-4 text-center">
          <i class="bi bi-box-seam-fill fs-1 text-warning mb-2"></i>
          <h4><?= $totalStock ?></h4>
          <p>Total Stocks</p>
        </div>
      </div>

    </div>
  </div>

  <footer class="text-center mt-5 mb-3">
    © 2025 Crochet Ni Ate | Admin Dashboard
  </footer>

</body>
</html>
