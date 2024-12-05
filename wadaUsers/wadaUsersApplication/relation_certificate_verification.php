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
  <title>Relation Verification - WadaConnect</title>

  <link rel="shortcut icon" href="../../assets/compiled/jpg/shortcut.png" type="image/png"/>
  
  <link rel="stylesheet" href="../../assets/extensions/choices.js/public/assets/styles/choices.css">
  <link rel="stylesheet" crossorigin href="../../assets/compiled/css/app.css" />
  <link rel="stylesheet" crossorigin href="../../assets/compiled/css/app-dark.css" />
  <link rel="stylesheet" crossorigin href="../../assets/compiled/css/iconly.css" />

  <link rel="stylesheet" href="../../assets/extensions/filepond/filepond.css">
  <link rel="stylesheet" href="../../assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css">
  <link rel="stylesheet" href="../../assets/extensions/toastify-js/src/toastify.css">

  <script src="../../assets/compiled/js/address.js" type="text/javascript"></script>

  <script>
    function validateNepaliInput(event) {
      const nepaliRegex = /^[\u0900-\u097F\s]+$/;

      const input = event.target.value;

      if (!nepaliRegex.test(input)) {
        event.target.value = input.slice(0, -1);
      }
    }
  </script>
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
            <li class="sidebar-item active">
              <a href="../application_apply.php" class="sidebar-link">
                <i class="bi bi-file-arrow-up-fill"></i>
                <span>Application Apply</span>
              </a>
            </li>
            <li class="sidebar-item">
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

      <div class="page-heading">
        <div class="page-title">
          <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
              <h3>Relation Verification Form</h3>
              <p class="text-subtitle text-muted">A page where applicant can change relation verification information</p>
            </div>
          </div>
        </div>
        <section class="section">
          <form action="../../php/relation_certificate_verification/session_insert_relation_certificate_verification_details.php" enctype="multipart/form-data" method="POST" data-parsley-validate>
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">सम्बन्धित व्यक्तिको व्यक्तिगत विवरण</h4>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="relation-certificate-name-column">पूरा नाम</label>
                          <input type="text" id="relation-certificate-name-column" placeholder="नाम, थर" class="form-control" oninput="validateNepaliInput(event)" name="relation-certificate-name-column" data-parsley-required="true" data-parsley-error-message="नाम, थर आवश्यक छ।" />
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="relation-certificate-age-column">उमेर</label>
                          <input type="number" id="relation-certificate-age-column" placeholder="उमेर" class="form-control" name="relation-certificate-age-column" data-parsley-required="true" data-parsley-error-message="उमेर आवश्यक छ।" />
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="relation-certificate-gender-column">लिङ्ग</label>
                          <select id="relation-certificate-gender-column" class="form-select" name="relation-certificate-gender-column" data-parsley-required="true" data-parsley-error-message="लिङ्ग आवश्यक छ।">
                            <option disabled selected>लिङ्ग चयन गर्नुहोस्</option>
                            <option value='male'>पुरुष</option>
                            <option value='female'>महिला</option>
                            <option value='other'>अन्य</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="relation-certification-relationship-column">हालको सम्बन्ध</label>
                          <select id="relation-certification-relationship-column" class="form-select" name="relation-certification-relationship-column" data-parsley-required="true" data-parsley-error-message="सम्बन्ध आवश्यक छ।">
                            <option value="none" disabled selected>सम्बन्ध चयन गर्नुहोस्</option>
                            <option value="बुवा">बुवा</option>
                            <option value="आमा">आमा</option>
                            <option value="छोरा">छोरा</option>
                            <option value="छोरी">छोरी</option>
                            <option value="हजुरबुवा">हजुरबुवा</option>
                            <option value="हजुरआमा">हजुरआमा</option>
                            <option value="नाति">नाति</option>
                            <option value="नातिनी">नातिनी</option>
                            <option value="पति">पति</option>
                            <option value="पत्नी">पत्नी</option>
                            <option value="दाजु/भाइ">दाजु/भाइ</option>
                            <option value="दिदी/बहिनी">दिदी/बहिनी</option>
                            <option value="काका/मामा">काका/मामा</option>
                            <option value="काकी/माइजू">काकी/माइजू</option>
                            <option value="भतिजा">भतिजा</option>
                            <option value="भान्जी">भान्जी</option>
                            <option value="दाजुभाइ/दिदीबहिनी">दाजुभाइ/दिदीबहिनी</option>
                            <option value="ससुराल">ससुराल</option>
                            <option value="अन्य">अन्य</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Related People Address Details</h4>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="relation-certification-district-column">District</label>
                          <select id="relation-certification-district-column" class="form-select" onchange="district_select('relation-certification-district-column','relation-certification-municipality-column')" name="relation-certification-district-column" data-parsley-required="true" data-parsley-error-message="District is required.">
                            <option value="none" disabled selected>Select District</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="relation-certification-municipality-column">Municipality</label>
                          <select id="relation-certification-municipality-column" class="form-select" name="relation-certification-municipality-column" data-parsley-required="true" data-parsley-error-message="Municipality is required.">
                            <option value="none" disabled selected>Select Municipality</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="relation-certification-municipality-type-column">Municipality Type</label>
                          <select id="relation-certification-municipality-type-column" class="form-select" name="relation-certification-municipality-type-column" data-parsley-required="true" data-parsley-error-message="Municipality Type is required.">
                            <option value="none" disabled selected>Select Municipality Type</option>
                            <option value="Municipality">Municipality</option>
                            <option value="Sub-Metropolitan">Sub-Metropolitan</option>
                            <option value="Metropolitan">Metropolitan</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="relation-certification-ward-column">Ward</label>
                          <input type="number" id="relation-certification-ward-column" placeholder="Ward" class="form-control" name="relation-certification-ward-column" data-parsley-required="true" data-parsley-error-message="Ward is required." />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Related People Citizenship Document</h4>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="relation-certification-citizenship-column">Citizenship Document</label>
                          <input type="file" class="form-control" id="formFile" name="relation-certification-citizenship-column" data-parsley-required="true" data-parsley-error-message="Citizenship is required.">
                        </div>
                      </div>
                      <div class="col-12 d-flex justify-content-end">
                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <div class="row" id="table-hover-row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Relation Details</h4>
                </div>
                <div class="card-content">
                  <div class="table-responsive">
                    <table class="table table-lg table-hover">
                      <thead>
                        <tr>
                          <th>SN. NO.</th>
                          <th>FULL NAME</th>
                          <th>AGE</th>
                          <th>GENDER</th>
                          <th>DISTRICT</th>
                          <th>RELATION</th>
                          <th>ACTION</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        require_once '../../php/relation_certificate_verification/session_select_relation_certificate_verification_details.php';
                        ?>
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
                  <a href="../../php/relation_certificate_verification/session_reset_relation_certificate_verification_details.php" class="btn icon icon-left btn-secondary"><i data-feather="refresh-cw"></i>Reset Form</a>
                  <a href="../../php/relation_certificate_verification/insert_relation_certificate_verification_details.php" class="btn icon icon-left btn-success"><i data-feather="check-circle"></i>Submit Form</a>
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
              <a href="https://haitomns.com">Haitomns Groups Private Limited</a>
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

  <script>
    window.onload = function() {
      district_all('relation-certification-district-column');
    };
  </script>
</body>

</html>