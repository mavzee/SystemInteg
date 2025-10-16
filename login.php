<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            if ($row['role'] === 'admin') {
                header("Location: admin_home.php");
            } else {
                header("Location: user_home.php");
            }
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crochet Haven | Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #f9e4e0 0%, #fdf6f0 100%);
      font-family: 'Poppins', sans-serif;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-card {
      background-color: #fffaf7;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      width: 380px;
      padding: 2rem;
      
    }

    .login-header {
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .login-header h2 {
      font-weight: 700;
      color: #b56576;
    }

    .login-header p {
      color: #99627a;
      font-size: 0.9rem;
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

    .btn-login {
      background-color: #b56576;
      color: white;
      border-radius: 12px;
      width: 100%;
      font-weight: 600;
      padding: 0.8rem;
      transition: all 0.3s ease;
    }

    .btn-login:hover {
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

    .info {
      color: #0b7a75;
      background: #e5fff7;
      border-radius: 10px;
      padding: 10px;
      text-align: center;
      margin-bottom: 15px;
      font-size: 0.9rem;
    }

    .register-link {
      display: block;
      text-align: center;
      margin-top: 15px;
      color: #b56576;
      font-weight: 500;
    }

    .register-link:hover {
      color: #9a4a60;
      text-decoration: underline;
    }

    /* Optional crochet pattern background (soft texture) */
    /* Optional crochet pattern background (soft texture) */
    .pattern {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('img/wool-elements-space-right.jpg'); /* ✅ correct folder path */
    background-repeat: repeat;
    background-size: cover; /* or 'contain' if you want the full image visible */
    opacity: 0.50; /* make it subtle */
    z-index: -1; /* keep it behind everything */
    }


  </style>
</head>
<body>
  <div class="pattern"></div>
  <div class="login-card">
    <div class="login-header">
      <h2>🧶 Crochet Ni Ate</h2>
      <p></p>
    </div>

    <?php if(isset($_SESSION['msg'])) { echo "<p class='info'>".$_SESSION['msg']."</p>"; unset($_SESSION['msg']); } ?>
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

      <button type="submit" class="btn btn-login">Login</button>
    </form>

    <a href="signup.php" class="register-link">Create an account</a>
  </div>
</body>
</html>
