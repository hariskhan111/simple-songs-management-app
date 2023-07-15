<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Form</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="scss/style.css">
  <?php
    session_start();
    require_once "backend/config.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["id"] = $user["id"];
            $_SESSION["email"] = $email;
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid email or password. Try Again";
            echo $error;
        }
    }
  ?>
</head>

<body class="bg-light">
<!-- Login Form -->
<div class="container">
  <div class="row vh-100 align-items-center justify-content-center">
    <div class="col-lg-4 col-md-6 col-sm-6">
      <div class="card shadow">
        <div class="card-title text-center">
          <h4 class="p-3">Login</h4>
        </div>
        <div class="card-body">
          <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
            <div class="form-group">
              <label for="username" class="form-label">Email</label>
              <input type="text" class="form-control" name="email" id="username" />
            </div>
            <div class="form-group">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" name="password" id="password" />
            </div>
            <div class="form-group">
              <input type="checkbox" class="form-check-input" id="remember" />
              <label for="remember" class="form-label">Remember Me</label>
            </div>
            <div class="d-flex justify-content-center mt-4">
              <button type="submit" class="btn btn-sm btn-outline-success main-bg">Login</button>
            </div>
            <hr>
            <div class="form-group">
              <label for="remember" class="form-label">Don't have account ? <a href="register.html">Register here</a></label>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>

</html>
