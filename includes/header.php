<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Computer Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="/Project/index.php">Online Computer Store</a>
    <form class="d-flex" method="GET" action="/Project/index.php">
    <input class="form-control me-2" type="search" name="search" placeholder="Search products by category..." aria-label="Search" style="max-width: 250px">
    <button class="btn btn-outline-light" type="submit">Search</button>
    </form>



    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <?php if (!isset($_SESSION['user'])): ?>
          <li class="nav-item"><a class="nav-link" href="admins/admin_login.php" style="color: white;">Admin</a></li>
          <li class="nav-item"><a class="nav-link" href="/Project/about.php" style="color: white;">About</a></li>
          <li class="nav-item"><a class="nav-link" href="/Project/login.php" style="color: white;">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="/Project/register.php" style="color: white;">Register</a></li>
          <li class="nav-item"><a class="nav-link" href="/Project/cart.php" style="color: white;">Cart🛒</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
