<?php 
session_start();

if (isset($_SESSION['user'])) {
  header("Location: ./dashboard/");
}

$title = "RRP:UCP - Forgot";
$link = "forgot";

$code = $_GET['code'];

include "templates/auth/header.php";
?>

  <?php 
    if (isset($code)) :
  ?>
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center mt-5">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5 bg-gradient-dark text-white">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-white-900 mb-4">Reset Password</h1>
                                    </div>
                                    <form class="user needs-validation" id="form-resetpass" method="post">
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="oldpass" placeholder="Masukkan kata sandi lama..." required>
                                            <small class="invalid-feedback ml-3">Harap isi bidang ini</small>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="newpass" placeholder="Masukkan kata sandi baru..." required>
                                            <small class="invalid-feedback ml-3">Harap isi bidang ini</small>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="cnewpass" placeholder="Masukkan konfirmasi kata sandi..." required>
                                            <small class="invalid-feedback ml-3">Harap isi bidang ini</small>
                                        </div>
                                        <input type="hidden" name="code" value="<?= $code; ?>">
                                        <button type="submit" class="btn btn-success btn-user btn-block" id="submit-reset">
                                            Reset Password
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        </div>
  <?php
    else:
  ?>

  <div class="container">

      <!-- Outer Row -->
      <div class="row justify-content-center mt-5">

          <div class="col-xl-10 col-lg-12 col-md-9">

              <div class="card o-hidden border-0 shadow-lg my-5 bg-gradient-dark text-white">
                  <div class="card-body p-0">
                      <!-- Nested Row within Card Body -->
                      <div class="row">
                          <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                          <div class="col-lg-6">
                              <div class="p-5">
                                  <div class="text-center">
                                      <h1 class="h4 text-white-900 mb-4">Lupa Kata Sandi</h1>
                                  </div>
                                  <form class="user needs-validation" id="form-forgotpass" method="post">
                                      <div class="form-group">
                                          <input type="email" class="form-control form-control-user" name="email" placeholder="Masukkan Email Anda..." required>
                                          <small class="invalid-feedback ml-3">Harap isi bidang ini dan masukkan format email yang benar!</small>
                                      </div>
                                      <button type="submit" class="btn btn-success btn-user btn-block" id="submit-forgot">
                                          Reset Password
                                      </button>
                                  </form>
                                  <hr>
                                  <div class="text-center">
                                      <a class="small text-white" href="./login">Sudah mempunyai akun? Login!</a>
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
    endif; 
  ?>

<?php 
include "templates/auth/footer.php";
?>