<?php 
session_start();

if (isset($_SESSION['user'])) {
  header("Location: ./dashboard/");
} else {
  header("Location: ./login");
}