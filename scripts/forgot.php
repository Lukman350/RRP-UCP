<?php

include_once "../config/db.php";
include_once "../config/email.php";

$conn = new Database;

$response = [];

$email = $_POST['email'];

$data = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz1234567890!@#$%^&*()_+-=][}{|?/.><,~`";
$code = substr(str_shuffle($data),0,10);

$query = $conn->db->prepare("SELECT * FROM accounts WHERE Email = '$email'");
$query->execute();

if ($query->rowCount() > 0) {
  $user = $query->fetch(PDO::FETCH_ASSOC);
  $subject = "R:RP Forgot Password";
  $name = $user['Username'];
  $msg = "
    <table>
      <thead style='background-color: red; color: white'>
        <tr>
          <th>
            <h2 style='color: white'>Relived Roleplay</h2>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <div style='color: black; margin: 10px'>
              <p>Untuk: <b>".$name."</b></p><br>
              <p>Mohon klik link dibawah untuk mereset password akun Anda:</p><br>
              <a href='http://localhost/RRP-UCP/forgot?code=".urlencode($code)."'>
                http://localhost/RRP-UCP/forgot?code=".urlencode($code)."
              </a>
            </div>
          </td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td>
            <div style='color: white; text-align: center; font-size: 20px'>
              Copyright &copy; ".date("Y")." Relived Community. All right reserved.
            </div>
          </td>
        </tr>
      </tfoot>
    </table>
  ";
  if (SendEmail($email, $name, $subject, $msg)) {
    $sql = $conn->db->prepare("UPDATE accounts SET VerifyCode = '$code' WHERE Email = '$email'");
    if ($sql->execute()) {
      $response['status'] = true;
      $response['msg'] = "Request lupa password telah terkirim ke email Anda, silahkan cek email Anda!";
    } else {
      $response['status'] = false;
      $response['msg'] = "Ada sesuatu yang salah! Coba lagi nanti.";
    }
  } else {
    $response['status'] = false;
    $response['msg'] = "Ada sesuatu yang salah! Coba lagi nanti.";
  }

} else {
  $response['status'] = false;
  $response['msg'] = "Email ini tidak terdaftar!";
}

$kode = $_POST['code'];

if (isset($kode)) {

  $query = $conn->db->prepare("SELECT * FROM accounts WHERE VerifyCode = '$kode'");
  $query->execute();

  if ($query->rowCount() > 0) {
    $user = $query->fetch(PDO::FETCH_ASSOC);
    $salt = $user['Salt'];

    $oldpass = strtoupper(hash("sha256", $_POST['oldpass'] . $salt));
    if ($oldpass === $user['Password']) {
      $newpass = $_POST['newpass'];
      $cnewpass = $_POST['cnewpass'];

      if ($cnewpass === $newpass) {
        $newsalt = substr(str_shuffle($data),0,64);
        $pass = strtoupper(hash("sha256", $newpass . $newsalt));
        $sql = $conn->db->prepare("UPDATE accounts SET Password = '$pass', Salt = '$newsalt' WHERE VerifyCode = '$kode'");
        if ($sql->execute()) {
          $query = $conn->db->prepare("UPDATE accounts SET VerifyCode = '' WHERE VerifyCode = '$kode'");
          if ($query->execute()) {
            $response['status'] = true;
            $response['msg'] = "Kata sandi berhasil diubah, silahkan login.";
          } else {
            $response['status'] = false;
            $response['msg'] = "Ada sesuatu yang salah! Coba lagi nanti.";
          }
        } else {
          $response['status'] = false;
          $response['msg'] = "Ada sesuatu yang salah! Coba lagi nanti.";
        }
      } else {
        $response['status'] = false;
        $response['msg'] = "Konfirmasi kata sandi tidak sesuai.";
      }
    } else {
      $response['status'] = false;
      $response['msg'] = "Kata sandi lama salah.";
    }
  } else {
    $response['status'] = false;
    $response['msg'] = "Kode verifikasi salah.";
  }
}


echo json_encode($response);