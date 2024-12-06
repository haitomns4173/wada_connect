<?php
session_start();
if (!isset($_SESSION['userLoginStatus']) || $_SESSION['userLoginStatus'] !== true || $_SESSION['wadaMemberUserType'] != 3) {
  header('Location: ../login.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>WadaConnect</title>

  <link rel="shortcut icon" href="../assets/compiled/jpg/shortcut.png" type="image/png" />

  <link rel="stylesheet" crossorigin href="../assets/compiled/css/app.css" />
  <link rel="stylesheet" crossorigin href="../assets/compiled/css/app-dark.css" />
  <link rel="stylesheet" crossorigin href="../assets/compiled/css/iconly.css" />

  <link rel="stylesheet" href="../assets/extensions/toastify-js/src/toastify.css">

</head>

<body>
  <script src="../assets/static/js/initTheme.js"></script>
  <div id="app">
    <div id="sidebar">
      <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
          <div class="d-flex justify-content-between align-items-center">
            <div class="logo">
              <a href="index.php"><img src="../assets/compiled/jpg/logo.png" alt="Logo" srcset="" /></a>
            </div>
            <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2" opacity=".3"></path>
                  <g transform="translate(-210 -1)">
                    <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                    <circle cx="220.5" cy="11.5" r="4"></circle>
                    <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                  </g>
                </g>
              </svg>
              <div class="form-check form-switch fs-6">
                <input class="form-check-input me-0" type="checkbox" id="toggle-dark" style="cursor: pointer" />
                <label class="form-check-label"></label>
              </div>
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                <path fill="currentColor" d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z"></path>
              </svg>
            </div>
            <div class="sidebar-toggler x">
              <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
            </div>
          </div>
        </div>
        <div class="sidebar-menu">
          <ul class="menu">
            <li class="sidebar-title">Menu</li>
            <li class="sidebar-item">
              <a href="application_apply.php" class="sidebar-link">
                <i class="bi bi-file-arrow-up-fill"></i>
                <span>Application Apply</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a href="application_submit.php" class="sidebar-link">
                <i class="bi bi-file-earmark-text-fill"></i>
                <span>Application Submit</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a href="applicant_profile.php" class="sidebar-link">
                <i class="bi bi-person-lines-fill"></i>
                <span>Applicant Profile</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a href="applicant_account.php" class="sidebar-link">
                <i class="bi bi-person-circle"></i>
                <span>Applicant Account</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <?php
    require_once '../php/wada_member_header_handler.php';
    ?>
    <div id="main" class='layout-navbar navbar-fixed'>
      <header>
        <nav class="navbar navbar-expand navbar-light navbar-top">
          <div class="container-fluid">
            <a href="#" class="burger-btn d-block">
              <i class="bi bi-justify fs-3"></i>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
              aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ms-auto mb-lg-0">
                <li class="nav-item dropdown me-3">
                  <a class="nav-link active dropdown-toggle text-gray-600" href="#" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                    <i class='bi bi-calendar-event bi-sub fs-4'></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="dropdownMenuButton">
                    <li>
                      <h6 class="dropdown-header">Date</h6>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#" onclick="copyToClipboard('<?php echo date('Y/m/d', strtotime($wadaADTodayDate)); ?>')">
                        AD: <?php echo $formattedADDate; ?>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#" onclick="copyToClipboard('<?php echo $nepaliDate; ?>')">
                        BS: <?php echo $nepaliDate; ?>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
              <div class="dropdown">
                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                  <div class="user-menu d-flex">
                    <div class="user-name text-end me-3">
                      <h6 class="mb-0 text-gray-600"><?php echo $wadaMemberFirstName . " " . $wadaMemberMiddleName . " " . $wadaMemberLastName ?></h6>
                      <p class="mb-0 text-sm text-gray-600">Wada Member</p>
                    </div>
                    <div class="user-img d-flex align-items-center">
                      <div class="avatar avatar-md">
                        <img src="<?php echo $wadaMemberImage ?>" alt="avatar" class="rounded-circle">
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </nav>
      </header>
      <div id="main-content">
        <div class="page-heading">
          <div class="page-title">
            <div class="row">
              <div class="col-6 col-md-6 order-md-1 order-last">
                <h3>Home</h3>
                <p class="text-subtitle text-muted">Get your require documents approved online.</p>
              </div>
            </div>
          </div>

          <?php
          require_once '../php/index_fetch.php';
          ?>

          <section class="section">
            <div class="row">
              <div class="col-12 col-md-8 offset-md-2">
                <div class="pricing">
                  <div class="row align-items-center">
                    <div class="col-md-4 px-0">
                      <div class="card">
                        <div class="card-header text-center">
                          <h4 class="card-title">User Information</h4>
                        </div>
                        <h5 class="text-center">Welcome, @<?php echo $_SESSION['wadaMemberUsername']; ?></h5>
                        <div class="card-footer">
                          <a href="applicant_account.php">
                            <button class="btn btn-primary btn-block">Applicant Account</button>
                          </a>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-4 px-0  position-relative z-1">
                      <div class="card card-highlighted shadow-lg">
                        <div class="card-header text-center">
                          <h4 class="card-title">WadaConnect</h4>
                        </div>

                        <div class="d-flex justify-content-center align-items-center flex-column">
                          <p class="text-center text-white">Get Documents Online.</p>
                          <div class="avatar avatar-2xl">
                            <img src="../assets/compiled/jpg/wada_connnect_logo_circle.jpg" alt="Avatar">
                          </div>
                          <h3 class="mt-3"></h3>
                          <?php
                          if ($_SESSION['wadaMemberID'] == 0) {
                            echo "<p class='text-center text-white'>Complete your profile,</p>";
                          } else {
                            echo "<p class='text-center text-white'>Get started with Applications,</p>";
                          }
                          ?>
                        </div>
                        <div class="card-footer">
                          <?php
                          if ($_SESSION['wadaMemberID'] == 0) {
                            echo "<a href='applicant_profile.php'>";
                            echo "<button class='btn btn-outline-white btn-block'>Application Profile</button>";
                            echo "</a>";
                          } else {
                            echo "<a href='application_apply.php'>";
                            echo "<button class='btn btn-outline-white btn-block'>Application Apply</button>";
                            echo "</a>";
                          }
                          ?>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-4 px-0">
                      <div class="card">
                        <div class="card-header text-center">
                          <h4 class="card-title">Application Submitted</h4>
                        </div>
                        <h5 class="text-center"><?php echo $wadaConnectApplicationListingID; ?></h5>
                        <div class="card-footer">
                          <a href="application_submit.php">
                            <button class="btn btn-primary btn-block">Application Submit</button>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <br>
          <br>
          <br>

          <div class="page-title">
            <div class="row">
              <div class="col-6 col-md-6 order-md-1 order-last">
                <h3>Tools</h3>
                <p class="text-subtitle text-muted">Get thing done easily here.</p>
              </div>
            </div>
          </div>

          <section class="section">
            <div class="row">
              <div class="col-6">
                <div class="card">
                  <div class="card-header">
                    <h5 class="card-title">BS</h5>
                  </div>
                  <div class="card-body">
                    <div class="form-group my-2">
                      <label for="toolsBSYear" class="form-label">Year</label>
                      <input type="text" name="toolsBSYear" id="toolsBSYear" class="form-control" placeholder="Year">
                    </div>
                    <div class="form-group my-2">
                      <label for="toolsBSMonth" class="form-label">Month</label>
                      <input type="text" name="toolsBSMonth" id="toolsBSMonth" class="form-control" placeholder="Month">
                    </div>
                    <div class="form-group my-2">
                      <label for="toolsBSDay" class="form-label">Day</label>
                      <input type="text" name="toolsBSDay" id="toolsBSDay" class="form-control" placeholder="Day">
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-6">
                <div class="card">
                  <div class="card-header">
                    <h5 class="card-title">AD</h5>
                  </div>
                  <div class="card-body">
                    <div class="form-group my-2">
                      <label for="toolsADYear" class="form-label">Year</label>
                      <input type="text" name="toolsADYear" id="toolsADYear" class="form-control" placeholder="Year">
                    </div>
                    <div class="form-group my-2">
                      <label for="toolsADMonth" class="form-label">Month</label>
                      <input type="text" name="toolsADMonth" id="toolsADMonth" class="form-control" placeholder="Month">
                    </div>
                    <div class="form-group my-2">
                      <label for="toolsADDay" class="form-label">Day</label>
                      <input type="text" name="toolsADDay" id="toolsADDay" class="form-control" placeholder="Day">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>

        </div>
      </div>

      <footer>
        <div class="footer clearfix mb-0 text-muted">
          <div class="float-start">
            <p>
              <script>
                document.write(new Date().getFullYear())
              </script> &copy; Wada Connnect
            </p>
          </div>
          <div class="float-end">
            <p>
              Programmed with
              <span class="text-danger"><i class="bi bi-heart"></i></span> by
              <a href="#">Inbox Coders/a>
            </p>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <script src="../assets/static/js/components/dark.js"></script>
  <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>

  <script src="../assets/compiled/js/app.js"></script>

  <script src="../assets/extensions/jquery/jquery.min.js"></script>
  <script src="../assets/extensions/parsleyjs/parsley.min.js"></script>
  <script src="../assets/static/js/pages/parsley.js"></script>

  <script src="../assets/extensions/nepali-date-converter/nepali-data-converter.js"></script>
  <script src="../assets/compiled/js/dataConversion.js"></script>

  <script src="../assets/extensions/toastify-js/src/toastify.js"></script>
  <script src="../assets/static/js/pages/toastify.js"></script>

  <script>
    function copyToClipboard(text, dateType) {
        navigator.clipboard.writeText(text).then(() => {
            Toastify({
                text: "Date Copied: " + text,
                duration: 2000, 
                gravity: "top",
                position: "center",
                style: {
                    background: "linear-gradient(to right, #435ebe, #41bbdd)", // Custom styling
                }
            }).showToast();
        }).catch(err => {
            Toastify({
                text: "Failed to copy the Date.",
                duration: 2000, 
                gravity: "top",
                position: "center",
                style: {
                    background: "linear-gradient(to right, #435ebe, #41bbdd)", // Custom styling
                }
            }).showToast();
        });
    }
</script>
</body>

</html>

<!--
    ToDo:
      1. Make the address being fetched from the js file Capatilized and also make the address consistent.
      2. Check for the usage of capital letter in front of address and make that full proof.
      2. Cropping Facility for Images
      3. Update Facility for Applicant Profile
      4. Add the feature to select the address in each from.
      5. Make the feature to add muntiple records in form.
      6. Email Verification
      7. IP Address Tracking
      8. Cookies to store session
      9. Password Reset
-->