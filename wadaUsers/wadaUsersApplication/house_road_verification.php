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
  <title>House Road Verification - WadaConnect</title>

  <link rel="shortcut icon" href="../../assets/compiled/jpg/shortcut.png" type="image/png" />

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
              <h3>House/Road Verification</h3>
              <p class="text-subtitle text-muted">A page where applicant can change house/road information</p>
            </div>
          </div>
        </div>
        <section class="section">
          <form method="POST" action="../../php/house_road_verification/session_insert_house_road_verificaiton_details.php" enctype="multipart/form-data" data-parsley-validate>
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">House/Road Details</h4>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="house-road-verification-district-column">District</label>
                          <select id="house-road-verification-district-column" class="form-select" onclick="district_select('house-road-verification-district-column', 'house-road-verification-municipality-column')" name="house-road-verification-district-column" data-parsley-required="true" data-parsley-error-message="District is required.">
                            <option value="none" disabled selected>Select District</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="house-road-verification-municipality-column">Municipality</label>
                          <select id="house-road-verification-municipality-column" class="form-select" name="house-road-verification-municipality-column" data-parsley-required="true" data-parsley-error-message="Municipality is required.">
                            <option value="none" disabled selected>Select Municipality</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="house-road-verification-municipality-type-column">Municipality Type</label>
                          <select id="house-road-verification-municipality-type-column" class="form-select" name="house-road-verification-municipality-type-column" data-parsley-required="true" data-parsley-error-message="Municipality Type is required.">
                            <option value="none" disabled selected>Select Municipality Type</option>
                            <option value="Municipality">Municipality</option>
                            <option value="Sub-Metropolitan">Sub-Metropolitan</option>
                            <option value="Metropolitan">Metropolitan</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="house-road-verification-ward-column">Ward</label>
                          <input type="number" id="house-road-verification-ward-column" class="form-control" placeholder="Ward Number" name="house-road-verification-ward-column" data-parsley-required="true" data-parsley-error-message="Ward Number is required.">
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="house-road-verification-map-column">Map Number</label>
                          <input type="number" id="house-road-verification-map-column" class="form-control" placeholder="Map Number" name="house-road-verification-map-column" data-parsley-required="true" data-parsley-error-message="Map Number is required.">
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="house-road-verification-kitta-number-column">Kitta Number</label>
                          <input type="text" id="house-road-verification-kitta-number-column" class="form-control" placeholder="Kitta Number" name="house-road-verification-kitta-number-column" data-parsley-required="true" data-parsley-error-message="Kitta Number is required.">
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="house-road-verification-area-column">Area</label>
                          <input type="text" id="house-road-verification-area-column" class="form-control" placeholder="Total Area" name="house-road-verification-area-column" data-parsley-required="true" data-parsley-error-message="Area is required.">
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="house-road-verification-road-presence-column">Road Presence</label>
                          <select id="house-road-verification-road-presence-column" class="form-select" name="house-road-verification-road-presence-column" data-parsley-required="true" data-parsley-error-message="Road Presence is required.">
                            <option value="none" disabled selected>Select Road Presence</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
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
                  <h4 class="card-title">House Buyer Personal Details</h4>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="house-road-verification-land-buyer-name-column">जग्गा खरिदकर्ताको नाम</label>
                          <input type="text" id="house-road-verification-land-buyer-name-column" class="form-control" oninput="validateNepaliInput(event)" placeholder="जग्गा खरिदकर्ताको नाम" name="house-road-verification-land-buyer-name-column" data-parsley-required="true" data-parsley-error-message="Land Buyer Name is required.">
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="house-road-verification-land-buyer-spouse-name-column">जग्गा खरिदकर्ता पति/पत्नीको नाम</label>
                          <input type="text" id="house-road-verification-land-buyer-spouse-name-column" class="form-control" oninput="validateNepaliInput(event)" placeholder="जग्गा खरिदकर्ता पति/पत्नीको नाम" name="house-road-verification-land-buyer-spouse-name-column">
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="house-road-verification-land-buyer-citizenship-number-column">Land Buyer Citizenship Number</label>
                          <input type="text" id="house-road-verification-land-buyer-citizenship-number-column" class="form-control" placeholder="Land Buyer Citizenship Number" name="house-road-verification-land-buyer-citizenship-number-column" data-parsley-required="true" data-parsley-error-message="Land Buyer Citizenship Number is required.">
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="house-road-verification-land-buyer-citizenship-district-column">Land Buyer Citizenship District</label>
                          <select id="house-road-verification-land-buyer-citizenship-district-column" class="form-select" name="house-road-verification-land-buyer-citizenship-district-column" data-parsley-required="true" data-parsley-error-message="Land Buyer Citizenship District is required.">
                            <option value="none" disabled selected>Select District</option>
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
                  <h4 class="card-title">House Buyer Address Details</h4>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="house-road-verification-land-buyer-province-column">Land Buyer Province</label>
                          <select id="house-road-verification-land-buyer-province-column" class="form-select" onclick="province_select('house-road-verification-land-buyer-province-column', 'house-road-verification-land-buyer-district-column', 'house-road-verification-land-buyer-municipality-column')" name="house-road-verification-land-buyer-province-column" data-parsley-required="true" data-parsley-error-message="Land Buyer Province is required.">
                            <option value="none" disabled selected>Select Province</option>
                            <option value='koshi'>Koshi Pradesh</option>
                            <option value='madhesh'>Madhesh Pradesh</option>
                            <option value='bagmati'>Bagmati Pradesh</option>
                            <option value='gandaki'>Gandaki Pradesh</option>
                            <option value='lumbini'>Lumbini Pradesh</option>
                            <option value='karnali'>Karnali Pradesh</option>
                            <option value='sudhur_paschim'>Sudurpaschim Pradesh</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="house-road-verification-land-buyer-district-column">Land Buyer District</label>
                          <select id="house-road-verification-land-buyer-district-column" class="form-select" onclick="district_select('house-road-verification-land-buyer-district-column', 'house-road-verification-land-buyer-municipality-column')" name="house-road-verification-land-buyer-district-column" data-parsley-required="true" data-parsley-error-message="Land Buyer District is required.">
                            <option value="none" disabled selected>Select District</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="house-road-verification-land-buyer-municipality-column">Land Buyer Municipality</label>
                          <select id="house-road-verification-land-buyer-municipality-column" class="form-select" name="house-road-verification-land-buyer-municipality-column" data-parsley-required="true" data-parsley-error-message="Land Buyer Municipality is required.">
                            <option value="none" disabled selected>Select Municipality</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="house-road-verification-land-buyer-ward-column">Land Buyer Ward</label>
                          <input type="number" id="house-road-verification-land-buyer-ward-column" class="form-control" placeholder="Land Buyer Ward Number" name="house-road-verification-land-buyer-ward-column" data-parsley-required="true" data-parsley-error-message="Land Buyer Ward Number is required.">
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
                  <h4 class="card-title">House Land Document</h4>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="house-road-verification-citizenship-column">Citizenship Document</label>
                          <input type="file" class="form-control" id="formFile" name="house-road-verification-citizenship-column" data-parsley-required="true" data-parsley-error-message="Citizenship is required.">
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="house-road-verification-land-ownership-column">Land Ownership Document</label>
                          <input type="file" class="form-control" id="formFile" name="house-road-verification-land-ownership-column" data-parsley-required="true" data-parsley-error-message="Land Ownership is required.">
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="house-road-verification-land-map-column">Land Map Document</label>
                          <input type="file" class="form-control" id="formFile" name="house-road-verification-land-map-column" data-parsley-required="true" data-parsley-error-message="Land Map is required.">
                        </div>
                      </div>
                      <div class="col-md-4 col-12">
                        <div class="form-group">
                          <label for="house-road-verification-land-tax-column">Land Tax Receipt</label>
                          <input type="file" class="form-control" id="formFile" name="house-road-verification-land-tax-column" data-parsley-required="true" data-parsley-error-message="Land Tax is required.">
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
                  <h4 class="card-title">House/Road Details</h4>
                </div>
                <div class="card-content">
                  <div class="table-responsive">
                    <table class="table table-lg table-hover">
                      <thead>
                        <tr>
                          <th>SN. NO.</th>
                          <th>MUNCIPALITY</th>
                          <th>WARD NO.</th>
                          <th>MAP NO.</th>
                          <th>KITTA NO.</th>
                          <th>AREA</th>
                          <th>ROAD PRESENCE</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        require_once '../../php/house_road_verification/session_select_house_road_verification_details.php';
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
                  <a href="../../php/house_road_verification/session_reset_house_road_verification_details.php" class="btn icon icon-left btn-secondary"><i data-feather="refresh-cw"></i>Reset Form</a>
                  <a href="../../php/house_road_verification/insert_house_road_verification_details.php" class="btn icon icon-left btn-success"><i data-feather="check-circle"></i>Submit Form</a>
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

  <script>
    window.onload = function() {
      district_all('house-road-verification-district-column');
      district_all('house-road-verification-land-buyer-citizenship-district-column');
    };
  </script>
</body>

</html>