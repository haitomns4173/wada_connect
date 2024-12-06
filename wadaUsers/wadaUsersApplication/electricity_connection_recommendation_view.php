<?php
session_start();
if (!isset($_SESSION['userLoginStatus']) || $_SESSION['userLoginStatus'] !== true || $_SESSION['wadaMemberUserType'] != 3) {
  header('Location: ../../login.php');
  exit;
}

if ($_SESSION['wadaMemberID'] == 0) {
  echo "<script>alert('Please complete your profile first.');';</script>";
  header('Location: ../applicant_profile.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Electricity Connection Recommendation - WadaConnect</title>

  <link rel="shortcut icon" href="../../assets/compiled/jpg/shortcut.png" type="image/png" />

  <link rel="stylesheet" href="../../assets/extensions/choices.js/public/assets/styles/choices.css">
  <link rel="stylesheet" crossorigin href="../../assets/compiled/css/app.css" />
  <link rel="stylesheet" crossorigin href="../../assets/compiled/css/app-dark.css" />
  <link rel="stylesheet" crossorigin href="../../assets/compiled/css/iconly.css" />
</head>

<body>
  <script src="../../assets/static/js/initTheme.js"></script>
  <div id="app">
    <div id="sidebar">
      <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
          <div class="d-flex justify-content-between align-items-center">
            <div class="logo">
              <a href="../index.php"><img src="../../assets/compiled/jpg/logo.png" alt="Logo" srcset="" /></a>
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
              <a href="../application_apply.php" class="sidebar-link">
                <i class="bi bi-file-arrow-up-fill"></i>
                <span>Application Apply</span>
              </a>
            </li>
            <li class="sidebar-item active">
              <a href="../application_submit.php" class="sidebar-link">
                <i class="bi bi-file-earmark-text-fill"></i>
                <span>Application Submit</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a href="../applicant_profile.php" class="sidebar-link">
                <i class="bi bi-person-lines-fill"></i>
                <span>Applicant Profile</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a href="../applicant_account.php" class="sidebar-link">
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
      <?php
      require_once '../../php/electricity_connection_recommendation/view_electricity_connection_recommendation.php';
      ?>
      <div class="page-heading">
        <div class="page-title">
          <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
              <h3>View Electricity Connection Recommendation Form</h3>
              <p class="text-subtitle text-muted">A page where applicant can view Electricity Connection Recommendation information</p>
            </div>
          </div>
        </div>
        <section class="section">
          <div class="row" id="basic-table">
            <div class="col-12 col-md-6">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">House Address Details</h4>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-lg">
                        <tbody>
                          <tr>
                            <td class="text-bold-500">District :</td>
                            <td class="text-bold-500"><?php echo ucfirst($wadaMemberElectricConnectionDistrict) ?></td>
                          </tr>
                          <tr>
                            <td class="text-bold-500">Municipality :</td>
                            <td class="text-bold-500"><?php echo ucfirst($wadaMemberElectricConnectionMunicipality) ?></td>
                          </tr>
                          <tr>
                            <td class="text-bold-500">Ward :</td>
                            <td class="text-bold-500"><?php echo $wadaMemberElectricConnectionWard ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">House Land Details</h4>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-lg">
                        <tbody>
                          <tr>
                            <td class="text-bold-500">Map No. :</td>
                            <td class="text-bold-500"><?php echo $wadaMemberElectricConnectionMapNo ?></td>
                          </tr>
                          <tr>
                            <td class="text-bold-500">Kitta No. :</td>
                            <td class="text-bold-500"><?php echo $wadaMemberElectricConnectionKittaNo ?></td>
                          </tr>
                          <tr>
                            <td class="text-bold-500">Area :</td>
                            <td class="text-bold-500"><?php echo $wadaMemberElectricConnectionArea ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">House Land Documents</h4>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-4 col-12">
                        <img src='../../<?php echo $wadaMemberElectricConnectionCitizenshipDocument ?>' alt='Citizenship Card' class='img-thumbnail'>
                      </div>
                      <div class="col-md-4 col-12">
                        <img src='../../<?php echo $wadaMemberElectricConnectionLandOwnershipDocument ?>' alt='Land Ownership Document' class='img-thumbnail'>
                      </div>
                      <div class="col-md-4 col-12">
                        <img src='../../<?php echo $wadaMemberElectricConnectionLandMapDocument ?>' alt='Land Map Document' class='img-thumbnail'>
                      </div>
                      <div class="col-md-4 col-12">
                        <br>
                        <img src='../../<?php echo $wadaMemberElectricConnectionLandTaxDocument ?>' alt='Citizenship Card' class='img-thumbnail'>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Wada Office Section</h4>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-lg">
                        <tbody>
                          <tr>
                            <td class="text-bold-500">Wada Sent Status :</td>
                            <?php
                            if ($wadaConnectApplicationWadaSentStatus == 'Sent') {
                              echo "<td class='text-bold-500'><span class='badge bg-light-success'>Sent</span></td>";
                            } else {
                              echo "<td class='text-bold-500'><span class='badge bg-light-danger'>Unsent</span></td>";
                            }
                            ?>
                          </tr>
                          <tr>
                            <td class="text-bold-500">Application Status :</td>
                            <?php
                            if ($wadaConnectApplicationStatus == 'Pending') {
                              echo "<td class='text-bold-500'><span class='badge bg-light-primary'>Pending</span></td>";
                            } else if ($wadaConnectApplicationStatus == 'Processing') {
                              echo "<td class='text-bold-500'><span class='badge bg-light-warning'>Processing</span></td>";
                            } else if ($wadaConnectApplicationStatus == 'Approved') {
                              echo "<td class='text-bold-500'><span class='badge bg-light-success'>Approved</span></td>";
                            } else if ($wadaConnectApplicationStatus == 'Rejected') {
                              echo "<td class='text-bold-500'><span class='badge bg-light-danger'>Rejected</span></td>";
                            }
                            ?>
                          </tr>
                          <tr>
                            <?php
                            if ($wadaConnectApplicationStatus == 'Approved') {
                              echo "<td class='text-bold-500'>Approved Document :</td>";
                              echo "<td class='text-bold-500'><a href='../../wadaMemberDocuments/applictionApproved/$wadaConnectApplicationApprovedDocument' class='btn btn-success' target='_blank'><i data-feather='eye'></i></a></td>";
                            }
                            ?>
                          </tr>
                          <tr>
                            <?php
                            if ($wadaConnectApplicationStatus == 'Rejected') {
                              echo "<td class='text-bold-500'>Remarks :</td>";
                              echo "<td class='text-bold-500'>$wadaConnectApplicationRemarks</td>";
                            }
                            ?>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Control Buttons</h4>
                </div>
                <div class="card-body">
                  <div class="buttons">
                    <a href="../../php/send_to_wada_status.php?wadaApplicationID=<?php echo $wadaConnectApplicationListingID ?>&wadaMemberFormID=<?php echo $wadaMemberElectricityFormID ?>&applicationType=2" class="btn icon icon-left btn-success"><i data-feather="send"></i>Send to Wada</a>
                    <a href="../../php/electricity_connection_recommendation/electricity_connection_recommendation_print.php?wadaMemberElectricConnectionFormID=<?php echo $wadaMemberElectricityFormID ?>&wadaMemberID=<?php echo $wadaMemberElectricConnectionUserID ?>" class="btn icon icon-left btn-primary" target="_blank"><i data-feather="download"></i>Download Application</a>
                    <a href="" class="btn icon icon-left btn-danger"><i data-feather="trash-2"></i>Delete Form</a>
                    <a href="" class="btn icon icon-left btn-warning"><i data-feather="arrow-up-circle"></i>Update Form</a>
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
  <script src="../../assets/static/js/components/dark.js"></script>
  <script src="../../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>

  <script src="../../assets/compiled/js/app.js"></script>

  <script src="../../assets/extensions/jquery/jquery.min.js"></script>
  <script src="../../assets/extensions/parsleyjs/parsley.min.js"></script>
  <script src="../../assets/static/js/pages/parsley.js"></script>
  <script src="../../assets/compiled/js/sweetAlert.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      <?php if (isset($_SESSION['status']) && isset($_SESSION['message'])): ?>
        const status = "<?php echo $_SESSION['status']; ?>";
        const message = "<?php echo $_SESSION['message']; ?>";

        Swal.fire({
          title: status === 'success' ? 'Success!' : 'Error!',
          text: message,
          icon: status,
          confirmButtonText: 'OK'
        }).then(() => {
          <?php
          unset($_SESSION['status']);
          unset($_SESSION['message']);
          ?>
        });
      <?php endif; ?>
    });
  </script>
</body>

</html>