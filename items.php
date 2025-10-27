<?php
include 'db.php';

// Fetch all items
$result = $conn->query("SELECT * FROM items");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Items</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <h3>Manage Items</h3>
  <a href="add_item.php" class="btn btn-success mb-3">+ Add Item</a>
  <table class="table table-bordered table-hover">
    <thead class="table-light">
      <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><img src="../img/<?= $row['image'] ?>" width="50"></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td>₱<?= number_format($row['price'], 2) ?></td>
          <td><?= $row['quantity'] ?></td>
          <td>
            <a href="edit_item.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
            <a href="delete_item.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</body>
</html>
