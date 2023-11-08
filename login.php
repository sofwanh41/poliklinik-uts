<?php
include("inc/koneksi.php");

// Inisialisasi pesan error
$error = "";
$showSwal = false; // Flag to determine whether to show SweetAlert or not
$swalType = '';
$swalTitle = '';
$swalText = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  if (isset($_POST["signup"])) {
    $stmt = $mysqli->prepare("SELECT * FROM user WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $showSwal = true;
      $swalType = 'Error';
      $swalTitle = 'Username sudah digunakan';
      $swalText = 'Silakan pilih username lain.';
    } else {
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $mysqli->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
      $stmt->bind_param("ss", $username, $hashed_password);
      if ($stmt->execute()) {
        $showSwal = true;
        $swalType = 'success';
        $swalTitle = 'Pendaftaran berhasil';
        $swalText = 'Anda dapat login sekarang.';
      } else {
        $error = "Error: " . $stmt->error;
      }
    }
    $stmt->close();
  } elseif (isset($_POST["login"])) {
    $stmt = $mysqli->prepare("SELECT * FROM user WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
      if (password_verify($password, $row["password"])) {
        session_start();
        $_SESSION['user_id'] = $row['id'];
        header("Location: index.php");
        exit;
      } else {
        $showSwal = true;
        $swalType = 'error';
        $swalTitle = 'Login gagal';
        $swalText = 'Username atau Password salah.';
      }
    } else {
      $showSwal = true;
      $swalType = 'error';
      $swalTitle = 'Login gagal';
      $swalText = 'Username atau Password salah.';
    }
    $stmt->close();
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/login.css">
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>

  <section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">

              <div class="mb-md-5 mt-md-4 pb-5">

                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                <p class="text-white-50 mb-5">Please enter your login and password!</p>
                <form action="" method="post">
                  <div class="form-outline form-white mb-4">
                    <label class="form-label" for="typeEmailX">Username</label>
                    <input type="text" name="username" class="form-control form-control-lg" />
                  </div>

                  <div class="form-outline form-white mb-4">
                    <label class="form-label" for="typePasswordX">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" />
                  </div>

                  <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#!">Forgot password?</a></p>

                  <button class="btn btn-outline-light btn-lg px-5" type="submit" name="login">Login</button>

                </form>
              </div>

              <div>
                <p class="mb-0">Don't have an account? <a href="register.php" class="text-white-50 fw-bold">Sign Up</a>
                </p>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</body>

</html>