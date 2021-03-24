<?php 
session_start();

if (!isset($_SESSION['user'])) {
  header("Location: ../login");
}

include_once "../config/db.php";

$conn = new Database;

$user = $conn->fetchAccount($_SESSION['user']);

$title = "RRP:UCP - Dashboard - Profile";
$link = "dashboard/profile";
$script = "profile";



include "../templates/dashboard/header.php";
?>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include "../templates/dashboard/sidebar.php"; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-dark3 topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-white-600 small"><?= $_SESSION['user']; ?></span>
                                <img class="img-profile rounded-circle"
                                    src="../assets/img/profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a href="#" class="dropdown-item" disabled>
                                  <i class="fas fa-clock fa-sm fa-fw mr-2 text-white-400"></i>
                                  <div id="dateAndTime"></div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="./profile">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-white-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="./logout">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-white-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                  <h1 class="h3 text-white-800">My Profile</h1>
                  <hr>
                  <div class="table-responsive table-scroll">
                    <?php 
                    foreach ($user as $data) :
                    ?>
                      <table>
                        <thead>
                          <tr>
                            <th colspan="2">
                              <h5 class="text-center">Users Information</h5>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>User ID</td>
                            <td><?= $data['ID']; ?></td>
                          </tr>
                          <tr>
                            <td>Username</td>
                            <td><?= $data['Username']; ?></td>
                          </tr>
                          <tr>
                            <td>Register Date</td>
                            <td><?= date("l, d F Y h:i:s", $data['RegisterDate']); ?></td>
                          </tr>
                          <tr>
                            <td>Total Characters</td>
                            <td>
                              <?php 
                                $user = $_SESSION['user'];
                                $query = $conn->db->prepare("SELECT * FROM characters WHERE Username = '$user'");
                                $query->execute();
                              ?>
                              <b class="text-success"><?= $query->rowCount(); ?></b> / <b class="text-danger">3</b>
                            </td>
                          </tr>
                          <tr>
                            <td>Email</td>
                            <td><?= $data['Email']; ?></td>
                          </tr>
                          <tr>
                            <td>Admin</td>
                            <td><?= ($data['Admin'] > 0) ? ($data['Admin']) : ("<b class='text-danger'>NO</b>"); ?></td>
                          </tr>
                          <tr>
                            <td>Register IP</td>
                            <td><?= $data['IP']; ?></td>
                          </tr>
                          <tr>
                            <td>Last Logged IP</td>
                            <td><?= $data['LeaveIP']; ?></td>
                          </tr>
                        </tbody>
                      </table>
                    <?php endforeach; ?>
                  </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-dark3">
                <div class="container my-auto">
                    <div class="copyright text-center text-white my-auto">
                        <span>Copyright &copy; Relived Community <?= date("Y"); ?>.</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
<?php 
include "../templates/dashboard/footer.php";
?>