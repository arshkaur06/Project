<?php
session_start();
$admin_user = "admin";
$admin_pass = "admin@123";

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if ($user === $admin_user && $pass === $admin_pass) {
        $_SESSION['admin'] = $user;
        header("Location: /Project/admins/admin_dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<?php include("../includes/header.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Login</title>
  <style>
    body {
      background: #f0f2f5;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
    }

    .login-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 80vh;
    }

    .login-container {
      background: white;
      padding: 30px 40px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      width: 320px;
      text-align: center;
    }

    h2 {
      margin-bottom: 20px;
      color: #333;
    }

    input[type="text"],
    input[type="password"] {
      width: 70%;
      padding: 12px 15px;
      margin: 8px 0 16px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
    }

    button {
      width: 70%;
      padding: 12px;
      background: #007bff;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 1rem;
      cursor: pointer;
    }

    .error-message {
      color: #d9534f;
      margin-bottom: 15px;
      font-weight: 600;
    }
  </style>
</head>
<body>

<div class="login-wrapper">
  <div class="login-container">
    <h2>Admin Login</h2>
    <?php if ($error): ?>
      <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="">
      <input name="username" type="text" placeholder="Username" required />
      <input name="password" type="password" placeholder="Password" required />
      <button type="submit">Login</button>
    </form>
  </div>
</div>

<?php include("../includes/footer.php"); ?>
</body>
</html>