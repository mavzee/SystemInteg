<?php
include 'db.php';
$id = $_GET['id'];
$item = $conn->query("SELECT * FROM items WHERE id=$id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $price = $_POST['price'];
  $quantity = $_POST['quantity'];

  if (!empty($_FILES['image']['name'])) {
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../img/" . $image);
  } else {
    $image = $item['image'];
  }

  $conn->query("UPDATE items SET name='$name', price='$price', quantity='$quantity', image='$image' WHERE id=$id");
  header("Location: items.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Item</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <h3>Edit Item</h3>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Item Name</label>
      <input type="text" name="name" class="form-control" value="<?= $item['name'] ?>" required>
    </div>
    <div class="mb-3">
      <label>Price</label>
      <input type="number" step="0.01" name="price" class="form-control" value="<?= $item['price'] ?>" required>
    </div>
    <div class="mb-3">
      <label>Quantity</label>
      <input type="number" name="quantity" class="form-control" value="<?= $item['quantity'] ?>" required>
    </div>
    <div class="mb-3">
      <label>Image</label><br>
      <img src="../img/<?= $item['image'] ?>" width="100"><br><br>
      <input type="file" name="image" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="items.php" class="btn btn-secondary">Cancel</a>
  </form>
</body>
</html>
