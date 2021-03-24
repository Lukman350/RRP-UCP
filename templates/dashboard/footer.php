  <!-- JQuery -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <!-- Bootstrap Bundle -->
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- SB Admin JS -->
  <script src="../vendor/sbadmin/js/sb-admin-2.min.js"></script>
  <!-- Sweetalert2 JS -->
  <script src="../vendor/swal2/js/sweetalert2.min.js"></script>
  <!-- Custom JS -->
  <script src="../assets/js/common.js"></script>
  <script src="../assets/js/dashboard/index.js"></script>
  <?php 
    if ($script != "index" && $script != "profile") :
  ?>
  <script src="../assets/js/dashboard/<?= $script; ?>.js"></script>
  <?php endif; ?>
</body>
</html>