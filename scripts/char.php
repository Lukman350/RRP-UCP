<?php
session_start();

include_once "../config/db.php";

$response = [];

$conn = new Database;

$maleSkin = [
  1, 2, 3, 4, 5, 6, 7, 8, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29,
  30, 32, 33, 34, 35, 36, 37, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 57, 58, 59, 60,
  61, 62, 66, 68, 72, 73, 78, 79, 80, 81, 82, 83, 84, 94, 95, 96, 97, 98, 99, 100, 101, 102,
  103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120,
  121, 122, 123, 124, 125, 126, 127, 128, 132, 133, 134, 135, 136, 137, 142, 143, 144, 146,
  147, 153, 154, 155, 156, 158, 159, 160, 161, 162, 167, 168, 170, 171, 173, 174, 175, 176,
  177, 179, 180, 181, 182, 183, 184, 185, 186, 187, 188, 189, 190, 200, 202, 203, 204, 206,
  208, 209, 210, 212, 213, 217, 220, 221, 222, 223, 228, 229, 230, 234, 235, 236, 239, 240,
  241, 242, 247, 248, 249, 250, 253, 254, 255, 258, 259, 260, 261, 262, 268, 272, 273, 289,
  290, 291, 292, 293, 294, 295, 296, 297, 299
];

$femaleSkin = [
  9, 10, 11, 12, 13, 31, 38, 39, 40, 41, 53, 54, 55, 56, 63, 64, 65, 69,
  75, 76, 77, 85, 88, 89, 90, 91, 92, 93, 129, 130, 131, 138, 140, 141,
  145, 148, 150, 151, 152, 157, 169, 178, 190, 191, 192, 193, 194, 195,
  196, 197, 198, 199, 201, 205, 207, 211, 214, 215, 216, 219, 224, 225,
  226, 231, 232, 233, 237, 238, 243, 244, 245, 246, 251, 256, 257, 263,
  298
];

if (isset($_POST['fname']) && isset($_POST['lname'])) {

  // Create Character
  $fname = htmlspecialchars($_POST['fname']);
  $lname = htmlspecialchars($_POST['lname']);
  $character = $fname . "_" . $lname;
  $gender = $_POST['gender'];
  $origin = $_POST['origin'];
  $birthdate = date("d/m/Y", strtotime($_POST['birthdate']));
  $username = $_SESSION['user'];
  $createdate = time();
  $regdate = time();
  $played = "0|0|0";
  $money = 250;
  $posx = 1642.6522;
  $posy = -2331.9292;
  $posz = 13.5469;
  $angle = 359.7889;
  $created = 1;
  $score = 1;
  $health = 100;
  
  if ($conn->charGetCount($_SESSION['user']) >= 3) {
    $response['status'] = false;
    $response['msg'] = "Kamu tidak bisa membuat karakter lagi, maksimal yaitu 3 karakter.";
  } else if ($conn->checkChar($character)) {
    $response['status'] = false;
    $response['msg'] = "Nama karakter ini sudah terdaftar, silahkan cari nama lain.";
  } else {
    if (!preg_match("/^[a-zA-Z ]*$/",$fname) OR !preg_match("/^[a-zA-Z ]*$/",$lname)) {
      $response["status"] = false;
      $response["msg"] = "Hanya karakter alfabet yang diperbolehkan.";
    } else {
      if ($gender == 1) {
        $skin = $maleSkin[rand(0, 185)];
      } else {
        $skin = $femaleSkin[rand(0, 77)];
      }
      $conn->db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
      $query = $conn->db->prepare("INSERT INTO `characters` (`Created`, `Username`, `Character`, `CreateDate`, `Gender`, `Skin`, `Origin`, `BirthDate`, `pScore`, `Money`, `BankMoney`, `RegisterDate`, `PosX`, `PosY`, `PosZ`, `PosA`, `Played`, `Health`) VALUES ('$created', '$username', '$character', '$createdate', '$gender', '$skin', '$origin', '$birthdate', '$score', '$money', '$money', '$regdate', '$posx', '$posy', '$posz', '$angle', '$played', '$health')");
      if ($query->execute()) {
        $response['status'] = true;
        $response['msg'] = "Karakter berhasil dibuat.";
      } else {
        $response['status'] = false;
        $response['msg'] = "Karakter gagal dibuat.";
      }
    }
  }
}


// DELETE CHAR
$id = $_POST['delete'];

if (isset($id)) {
  $query = $conn->db->prepare("SELECT * FROM `characters` WHERE `ID` = '$id'");
  $query->execute();
  if ($query->rowCount() > 0) {
    while ($user = $query->fetch(PDO::FETCH_ASSOC)) {
      if ($user['Username'] != $_SESSION['user']) {
        $response['status'] = false;
        $response['msg'] = "Kamu tidak dapat menghapus karakter milik orang lain.";
      } else {
        $sql = $conn->db->prepare("DELETE FROM `characters` WHERE `ID` = '$id'");
        if ($sql->execute()) {
          $response['status'] = true;
          $response['msg'] = "Karakter dengan ID ".$id." berhasil dihapus.";
        } else {
          $response['status'] = false;
          $response['msg'] = "Ada sesuatu yang salah. Coba lagi nanti.";
        }
      }
    }
  } else {
    $response['status'] = false;
    $response['msg'] = "ID tidak ditemukan.";
  }
}

echo json_encode($response);