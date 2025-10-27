<?php
session_start();

// ✅ Include database connection
include __DIR__ . '/db.php'; // ensures correct path even if folder has space

// ✅ Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $price = $_POST['price'];
  $quantity = $_POST['quantity'];

  // Handle image upload
  $image = $_FILES['image']['name'];
  $target_dir = __DIR__ . '/../img/';
  $target_file = $target_dir . basename($image);

  if (!is_dir($target_dir)) {
      mkdir($target_dir, 0777, true);
  }

  if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
      // Insert data into DB
      $stmt = $conn->prepare("INSERT INTO items (name, price, quantity, image) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("sdis", $name, $price, $quantity, $image);
      $stmt->execute();
      $stmt->close();

      header("Location: items.php");
      exit();
  } else {
      $error = "Failed to upload image.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Item | Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4 p-4 mx-auto" style="max-width:600px;">
      <h3 class="mb-4 text-center text-primary">Add New Item</h3>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">Item Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Price</label>
          <input type="number" name="price" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Quantity</label>
          <input type="number" name="quantity" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Image</label>
          <input type="file" name="image" class="form-control" accept="image/*" required>
        </div>

        <div class="d-flex justify-content-between">
          <a href="items.php" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-primary">Add Item</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
