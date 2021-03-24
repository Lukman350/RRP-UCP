<?php 
session_start();

if (isset($_SESSION['user'])) {
  header("Location: ./dashboard/");
}

$title = "RRP:UCP - Login";
$link = "login";

include "templates/auth/header.php";
?>

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center mt-5">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5 bg-gradient-dark text-white">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-white-900 mb-4">Login</h1>
                                </div>
                                <form class="user needs-validation" id="form-login" method="post">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" name="ucp" placeholder="Masukkan UCP atau Email Anda..." required>
                                        <small class="invalid-feedback ml-4">Harap isi bidang ini!</small>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="pass" placeholder="Masukkan kata sandi Anda..." required>
                                        <small class="invalid-feedback ml-4">Harap isi bidang ini!</small>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-user btn-block" id="btn-submit">
                                        Login
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a href="./register" class="small text-white">Belum punya akun? Register disini.</a>
                                    <br>
                                    <a class="small text-white" href="./forgot">Lupa Kata Sandi?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

  </div>

<?php 
include "templates/auth/footer.php";
?>