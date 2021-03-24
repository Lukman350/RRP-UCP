<?php

session_start();
include_once "../config/db.php";
$conn = new Database;

$response = [];

$ucp = $_POST['ucp'];

$query = $conn->db->prepare("SELECT * FROM accounts WHERE Username = '$ucp' OR Email = '$ucp'");
$query->execute();

if ($query->rowCount() > 0) {
  $user = $query->fetch(PDO::FETCH_ASSOC);
  $pass = strtoupper(hash("sha256", $_POST['pass'] . $user['Salt']));

  if ($pass === $user['Password']) {
    if (!$user['VerifyCode']) {
      if ($user['Admin'] > 0) {
        $_SESSION['admin'] = $user['Admin'];
      }
      $_SESSION['user'] = $user['Username'];
      $_SESSION['email'] = $user['Email'];
      $response['status'] = true;
      $response['msg'] = "Login berhasil silahkan klik tombol OK";
    } else {
      $response['status'] = false;
      $response['msg'] = "Akun ini belum di aktivasi.";
    }
  } else {
    $response['status'] = false;
    $response['msg'] = "Password yang Anda masukkan salah.";
  }
} else {
  $response['status'] = false;
  $response['msg'] = "UCP atau Email ini tidak terdaftar.";
}

echo json_encode($response);