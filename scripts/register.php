<?php

include_once "../config/db.php";
include_once "../config/email.php";

$conn = new Database;

$response = [];

if (isset($_POST['ucp']) && isset($_POST['email'])) {
  $ucp = htmlspecialchars($_POST['ucp']);
  $email = htmlspecialchars($_POST['email']);
  $data = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz1234567890!@#$%^&*()_+-=][}{|?/.><,~`";
  $salt = substr(str_shuffle($data),0,64);
  $pass = strtoupper(hash("sha256", $_POST['pass'] . $salt));
  $cpass = strtoupper(hash("sha256", $_POST['cpass'] . $salt));
  $token = base64_encode(random_bytes(32));
  $regdate = time();
  $ip = $conn->getUserIP();

  if ($conn->checkAccount($ucp)) {
    $response['status'] = false;
    $response['msg'] = "Nama UCP ini telah terdaftar, silahkan cari nama yang lain.";
  } else if ($conn->checkEmail($email)) {
    $response['status'] = false;
    $response['msg'] = "Email ini telah terdaftar, silahkan gunakan email yang lain.";
  } else {
    if ($pass === $cpass) {
      $subject = "R:RP Registration";
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
                  <p>Untuk: <b>".$ucp."</b></p><br>
                  <p>Terimakasih telah mendaftar untuk aktivasi akun Anda silahkan klik link dibawah ini:</p><br>
                  <a href='http://localhost/RRP-UCP/register?t=".urlencode($token)."'>
                    http://localhost/RRP-UCP/register?t=".urlencode($token)."
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
      if (SendEmail($email, $ucp, $subject, $msg)) {
        $query = $conn->db->prepare("INSERT INTO `accounts` (`Username`, `Password`, `Salt`, `Email`, `IP`, `RegisterDate`, `VerifyCode`) VALUES ('$ucp', '$pass', '$salt', '$email', '$ip', '$regdate', '$token')");
        if ($query->execute()) {
          $response['status'] = true;
          $response['msg'] = "UCP berhasil didaftarkan, silahkan cek email Anda untuk aktivasi akun.";
        } else {
          $response['status'] = false;
          $response['msg'] = "Ada sesuatu yang salah. Coba lagi nanti.";
        }
      } else {
        $response['status'] = false;
        $response['msg'] = "Email untuk aktivasi akun tidak terkirim. Coba lagi nanti.";
      }
    } else {
      $response['status'] = false;
      $response['msg'] = "Konfirmasi password tidak sesuai";
    }
  }
}

if (isset($_POST['t'])) {
  $token = $_POST['t'];

  $query = $conn->db->prepare("SELECT * FROM accounts WHERE VerifyCode = '$token'");
  $query->execute();
  if ($query->rowCount() > 0) {
    $sql = $conn->db->prepare("UPDATE accounts SET VerifyCode = '' WHERE VerifyCode = '$token'");
    if ($sql->execute()) {
      $response['status'] = true;
      $response['msg'] = "Akun Anda berhasil diaktifkan.";
    } else {
      $response['status'] = false;
      $response['msg'] = "Ada sesuatu yang salah. Coba lagi nanti.";
    }
  } else {
    $response['status'] = false;
    $response['msg'] = "Token salah";
  }
}

echo json_encode($response);