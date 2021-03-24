<?php 
session_start();

if (isset($_SESSION['user'])) {
  header("Location: ./dashboard/");
}

$title = "RRP:UCP - Register";
$link = "register";

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
                                <?php 
                                $token = $_GET['t'];

                                if (isset($token)) :
                                ?>
                                <div class="text-center">
                                  <h1 class="h4 text-white-900 mb-4">Account Activation</h1>
                                </div>
                                <form id="form-activation" class="user needs-validation" method="post">
                                  <div class="form-group">
                                    <p>Klik tombol dibawah ini untuk aktivasi akun Anda.</p>
                                    <input type="hidden" name="t" value="<?= $token; ?>">
                                    <button type="submit" class="btn btn-lg btn-success" id="submit" width="100%">Click Me!</button>
                                  </div>
                                </form>
                                <?php else: ?>
                                <div class="text-center">
                                    <h1 class="h4 text-white-900 mb-4">Register</h1>
                                </div>
                                <form class="user needs-validation" id="form-register" method="post">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" name="ucp" placeholder="Masukkan UCP..." required>
                                        <small class="invalid-feedback ml-4">Harap isi bidang ini!</small>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" name="email" placeholder="Masukkan Email..." required>
                                        <small class="invalid-feedback ml-4">Harap isi bidang ini!</small>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="pass" placeholder="Masukkan kata sandi Anda..." required>
                                        <small class="invalid-feedback ml-4">Harap isi bidang ini!</small>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="cpass" placeholder="Masukkan konfirmasi kata sandi..." required>
                                        <small class="invalid-feedback ml-4">Harap isi bidang ini!</small>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-user btn-block" id="btn-submit">
                                        Register
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a href="./login" class="small text-white">Sudah mempunyai akun? Login disini.</a>
                                    <br>
                                    <a class="small text-white" href="./forgot">Lupa Kata Sandi?</a>
                                </div>
                              <?php endif; ?>
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