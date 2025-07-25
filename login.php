<?php
ob_start();
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "computer_store");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        // Get name and hashed password
        $stmt = $conn->prepare("SELECT username, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($name, $hashedPassword);
            $stmt->fetch();

            if (password_verify($password, $hashedPassword)) {
                // Store in session
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $name;

                header("Location: user_dashboard.php");
                exit;
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "No account found with that email.";
        }
        $stmt->close();
    } else {
        $error = "Please enter both email and password.";
    }
}
$conn->close();
?>

<?php include "./includes/header.php"; ?>

<div class="container my-5" style="max-width: 500px;">
    <h2 class="text-center mb-4">User Login</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" name="email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
</div>

<?php include "./includes/footer.php"; ?>
<?php ob_end_flush(); ?>
