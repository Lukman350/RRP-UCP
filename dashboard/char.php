<?php 
session_start();

if (!isset($_SESSION['user'])) {
  header("Location: ../login");
}

include_once "../config/db.php";

$conn = new Database;

$acc = $conn->fetchAccount($_SESSION['user']);

$title = "RRP:UCP - Dashboard - Char";
$link = "dashboard/char";
$script = "char";

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
                  <h1 class="h3 text-white-800">My Characters</h1>
                  <hr>
                  <div class="table-responsive table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Level</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $username = $_SESSION['user'];
                            $query = $conn->db->prepare("SELECT * FROM characters WHERE Username = '$username'");
                            $query->execute();
                            if ($query->rowCount() == 0) : ?>
                            <tr>
                                <td colspan="4">
                                    <div class="text-center text-danger">Kamu tidak mempunyai karakter sama sekali.</div>
                                </td>
                            </tr>
                            <?php else: 
                                $query = $conn->db->prepare("SELECT * FROM `characters` WHERE `Username` = '$username'");
                                $query->execute();
                                while ($user = $query->fetch(PDO::FETCH_ASSOC)) :?>
                            <tr>
                                <td><?= $user['ID']; ?></td>
                                <td><?= $user['Character']; ?></td>
                                <td><?= $user['pScore']; ?></td>
                                <td>
                                    <a href="#" id="delete-char" class="btn btn-danger" data-user="<?= $user['ID']; ?>">Delete</a>
                                </td>
                            </tr>
                            <?php endwhile;
                            endif;?>
                        </tbody>
                        <tfoot>
                            <?php foreach ($acc as $account) :
                                if ($account['WhiteList'] == 0) :
                            ?>
                            <tr>
                                <td colspan="4">
                                    <div class="text-center text-danger">Akun kamu belum masuk dalam White List silahkan request White List di Discord</div>
                                </td>
                            </tr>
                            <?php else: ?>
                            <tr>
                                <td colspan="4">
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createChar" <?= ($query->rowCount() >= 3) ? ("disabled") : (""); ?>>Create Character</button>
                                </td>
                            </tr>
                            <?php endif;
                            endforeach; ?>
                        </tfoot>
                    </table>
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

    <!-- Modal Create Char -->
    <div class="modal fade" id="createChar" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="createCharLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCharLabel">RRP:UCP - Create Character</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="user needs-validation" id="form-createchar" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="fname">Firstname</label>
                            <input type="text" name="fname" id="fname" class="form-control" placeholder="Masukkan nama depan..." required>
                        </div>
                        <div class="form-group">
                            <label for="lname">Lastname</label>
                            <input type="text" name="lname" id="lname" class="form-control" placeholder="Masukkan nama belakang..." required>
                        </div>
                        <div class="form-group">
                            <label for="birthdate">Birthdate</label>
                            <input type="date" name="birthdate" id="birthdate" class="form-control" placeholder="Masukkan tanggal lahir..." required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender" class="form-control" required>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="origin">Origin</label>
                            <select name="origin" id="origin" class="form-control" required>
                                <option></option>
                                <option value='United States of America'>United States of America</option><option value='United Kingdom'>United Kingdom</option><option value='Indonesia'>Indonesia</option><option value='Afganistan'>Afganistan</option><option value='Albania'>Albania</option><option value='Algeria'>Algeria</option><option value='American Samoa'>American Samoa</option><option value='Andorra'>Andorra</option><option value='Angola'>Angola</option><option value='Anguilla'>Anguilla</option><option value='Antigua & Barbuda'>Antigua &amp; Barbuda</option><option value='Argentina'>Argentina</option><option value='Armenia'>Armenia</option><option value='Aruba'>Aruba</option><option value='Australia'>Australia</option><option value='Austria'>Austria</option><option value='Azerbaijan'>Azerbaijan</option><option value='Bahamas'>Bahamas</option><option value='Bahrain'>Bahrain</option><option value='Bangladesh'>Bangladesh</option><option value='Barbados'>Barbados</option><option value='Belarus'>Belarus</option><option value='Belgium'>Belgium</option><option value='Belize'>Belize</option><option value='Benin'>Benin</option><option value='Bermuda'>Bermuda</option><option value='Bhutan'>Bhutan</option><option value='Bolivia'>Bolivia</option><option value='Bonaire'>Bonaire</option><option value='Bosnia & Herzegovina'>Bosnia &amp; Herzegovina</option><option value='Botswana'>Botswana</option><option value='Brazil'>Brazil</option><option value='British Indian Ocean Ter'>British Indian Ocean Ter</option><option value='Brunei'>Brunei</option><option value='Bulgaria'>Bulgaria</option><option value='Burkina Faso'>Burkina Faso</option><option value='Burundi'>Burundi</option><option value='Cambodia'>Cambodia</option><option value='Cameroon'>Cameroon</option><option value='Canada'>Canada</option><option value='Canary Islands'>Canary Islands</option><option value='Cape Verde'>Cape Verde</option><option value='Cayman Islands'>Cayman Islands</option><option value='Central African Republic'>Central African Republic</option><option value='Chad'>Chad</option><option value='Channel Islands'>Channel Islands</option><option value='Chile'>Chile</option><option value='China'>China</option><option value='Christmas Island'>Christmas Island</option><option value='Cocos Island'>Cocos Island</option><option value='Colombia'>Colombia</option><option value='Comoros'>Comoros</option><option value='Congo'>Congo</option><option value='Cook Islands'>Cook Islands</option><option value='Costa Rica'>Costa Rica</option><option value='Cote DIvoire'>Cote DIvoire</option><option value='Croatia'>Croatia</option><option value='Cuba'>Cuba</option><option value='Curaco'>Curaco</option><option value='Cyprus'>Cyprus</option><option value='Czech Republic'>Czech Republic</option><option value='Denmark'>Denmark</option><option value='Djibouti'>Djibouti</option><option value='Dominica'>Dominica</option><option value='Dominican Republic'>Dominican Republic</option><option value='East Timor'>East Timor</option><option value='Ecuador'>Ecuador</option><option value='Egypt'>Egypt</option><option value='El Salvador'>El Salvador</option><option value='Equatorial Guinea'>Equatorial Guinea</option><option value='Eritrea'>Eritrea</option><option value='Estonia'>Estonia</option><option value='Ethiopia'>Ethiopia</option><option value='Falkland Islands'>Falkland Islands</option><option value='Faroe Islands'>Faroe Islands</option><option value='Fiji'>Fiji</option><option value='Finland'>Finland</option><option value='France'>France</option><option value='French Guiana'>French Guiana</option><option value='French Polynesia'>French Polynesia</option><option value='French Southern Ter'>French Southern Ter</option><option value='Gabon'>Gabon</option><option value='Gambia'>Gambia</option><option value='Georgia'>Georgia</option><option value='Germany'>Germany</option><option value='Ghana'>Ghana</option><option value='Gibraltar'>Gibraltar</option><option value='Great Britain'>Great Britain</option><option value='Greece'>Greece</option><option value='Greenland'>Greenland</option><option value='Grenada'>Grenada</option><option value='Guadeloupe'>Guadeloupe</option><option value='Guam'>Guam</option><option value='Guatemala'>Guatemala</option><option value='Guinea'>Guinea</option><option value='Guyana'>Guyana</option><option value='Haiti'>Haiti</option><option value='Hawaii'>Hawaii</option><option value='Honduras'>Honduras</option><option value='Hong Kong'>Hong Kong</option><option value='Hungary'>Hungary</option><option value='Iceland'>Iceland</option><option value='India'>India</option><option value='Iran'>Iran</option><option value='Iraq'>Iraq</option><option value='Ireland'>Ireland</option><option value='Isle of Man'>Isle of Man</option><option value='Italy'>Italy</option><option value='Jamaica'>Jamaica</option><option value='Japan'>Japan</option><option value='Jordan'>Jordan</option><option value='Kazakhstan'>Kazakhstan</option><option value='Kenya'>Kenya</option><option value='Kiribati'>Kiribati</option><option value='Korea North'>Korea North</option><option value='Korea Sout'>Korea Sout</option><option value='Kuwait'>Kuwait</option><option value='Kyrgyzstan'>Kyrgyzstan</option><option value='Laos'>Laos</option><option value='Latvia'>Latvia</option><option value='Lebanon'>Lebanon</option><option value='Lesotho'>Lesotho</option><option value='Liberia'>Liberia</option><option value='Libya'>Libya</option><option value='Liechtenstein'>Liechtenstein</option><option value='Lithuania'>Lithuania</option><option value='Luxembourg'>Luxembourg</option><option value='Macau'>Macau</option><option value='Macedonia'>Macedonia</option><option value='Madagascar'>Madagascar</option><option value='Malaysia'>Malaysia</option><option value='Malawi'>Malawi</option><option value='Maldives'>Maldives</option><option value='Mali'>Mali</option><option value='Malta'>Malta</option><option value='Marshall Islands'>Marshall Islands</option><option value='Martinique'>Martinique</option><option value='Mauritania'>Mauritania</option><option value='Mauritius'>Mauritius</option><option value='Mayotte'>Mayotte</option><option value='Mexico'>Mexico</option><option value='Midway Islands'>Midway Islands</option><option value='Moldova'>Moldova</option><option value='Monaco'>Monaco</option><option value='Mongolia'>Mongolia</option><option value='Montserrat'>Montserrat</option><option value='Morocco'>Morocco</option><option value='Mozambique'>Mozambique</option><option value='Myanmar'>Myanmar</option><option value='Nambia'>Nambia</option><option value='Nauru'>Nauru</option><option value='Nepal'>Nepal</option><option value='Netherland Antilles'>Netherland Antilles</option><option value='Netherlands'>Netherlands</option><option value='Nevis'>Nevis</option><option value='New Caledonia'>New Caledonia</option><option value='New Zealand'>New Zealand</option><option value='Nicaragua'>Nicaragua</option><option value='Niger'>Niger</option><option value='Nigeria'>Nigeria</option><option value='Niue'>Niue</option><option value='Norfolk Island'>Norfolk Island</option><option value='Norway'>Norway</option><option value='Oman'>Oman</option><option value='Pakistan'>Pakistan</option><option value='Palau Island'>Palau Island</option><option value='Palestine'>Palestine</option><option value='Panama'>Panama</option><option value='Papua New Guinea'>Papua New Guinea</option><option value='Paraguay'>Paraguay</option><option value='Peru'>Peru</option><option value='Phillipines'>Phillipines</option><option value='Pitcairn Island'>Pitcairn Island</option><option value='Poland'>Poland</option><option value='Portugal'>Portugal</option><option value='Puerto Rico'>Puerto Rico</option><option value='Qatar'>Qatar</option><option value='Republic of Montenegro'>Republic of Montenegro</option><option value='Republic of Serbia'>Republic of Serbia</option><option value='Reunion'>Reunion</option><option value='Romania'>Romania</option><option value='Russia'>Russia</option><option value='Rwanda'>Rwanda</option><option value='St Barthelemy'>St Barthelemy</option><option value='St Eustatius'>St Eustatius</option><option value='St Helena'>St Helena</option><option value='St Kitts-Nevis'>St Kitts-Nevis</option><option value='St Lucia'>St Lucia</option><option value='St Maarten'>St Maarten</option><option value='St Pierre & Miquelon'>St Pierre &amp; Miquelon</option><option value='St Vincent & Grenadines'>St Vincent &amp; Grenadines</option><option value='Saipan'>Saipan</option><option value='Samoa'>Samoa</option><option value='Samoa American'>Samoa American</option><option value='San Marino'>San Marino</option><option value='Sao Tome & Principe'>Sao Tome &amp; Principe</option><option value='Saudi Arabia'>Saudi Arabia</option><option value='Senegal'>Senegal</option><option value='Serbia'>Serbia</option><option value='Seychelles'>Seychelles</option><option value='Sierra Leone'>Sierra Leone</option><option value='Singapore'>Singapore</option><option value='Slovakia'>Slovakia</option><option value='Slovenia'>Slovenia</option><option value='Solomon Islands'>Solomon Islands</option><option value='Somalia'>Somalia</option><option value='South Africa'>South Africa</option><option value='Spain'>Spain</option><option value='Sri Lanka'>Sri Lanka</option><option value='Sudan'>Sudan</option><option value='Suriname'>Suriname</option><option value='Swaziland'>Swaziland</option><option value='Sweden'>Sweden</option><option value='Switzerland'>Switzerland</option><option value='Syria'>Syria</option><option value='Tahiti'>Tahiti</option><option value='Taiwan'>Taiwan</option><option value='Tajikistan'>Tajikistan</option><option value='Tanzania'>Tanzania</option><option value='Thailand'>Thailand</option><option value='Togo'>Togo</option><option value='Tokelau'>Tokelau</option><option value='Tonga'>Tonga</option><option value='Trinidad & Tobago'>Trinidad &amp; Tobago</option><option value='Tunisia'>Tunisia</option><option value='Turkey'>Turkey</option><option value='Turkmenistan'>Turkmenistan</option><option value='Turks & Caicos Is'>Turks &amp; Caicos Is</option><option value='Tuvalu'>Tuvalu</option><option value='Uganda'>Uganda</option><option value='Ukraine'>Ukraine</option><option value='United Arab Erimates'>United Arab Erimates</option><option value='Uraguay'>Uraguay</option><option value='Uzbekistan'>Uzbekistan</option><option value='Vanuatu'>Vanuatu</option><option value='Vatican City State'>Vatican City State</option><option value='Venezuela'>Venezuela</option><option value='Vietnam'>Vietnam</option><option value='Virgin Islands (Brit)'>Virgin Islands (Brit)</option><option value='Virgin Islands (USA)'>Virgin Islands (USA)</option><option value='Wake Island'>Wake Island</option><option value='Wallis & Futana Is'>Wallis &amp; Futana Is</option><option value='Yemen'>Yemen</option><option value='Zaire'>Zaire</option><option value='Zambia'>Zambia</option><option value='Zimbabwe'>Zimbabwe</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End of Modal Create Char -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
<?php 
include "../templates/dashboard/footer.php";
?>