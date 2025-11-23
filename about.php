<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
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
  <title>About | Crochet Ni Ate</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #fff8f5 0%, #f5e7ff 45%, #f9f5ff 100%);
      font-family: 'Poppins', sans-serif;
      color: #4b2f41;
      position: relative;
    }

    .pattern {
      position: fixed;
      inset: 0;
      background-image: url('img/crochet-pattern-bg.png');
      background-size: 420px;
      opacity: 0.08;
      z-index: -2;
      mix-blend-mode: multiply;
    }

    .overlay {
      position: fixed;
      inset: 0;
      backdrop-filter: blur(30px);
      z-index: -1;
    }

    .navbar {
      background: rgba(255, 255, 255, 0.9);
      box-shadow: 0 8px 30px rgba(181, 101, 118, 0.08);
      backdrop-filter: blur(16px);
    }

    .navbar-brand {
      font-weight: 700;
      color: #b56576 !important;
    }

    .nav-link {
      font-weight: 500;
      color: #7b4b64 !important;
    }

    .nav-link.active {
      color: #b56576 !important;
    }

    .btn-logout {
      background-color: #b56576;
      border: none;
      color: #fff;
      border-radius: 12px;
      padding: 8px 18px;
      font-weight: 600;
      transition: 0.3s;
    }

    .btn-logout:hover {
      background-color: #9a4a60;
    }

    .eyebrow {
      text-transform: uppercase;
      letter-spacing: 3px;
      font-size: 0.75rem;
      color: #b56576;
    }

    .hero h1 {
      font-weight: 700;
      color: #4b2f41;
    }

    .hero p {
      color: #6f4c5b;
      line-height: 1.7;
    }

    .btn-main {
      background: #b56576;
      color: #fff;
      border-radius: 14px;
      padding: 15px 35px;
      font-size: 1.15rem;
      font-weight: 600;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(181, 101, 118, 0.2);
    }

    .btn-main:hover {
      background: #9a4a60;
      color: #fff;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(181, 101, 118, 0.3);
    }

    .btn-ghost {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border: 2px solid #b56576;
      color: #b56576;
      border-radius: 14px;
      padding: 12px 28px;
      font-weight: 600;
      text-decoration: none;
      transition: 0.3s;
    }

    .btn-ghost:hover {
      background: #b56576;
      color: #fff;
    }

    .hero-card {
      background: rgba(255, 255, 255, 0.85);
      border-radius: 24px;
      padding: 30px;
      box-shadow: 0 20px 60px rgba(75, 47, 65, 0.15);
      backdrop-filter: blur(18px);
    }

    .hero-card small {
      color: #7b4b64;
    }

    .stat-card {
      border-radius: 18px;
      padding: 18px;
      background: #fff7f9;
      text-align: center;
    }

    .stat-card h3 {
      color: #b56576;
      font-weight: 700;
    }

    .story-card {
      border-radius: 24px;
      padding: 35px;
      background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(255,247,250,0.95));
      box-shadow: 0 12px 30px rgba(181, 101, 118, 0.12);
    }

    .value-card {
      border-radius: 18px;
      padding: 24px;
      background: #fff;
      box-shadow: 0 10px 32px rgba(75, 47, 65, 0.08);
      height: 100%;
    }

    .value-card i {
      font-size: 1.8rem;
      color: #b56576;
      margin-bottom: 12px;
    }

    .timeline {
      position: relative;
      padding-left: 1.5rem;
    }

    .timeline::before {
      content: '';
      position: absolute;
      left: 8px;
      top: 0;
      bottom: 0;
      width: 2px;
      background: linear-gradient(180deg, #b56576, #f8a1c4);
    }

    .timeline-item {
      position: relative;
      padding: 0 0 1.5rem 1.5rem;
    }

    .timeline-item::before {
      content: '';
      position: absolute;
      left: -3px;
      top: 6px;
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: #fff;
      border: 3px solid #b56576;
    }

    .cta-card {
      padding: 35px;
      border-radius: 26px;
      background: radial-gradient(circle at top right, #ffd1df, #fef5f8 55%);
      box-shadow: 0 18px 40px rgba(181, 101, 118, 0.2);
      text-align: center;
    }

    footer {
      padding: 25px 0;
      color: #7b4b64;
      text-align: center;
    }

    @media (max-width: 768px) {
      .hero-card {
        margin-top: 30px;
      }
    }
  </style>
</head>
<body>
  <div class="pattern"></div>
  <div class="overlay"></div>

  <nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
      <a class="navbar-brand" href="user_home.php">🧶 Crochet Ni Ate</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center">
          <li class="nav-item"><a class="nav-link" href="user_home.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="shop.php">Shop</a></li>
          <li class="nav-item"><a class="nav-link active" href="about.php">About</a></li>
          <li class="nav-item"><a class="nav-link" href="my_cart.php">My Cart 🛒</a></li>
          <li class="nav-item ms-3">
            <a href="logout.php" class="btn btn-logout">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="hero py-5">
    <div class="container">
      <div class="row g-5">
        <div class="col-lg-6 d-flex flex-column">
          <p class="eyebrow">About Crochet Ni Ate</p>
          <h1>Handmade comforts stitched with purpose.</h1>
          <p>Hi <?= htmlspecialchars($username) ?>, welcome to our studio. Crochet Ni Ate started as a sister duo sharing warmth with the community. Today every stitch still carries the same promise—slow-made quality, fair livelihoods, and joyful gifting.</p>
          <div class="mb-4">
            <a href="shop.php" class="btn-main">Explore the collection</a>
          </div>
          <div class="hero-card mt-auto">
            <small>Order fulfillment</small>
            <h4 class="mt-1 mb-0">3-5 day local delivery</h4>
            <p class="mb-0 text-muted" style="font-size:0.9rem;">Nationwide shipping & pick-up options</p>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="hero-card h-100">
            <div class="row g-4">
              <div class="col-6">
                <div class="stat-card">
                  <h3>2500+</h3>
                  <p class="mb-0">Pieces crafted</p>
                </div>
              </div>
              <div class="col-6">
                <div class="stat-card">
                  <h3>35</h3>
                  <p class="mb-0">Partner artisans</p>
                </div>
              </div>
              <div class="col-12">
                <div class="stat-card" style="background:#fef0f6;">
                  <h3>⭐ 4.9/5</h3>
                  <p class="mb-0">Community rating</p>
                </div>
              </div>
            </div>
            <div class="mt-4">
              <h5 class="mb-2">Threads we live by</h5>
              <ul class="list-unstyled mb-0" style="color:#6f4c5b;">
                <li class="mb-2"><i class="bi bi-patch-check-fill me-2 text-danger"></i>Small-batch quality control</li>
                <li class="mb-2"><i class="bi bi-heart-fill me-2 text-danger"></i>Inclusive sizing & custom palettes</li>
                <li><i class="bi bi-box-seam me-2 text-danger"></i>Plastic-free packaging promise</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="container pb-4">
    <div class="story-card">
      <div class="row g-4 align-items-center">
        <div class="col-lg-7">
          <h3>Our Story</h3>
          <p class="mb-3">From a living-room workshop to a bustling micro-studio, Crochet Ni Ate remains proudly local. We collaborate with neighborhood makers, ensuring every commission funds schooling, family care, and community spaces.</p>
          <p class="mb-0">Each drop is curated in tiny batches—once a color story sells out, another unique palette takes its place. This keeps waste low and your piece truly one-of-one.</p>
        </div>
        <div class="col-lg-5">
          <div class="p-4 rounded-4 bg-white shadow-sm h-100">
            <h6 class="text-uppercase text-muted">Materials we trust</h6>
            <ul class="mt-3 list-unstyled mb-0">
              <li class="mb-2"><i class="bi bi-flower1 me-2 text-danger"></i>Hypoallergenic natural fibers</li>
              <li class="mb-2"><i class="bi bi-droplet-half me-2 text-danger"></i>Low-impact dyes and washes</li>
              <li class="mb-2"><i class="bi bi-sunrise me-2 text-danger"></i>Sun-dried finishing</li>
              <li><i class="bi bi-recycle me-2 text-danger"></i>Reusable care kits in every parcel</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="py-5">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-4 col-md-6">
          <div class="value-card">
            <i class="bi bi-people-fill"></i>
            <h5>Community First</h5>
            <p class="mb-0">Portions of every sale go back to skills training and yarn scholarships for neighborhood moms and titas.</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="value-card">
            <i class="bi bi-palette-fill"></i>
            <h5>Design Lab</h5>
            <p class="mb-0">We co-create palettes with you—send inspiration swatches and we’ll hand-dye micro lots to match.</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="value-card">
            <i class="bi bi-box2-heart"></i>
            <h5>Thoughtful Gifting</h5>
            <p class="mb-0">Personalized notes, dust bags, and QR-linked care tips elevate every unboxing experience.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer>
    © <?= date('Y'); ?> Crochet Ni Ate · Handmade in QC with love 🧶
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
