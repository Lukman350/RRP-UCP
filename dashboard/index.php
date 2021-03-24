<?php 
session_start();
include_once "../config/db.php";

$conn = new Database;

$server = $conn->getCURL("https://samp-api.tk/server/13.251.156.119:7777");

if (!isset($_SESSION['user'])) {
  header("Location: ../login");
}

$title = "RRP:UCP - Dashboard";
$link = "dashboard";
$script = "index";

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
                                <a href="#" class="dropdown-item" aria-disabled="true">
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
                  <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <!-- Page Heading -->
                      <h1 class="h4 text-white-800">Status: <?= ($server['online'] === true) ? ("<b style='color: green'>ON</b>") : ("<b style='color: red'>OFF</b>"); ?></h1>
                      <h1 class="h4 mb-4 text-white-800">Online Players: <b><?= $server['players']; ?></b></h1>
                      <hr>
                      <div class="table-responsive table-scroll">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Player</th>
                                        <th>Level</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($server['online'] === true) : ?>
                                    <?php foreach ($server['list'] as $user) : ?>
                                    <tr><td><?= $user['playerid']; ?></td><td><?= $user['nickname']; ?></td><td><?= $user['score']; ?></td></tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="3"><b class="text-danger">Server is offline</b></td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <!-- Page Heading -->
                        <?php 
                        $username = $_SESSION['user'];
                        $query = $conn->db->prepare("SELECT * FROM characters WHERE Username = '$username' LIMIT 1");
                        $query->execute();
                        $user = $query->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <h1 class="h4 mb-4 text-white-800">Main Character: <b><?= $user['Character']; ?></b></h1>
                        <hr>
                        <?php if ($query->rowCount() > 0) : ?>
                            <div class="table-responsive table-scroll">
                                <table>
                                    <thead>
                                        <tr>
                                            <th colspan="2">
                                                <div class="text-center">IC Information</div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Photo</td>
                                            <td><img src="../skins/Skin_<?= $user['Skin']; ?>.png" alt=""></td>
                                        </tr>
                                        <tr>
                                            <td>Gender</td>
                                            <td><?= ($user['Gender'] == 1) ? ("Male") : ("Female"); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Birthdate</td>
                                            <td><?= $user['Birthdate']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Origin</td>
                                            <td><?= $user['Origin']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Money</td>
                                            <td>$<?= number_format($user['Money']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Bank Money</td>
                                            <td>$<?= number_format($user['BankMoney']); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="text-center font-weight-bold">OOC Information</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Level</td>
                                            <td><?= ($user['pScore'] == 0) ? ("1") : ($user['pScore']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Online Time</td>
                                            <td><?php
                                                $second = 0;
                                                $minute = 0;
                                                $hour = 0;
                                                sscanf($user['Played'], "%d|%d|%d", $second, $minute, $hour);
                                            ?><?= $hour; ?> hours, <?= $minute; ?> minutes, <?= $second; ?> seconds</td>
                                        </tr>
                                        <tr>
                                            <td>Register Date</td>
                                            <td><?= date("l, d F Y h:i:s", $user['RegisterDate']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Last Login</td>
                                            <td><?= ($user['LastLogin'] == 0) ? ("Anda belum pernah ingame.") : (date("l, d F Y h:i:s", $user['LoginDate'])); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Warnings</td>
                                            <td><?= $user['Warnings']; ?> / 20</td>
                                        </tr>
                                        <tr>
                                            <td>Health</td>
                                            <td>
                                            <div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuenow="<?= $user['Health']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $user['Health']; ?>%"><?= $user['Health']; ?></div></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Armor</td>
                                            <td>
                                            <div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" aria-valuenow="<?= $user['ArmorStatus']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $user['ArmorStatus']; ?>%"><?= $user['ArmorStatus']; ?></div></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                                <div class='text-center'>
                                    <b class='text-danger'>Kamu belum mempunyai karakter sama sekali.</b>
                                </div>
                        <?php endif; ?>
                    </div>
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