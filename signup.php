<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Validate inputs
    if (empty($username) || empty($password) || empty($confirm)) {
        $error = "⚠️ Please fill in all fields.";
    } elseif ($password !== $confirm) {
        $error = "⚠️ Passwords do not match.";
    } else {
        // Check if username already exists
        $check = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $error = "⚠️ Username already exists.";
        } else {
            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("ss", $username, $hash);

            if ($stmt->execute()) {
                $_SESSION['msg'] = "✅ Registration successful! You can now log in.";
                header("Location: login.php");
                exit();
            } else {
                $error = "⚠️ Something went wrong. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crochet Ni Ate | Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #f9e4e0 0%, #fdf6f0 100%);
      font-family: 'Poppins', sans-serif;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      position: relative;
    }

    .pattern {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: url('img/wool-elements-space-right.jpg');
      background-repeat: repeat;
      background-size: cover;
      opacity: 0.5;
      z-index: -1;
    }

    .register-card {
      background-color: #fffaf7;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      width: 380px;
      padding: 2rem;
      z-index: 2;
    }

    .register-header {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .register-header h2 {
      font-weight: 700;
      color: #b56576;
    }

    .form-label {
      color: #7b4b64;
      font-weight: 500;
    }

    .form-control {
      border-radius: 12px;
      border: 1px solid #e6c7c2;
      padding: 0.8rem;
    }

    .form-control:focus {
      border-color: #b56576;
      box-shadow: 0 0 0 0.2rem rgba(181,101,118,0.25);
    }

    .btn-register {
      background-color: #b56576;
      color: white;
      border-radius: 12px;
      width: 100%;
      font-weight: 600;
      padding: 0.8rem;
      transition: all 0.3s ease;
    }

    .btn-register:hover {
      background-color: #9a4a60;
    }

    .error {
      color: #b22222;
      background: #ffe5e5;
      border-radius: 10px;
      padding: 10px;
      text-align: center;
      margin-bottom: 15px;
      font-size: 0.9rem;
    }

    .login-link {
      display: block;
      text-align: center;
      margin-top: 15px;
      color: #b56576;
      font-weight: 500;
    }

    .login-link:hover {
      color: #9a4a60;
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="pattern"></div>
  <div class="register-card">
    <div class="register-header">
      <h2>🧶 Crochet Ni Ate</h2>
      <p>Create your account below</p>
    </div>

    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-register">Register</button>
    </form>

    <a href="login.php" class="login-link">Back to login</a>
  </div>
</body>
</html>
