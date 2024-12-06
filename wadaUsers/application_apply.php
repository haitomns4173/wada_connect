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
  <title>Application Apply - Wada Connect</title>

  <link rel="shortcut icon" href="../assets/compiled/jpg/shortcut.png" type="image/png"/>
  
  <link rel="stylesheet" crossorigin href="../assets/compiled/css/app.css" />
  <link rel="stylesheet" crossorigin href="../assets/compiled/css/app-dark.css" />
  <link rel="stylesheet" crossorigin href="../assets/compiled/css/iconly.css" />
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
            <li class="sidebar-item active">
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
    <div id="main">
      <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
          <i class="bi bi-justify fs-3"></i>
        </a>
      </header>

      <div class="page-heading">
        <div class="page-title">
          <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
              <h3>Application Apply</h3>
              <p class="text-subtitle text-muted">
                Submit your new application with ease.
              </p>
            </div>
          </div>
        </div>

        <section id="content-types">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="email-fixed-search flex-grow-1">
                  <div class="form-group position-relative  mb-0 has-icon-left">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search Application">
                    <div class="form-control-icon">
                      <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                        <use xlink:href="../assets/static/images/bootstrap-icons.svg#search" />
                      </svg>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-3 application-card" data-application-name="Four Boundaries Certificate">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-center align-items-center flex-column">
                    <div class="avatar avatar-2xl">
                      <img src="../assets/compiled/jpg/four_boundries.jpg" alt="Avatar">
                    </div>
                    <h4 class="mt-3" style="text-align: center;">Four <br> Boundaries Certificate</h4>
                    <div class="comment-time">चार किल्ला प्रमाणित</div>
                    <div class="comment-actions">
                      <button type="button" class="btn icon icon-left btn-primary me-2 text-nowrap" data-bs-toggle="modal" data-bs-target="#four-boundaries-certificate">
                        <i class="bi bi-eye-fill"></i> View
                      </button>
                      <div class="modal fade text-left" id="four-boundaries-certificate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                          <div class="modal-content">
                            <div class="modal-header bg-primary">
                              <h5 class="modal-title white" id="myModalLabel160">Four Boundaries Certificate
                              </h5>
                              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                              </button>
                            </div>
                            <div class="modal-body">
                              <h5> Documents Needed : </h5>
                              <ol>
                                <li>Citizenship Document</li>
                                <li>Land Ownership Document</li>
                                <li>Land Map</li>
                                <li>Land Tax Receipt</li>
                              </ol>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <a href="wadaUsersApplication/four_boundaries_certificate.php">
                        <button class="btn icon icon-left btn-success me-2 text-nowrap"><i class="bi bi-pencil-square"></i> Apply</button>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-3 application-card" data-application-name="Electrical Connection Recommendation">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-center align-items-center flex-column">
                    <div class="avatar avatar-2xl">
                      <img src="../assets/compiled/jpg/electric_connection.jpg" alt="Avatar">
                    </div>
                    <h4 class="mt-3" style="text-align: center;">Electrical Connection Recommendation</h4>
                    <div class="comment-time">विधुत जडान सिफारिस</div>
                    <div class="comment-actions">
                      <button type="button" class="btn icon icon-left btn-primary me-2 text-nowrap" data-bs-toggle="modal" data-bs-target="#electricity-recommendation-connection">
                        <i class="bi bi-eye-fill"></i> View
                      </button>
                      <div class="modal fade text-left" id="electricity-recommendation-connection" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                          <div class="modal-content">
                            <div class="modal-header bg-primary">
                              <h5 class="modal-title white" id="myModalLabel160">Electricity Connection Recommendation
                              </h5>
                              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                              </button>
                            </div>
                            <div class="modal-body">
                              <h5> Documents Needed : </h5>
                              <ol>
                                <li>Citizenship Document</li>
                                <li>Land Ownership Document</li>
                                <li>Land Map</li>
                                <li>Land Tax Receipt</li>
                              </ol>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <a href="wadaUsersApplication/electricity_connection_recommendation.php">
                        <button class="btn icon icon-left btn-success me-2 text-nowrap"><i class="bi bi-pencil-square"></i> Apply</button>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-3 application-card" data-application-name="Relation Verification Application">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-center align-items-center flex-column">
                    <div class="avatar avatar-2xl">
                      <img src="../assets/compiled/jpg/relationship_certification.jpg" alt="Avatar">
                    </div>
                    <h4 class="mt-3" style="text-align: center;">Relation <br> Verification Application</h4>
                    <div class="comment-time">नाता प्रमाणित आवेदन</div>
                    <div class="comment-actions">
                      <button type="button" class="btn icon icon-left btn-primary me-2 text-nowrap" data-bs-toggle="modal" data-bs-target="#relation-certificate">
                        <i class="bi bi-eye-fill"></i> View
                      </button>
                      <div class="modal fade text-left" id="relation-certificate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                          <div class="modal-content">
                            <div class="modal-header bg-primary">
                              <h5 class="modal-title white" id="myModalLabel160">Relation Verification
                              </h5>
                              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                              </button>
                            </div>
                            <div class="modal-body">
                              <h5> Documents Needed : </h5>
                              <ol>
                                <li>Citizenship Document</li>
                              </ol>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <a href="wadaUsersApplication/relation_certificate_verification.php">
                        <button class="btn icon icon-left btn-success me-2 text-nowrap"><i class="bi bi-pencil-square"></i> Apply</button>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-3 application-card" data-application-name="House Road Verification Application">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-center align-items-center flex-column">
                    <div class="avatar avatar-2xl">
                      <img src="../assets/compiled/jpg/house_road.jpg" alt="Avatar">
                    </div>
                    <h4 class="mt-3" style="text-align: center;">House/Road Verification Application</h4>
                    <div class="comment-time">घर बाटो प्रमाणित आवेदन</div>
                    <div class="comment-actions">
                      <button type="button" class="btn icon icon-left btn-primary me-2 text-nowrap" data-bs-toggle="modal" data-bs-target="#house-road-verification">
                        <i class="bi bi-eye-fill"></i> View
                      </button>
                      <div class="modal fade text-left" id="house-road-verification" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                          <div class="modal-content">
                            <div class="modal-header bg-primary">
                              <h5 class="modal-title white" id="myModalLabel160">House/Road Verification
                              </h5>
                              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                              </button>
                            </div>
                            <div class="modal-body">
                              <h5> Documents Needed : </h5>
                              <ol>
                                <li>Citizenship Document</li>
                                <li>Land Ownership Document</li>
                                <li>Land Map</li>
                                <li>Land Tax Receipt</li>
                              </ol>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <a href="wadaUsersApplication/house_road_verification.php">
                        <button class="btn icon icon-left btn-success me-2 text-nowrap"><i class="bi bi-pencil-square"></i> Apply</button>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
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
  <script src="../assets/compiled/js/applicationSearch.js"></script>

</body>

</html>