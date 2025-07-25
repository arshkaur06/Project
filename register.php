<?php
// Set page title
$title = " - Register";

// Connect to database
$host = "localhost";
$dbname = "computer_store";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$successMessage = "";
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Required fields
    $required = ['firstName', 'lastName', 'userName', 'email', 'password', 'confirmPassword', 'address', 'city', 'province', 'postalCode'];
    foreach ($required as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            $errorMessage = "Error: Missing required field: $field";
            break;
        }
    }

    if (!$errorMessage) {
        // Sanitize inputs
        $firstName = filter_var($_POST['firstName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lastName = filter_var($_POST['lastName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $userName = filter_var($_POST['userName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $address = filter_var($_POST['address'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $city = filter_var($_POST['city'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $province = filter_var($_POST['province'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $postalCode = filter_var($_POST['postalCode'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        if ($password !== $confirmPassword) {
            $errorMessage = "Error: Password and Confirm Password do not match.";
        } else {
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);

            // Insert into users table
            $stmt = $conn->prepare("INSERT INTO users (firstName, lastName, userName, email, password, address, city, province, postalCode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $firstName, $lastName, $userName, $email, $hashedPassword, $address, $city, $province, $postalCode);

            if ($stmt->execute()) {
                $successMessage = "Signup successful! User has been registered.";
            } else {
                $errorMessage = "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}

$conn->close();
include "./includes/header.php";
?>

<!-- HTML START -->
<div class="container my-2" style="max-width: 600px;">
  <h2 class="mb-4"></h2>

  <?php if ($successMessage): ?>
    <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
  <?php elseif ($errorMessage): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
  <?php endif; ?>

  <form action="" method="POST" novalidate>
    <div class="row mb-3">
      <div class="col">
        <label for="firstName" class="form-label">First Name</label>
        <input type="text" id="firstName" name="firstName" class="form-control" required>
      </div>
      <div class="col">
        <label for="lastName" class="form-label">Last Name</label>
        <input type="text" id="lastName" name="lastName" class="form-control" required>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col">
        <label for="userName" class="form-label">User Name</label>
        <input type="text" id="userName" name="userName" class="form-control" required>
      </div>

      <div class="col">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control" required>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col">
        <label for="password" class="form-label">Password</label>
        <input type="password" id="password" name="password" class="form-control" required>
      </div>
      <div class="col">
        <label for="confirmPassword" class="form-label">Confirm Password</label>
        <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" required>
      </div>
    </div>

    <div class="mb-3">
      <label for="address" class="form-label">Address</label>
      <input type="text" id="address" name="address" class="form-control" required>
    </div>

    <div class="row mb-3">
      <div class="col">
        <label for="city" class="form-label">City</label>
        <input type="text" id="city" name="city" class="form-control" required>
      </div>
      <div class="col">
        <label for="province" class="form-label">Province</label>
        <select id="inputState" class="form-select" name="province" required>
          <option disabled selected>Choose...</option>
          <option>Alberta</option>
          <option>British Columbia</option>
          <option>Manitoba</option>
          <option>New Brunswick</option>
          <option>Newfoundland and Labrador</option>
          <option>Northwest Territories</option>
          <option>Nova Scotia</option>
          <option>Nunavut</option>
          <option>Ontario</option>
          <option>Prince Edward Island</option>
          <option>Quebec</option>
          <option>Saskatchewan</option>
          <option>Yukon</option>
        </select>
      </div>
    </div>

    <div class="mb-3">
      <label for="postalCode" class="form-label">Postal Code</label>
      <input type="text" id="postalCode" name="postalCode" class="form-control" required>
    </div>

    <div id="passwordHelp" class="form-text text-danger mb-3"></div>

    <button type="submit" class="btn btn-primary w-100">Register</button>
  </form>
</div>

<?php include "./includes/footer.php"; ?>
