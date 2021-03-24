<?php

session_start();

if (isset($_SESSION['user']) && isset($_SESSION['email'])) {
  unset($_SESSION['user']);
  unset($_SESSION['email']);

  if (isset($_SESSION['admin'])) {
    unset($_SESSION['admin']);
  }

  session_destroy();

  header("Location: ../login");
}