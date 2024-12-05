<?php
session_start();

require_once '../php/database_connection.php';

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
  <title>Applicant Profile - WadaConnect</title>

  <link rel="shortcut icon" href="../assets/compiled/jpg/shortcut.png" type="image/png" />

  <link rel="stylesheet" href="../assets/extensions/choices.js/public/assets/styles/choices.css">
  <link rel="stylesheet" crossorigin href="../assets/compiled/css/app.css" />
  <link rel="stylesheet" crossorigin href="../assets/compiled/css/app-dark.css" />
  <link rel="stylesheet" crossorigin href="../assets/compiled/css/iconly.css" />

  <link rel="stylesheet" href="../assets/extensions/filepond/filepond.css">
  <link rel="stylesheet" href="../assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css">
  <link rel="stylesheet" href="../assets/extensions/toastify-js/src/toastify.css">

  <link rel="stylesheet" href="../assets/extensions/nepalidatepicker/css/nepali-date-picker.min.css">

  <script src="../assets/compiled/js/address.js" type="text/javascript"></script>

  <script src="https://cdn.jsdelivr.net/npm/tesseract.js@v2.0.1/dist/tesseract.min.js"></script>

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
            <li class="sidebar-item active">
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
              <h3>Applicant Profile</h3>
              <p class="text-subtitle text-muted">View and update personal details.</p>
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Form Filler</h4>
            </div>
            <div class="card-content">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4 col-12">
                    <div class="form-group">
                      <label for="form-filler-citizenship-column">Citizenship Document</label>
                      <input type="file" class="form-control" id="formFile" name="form-filler-citizenship-column" data-parsley-required="true" data-parsley-error-message="Citizenship is required.">
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

        <?php
        require_once '../php/select_wada_member.php';
        ?>
        <form method="POST" action="../php/insert_wada_member_details.php" enctype="multipart/form-data" data-parsley-validate>
          <section id="multiple-column-form">
            <div class="row match-height">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Personal Details</h4>
                  </div>
                  <div class="card-content">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-4 col-12">
                          <div class="form-group">
                            <label for="first-name-column">First Name</label>
                            <input type="text" id="first-name-column" class="form-control" placeholder="First Name" name="fname-column" data-parsley-required="true" data-parsley-error-message="First Name is required." value="<?php echo $wadaMemberFirstName ?>">
                          </div>
                        </div>
                        <div class="col-md-4 col-12">
                          <div class="form-group">
                            <label for="middle-name-column">Middle Name</label>
                            <input type="text" id="middle-name-column" class="form-control" placeholder="Middle Name" name="mname-column" value="<?php echo $wadaMemberMiddleName ?>">
                          </div>
                        </div>
                        <div class="col-md-4 col-12">
                          <div class="form-group">
                            <label for="last-name-column">Last Name</label>
                            <input type="text" id="last-name-column" class="form-control" placeholder="Last Name" name="lname-column" data-parsley-required="true" data-parsley-error-message="Last Name is required." value="<?php echo $wadaMemberLastName ?>">
                          </div>
                        </div>
                        <div class="col-md-4 col-12">
                          <div class="form-group">
                            <label for="dob-bs-column">Date of Birth (B.S.)</label>
                            <input type="text" id="dob-bs-column" class="date-picker form-control" placeholder="YYYY-MM-DD" name="dob-bs-column" data-single="1" data-parsley-required="true" data-parsley-error-message="Date of Birth is required." value="<?php echo $wadaMemberDateOfBirth ?>" />
                          </div>
                        </div>
                        <div class="col-md-4 col-12">
                          <div class="form-group">
                            <label for="gender-column">Gender</label>
                            <select class="form-select" name="gender-column" id="gender-column" data-parsley-required="true" data-parsley-error-message="Gender is required.">
                              <?php
                              if ($wadaMemberGender == 'male') {
                                echo "
                                    <option disabled>Select Gender</option>
                                    <option value='male' selected>Male</option>
                                    <option value='female'>Female</option>
                                    <option value='other'>Other</option>
                                  ";
                              } else if ($wadaMemberGender == 'female') {
                                echo "
                                    <option disabled>Select Gender</option>
                                    <option value='male'>Male</option>
                                    <option value='female' selected>Female</option>
                                    <option value='other'>Other</option>
                                  ";
                              } else {
                                echo "
                                  <option disabled selected>Select Gender</option>
                                  <option value='male'>Male</option>
                                  <option value='female'>Female</option>
                                  <option value='other'>Other</option>";
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4 col-12">
                          <div class="form-group">
                            <label for="phone-number-column">Phone Number</label>
                            <div class="input-group mb-3">
                              <span class="input-group-text" id="basic-addon1">+977</span>
                              <input type="number" id="phone-number-column" class="form-control" placeholder="Phone Number" name="phone-number-column" pattern="\d{10}" data-parsley-required="true" data-parsley-error-message="Phone Number is required." value="<?php echo $wadaMemberPhoneNo ?>">
                            </div>
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
                    <h4 class="card-title">व्यक्तिगत विवरणहरू</h4>
                  </div>
                  <div class="card-content">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-4 col-12">
                          <div class="form-group">
                            <label for="first-name-column-np">पहिलो नाम</label>
                            <input type="text" id="first-name-column-np" class="form-control" placeholder="पहिलो नाम नेपालीमा" name="fname-column-np" oninput="validateNepaliInput(event)" value="<?php echo $wadaMemberFirstNameNP ?>" data-parsley-required="true" data-parsley-error-message="पहिलो नाम आवश्यक छ।">
                          </div>
                        </div>
                        <div class="col-md-4 col-12">
                          <div class="form-group">
                            <label for="middle-name-column-np">मध्य नाम</label>
                            <input type="text" id="middle-name-column-np" class="form-control" placeholder="मध्य नाम नेपालीमा" name="mname-column-np" oninput="validateNepaliInput(event)" value="<?php echo $wadaMemberMiddleNameNP ?>">
                          </div>
                        </div>
                        <div class="col-md-4 col-12">
                          <div class="form-group">
                            <label for="last-name-column-np">अन्तिम नाम</label>
                            <input type="text" id="last-name-column-np" class="form-control" placeholder="अन्तिम नाम नेपालीमा" name="lname-column-np" oninput="validateNepaliInput(event)" data-parsley-required="true" value="<?php echo $wadaMemberLastNameNP ?>" data-parsley-error-message="अन्तिम नाम आवश्यक छ।">
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
                    <h4 class="card-title">Family Details</h4>
                  </div>
                  <div class="card-content">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-4 col-12">
                          <div class="form-group">
                            <label for="fathers-name-column">Father's Name</label>
                            <input type="text" id="fathers-name-column" class="form-control" placeholder="Father's Name" name="fathers-name-column" data-parsley-required="true" data-parsley-error-message="Father's Name is required." value="<?php echo $wadaMemberFatherName ?>">
                          </div>
                        </div>
                        <div class="col-md-4 col-12">
                          <div class="form-group">
                            <label for="mothers-name-column">Mother's Name</label>
                            <input type="text" id="mothers-name-column" class="form-control" placeholder="Mother's Name" name="mothers-name-column" value="<?php echo $wadaMemberMotherName ?>">
                          </div>
                        </div>
                        <div class="col-md-4 col-12">
                          <div class="form-group">
                            <label for="grandfathers-name-column">Grandfather's Name</label>
                            <input type="text" id="grandfathers-name-column" class="form-control" placeholder="Grandfather's Name" name="grandfathers-name-column" value="<?php echo $wadaMemberGrandFatherName ?>">
                          </div>
                        </div>
                        <div class="col-md-4 col-12">
                          <div class="form-group">
                            <label for="marital-status-column">Marital Status</label>
                            <select class="form-select" id="marital-status-column" name="marital-status-column" data-parsley-required="true" data-parsley-error-message="Marital Status is required.">
                              <?php
                              if ($wadaMemberMaritalStatus == 'married') {
                                echo
                                "
                                    <option disabled>Select Marital Status</option>
                                    <option value='married' selected>Married</option>
                                    <option value='unmarried'>Unmarried</option>
                                    <option value='divorced'>Divorced</option>
                                    <option value='widowed'>Widowed</option>
                                  ";
                              } else if ($wadaMemberMaritalStatus == 'unmarried') {
                                echo
                                "
                                    <option disabled>Select Marital Status</option>
                                    <option value='married'>Married</option>
                                    <option value='unmarried' selected>Unmarried</option>
                                    <option value='divorced'>Divorced</option>
                                    <option value='widowed'>Widowed</option>
                                  ";
                              } else if ($wadaMemberMaritalStatus == 'divorced') {
                                echo
                                "
                                    <option disabled>Select Marital Status</option>
                                    <option value='married'>Married</option>
                                    <option value='unmarried'>Unmarried</option>
                                    <option value='divorced' selected>Divorced</option>
                                    <option value='widowed'>Widowed</option>
                                  ";
                              } else if ($wadaMemberMaritalStatus == 'widowed') {
                                echo
                                "
                                    <option disabled>Select Marital Status</option>
                                    <option value='married'>Married</option>
                                    <option value='unmarried'>Unmarried</option>
                                    <option value='divorced'>Divorced</option>
                                    <option value='widowed' selected>Widowed</option>
                                  ";
                              } else {
                                echo
                                "
                                    <option disabled selected>Select Marital Status</option>
                                    <option value='married'>Married</option>
                                    <option value='unmarried'>Unmarried</option>
                                    <option value='divorced'>Divorced</option>
                                    <option value='widowed'>Widowed</option>
                                  ";
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4 col-12" id="spouse-name-field">
                          <div class="form-group">
                            <label for="spouse-name-column">Spouse's Name</label>
                            <input type="text" id="spouse-name-column" class="form-control" placeholder="Spouse's Name" name="spouse-name-column" value="<?php echo $wadaMemberSpouseName ?>">
                          </div>
                        </div>
                        <div class="col-md-4 col-12" id="children-field">
                          <div class="form-group">
                            <label for="children-column">Number of Children</label>
                            <input type="number" id="children-column" class="form-control" placeholder="Number of Children" name="children-column" value="<?php echo $wadaMemberNumberOfChildern ?>">
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
                    <h4 class="card-title">पारिवारिक विवरण</h4>
                  </div>
                  <div class="card-content">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-4 col-12">
                          <div class="form-group">
                            <label for="fathers-name-column-np">बुबाको नाम</label>
                            <input type="text" id="fathers-name-column-np" class="form-control" placeholder="बुबाको नाम नेपालीमा" name="fathers-name-column-np" oninput="validateNepaliInput(event)" value="<?php echo $wadaMemberFatherNameNP ?>" data-parsley-required="true" data-parsley-error-message="बुबाको नाम चाहिन्छ।">
                          </div>
                        </div>
                        <div class="col-md-4 col-12">
                          <div class="form-group">
                            <label for="mothers-name-column-np">आमाको नाम</label>
                            <input type="text" id="mothers-name-column-np" class="form-control" placeholder="आमाको नाम नेपालीमा" name="mothers-name-column-np" oninput="validateNepaliInput(event)" value="<?php echo $wadaMemberMotherNameNP ?>">
                          </div>
                        </div>
                        <div class="col-md-4 col-12">
                          <div class="form-group">
                            <label for="grandfathers-name-column-np">हजुरबुबाको नाम</label>
                            <input type="text" id="grandfathers-name-column-np" class="form-control" placeholder="हजुरबुबाको नाम नेपालीमा" name="grandfathers-name-column-np" oninput="validateNepaliInput(event)" value="<?php echo $wadaMemberGrandFatherNameNP ?>">
                          </div>
                        </div>
                        <div class="col-md-4 col-12" id="spouse-name-field">
                          <div class="form-group" id="spouse-name-column-np-field">
                            <label for="spouse-name-column-np">पति/पत्नीको नाम</label>
                            <input type="text" id="spouse-name-column-np" class="form-control" placeholder="पति/पत्नीको नाम नेपालीमा" name="spouse-name-column-np" oninput="validateNepaliInput(event)" value="<?php echo $wadaMemberSpouseNameNP ?>">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title">Citizenship Card Details</h4>
                    </div>
                    <div class="card-content">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-4 col-12">
                            <div class="form-group">
                              <label for=" citizenship-number-column">Citizenship Number</label>
                              <input type="text" id="citizenship-number-column" class="form-control" placeholder="Citizenship Number" name="citizenship-number-column" data-parsley-required="true" data-parsley-error-message="Citizenship Number is required." value="<?php echo $wadaMemberCitizenshipNumber ?>">
                            </div>
                          </div>
                          <div class="col-md-4 col-12">
                            <div class="form-group">
                              <label for=" citizenship-issued-date-column">Citizenship Issued Date (B.S.)</label>
                              <input type="text" id="citizenship-issued-date-column" class="date-picker form-control" placeholder="YYYY-MM-DD" name="citizenship-issued-date-column" data-single="1" data-parsley-required="true" data-parsley-error-message="Citizenship Issueed Date is required." value="<?php echo $wadaMemberCitizenshipIssuedDate ?>">
                            </div>
                          </div>
                          <div class="col-md-4 col-12">
                            <div class="form-group">
                              <label for=" citizenship-issued-district-column">Citizenship Issued District</label>
                              <select id="citizenship-issued-district-column" class="form-select" data-parsley-required="true" name="citizenship-issued-district-column" data-parsley-error-message="Citizenship Issued District is required.">
                                <option value="none" disabled selected>Select District</option>
                                <?php
                                require_once '../php/address_handler/citizenship_district_select.php'
                                ?>
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
                      <h4 class="card-title">Address</h4>
                    </div>
                    <div class="card-content">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-3 col-12">
                            <div class="form-group">
                              <label for="address-province-column">Permanent Address Province</label>
                              <select class="form-select" id="permanent_province" name="permanent_province" onclick="province_select('permanent_province', 'permanent_district', 'permanent_municipality')" data-parsley-required="true" data-parsley-error-message="Province is required.">
                                <option value="none" disabled selected>Select Province</option>
                                <?php
                                if ($_SESSION['wadaMemberID'] == 0) {
                                  echo "<option value='koshi'>Koshi Pradesh</option>";
                                  echo "<option value='madhesh'>Madhesh Pradesh</option>";
                                  echo "<option value='bagmati'>Bagmati Pradesh</option>";
                                  echo "<option value='gandaki'>Gandaki Pradesh</option>";
                                  echo "<option value='lumbini'>Lumbini Pradesh</option>";
                                  echo "<option value='karnali'>Karnali Pradesh</option>";
                                  echo "<option value='sudhur_paschim'>Sudurpaschim Pradesh</option>";
                                } else {
                                  require_once '../php/address_handler/permanent_address_province_select.php';
                                }
                                ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3 col-12">
                            <div class="form-group">
                              <label for="address-district-column">Permanent Address District</label>
                              <select class="form-select" id="permanent_district" name="permanent_district" onclick="district_select('permanent_district', 'permanent_municipality')" data-parsley-required="true" data-parsley-error-message="District is required.">
                                <option value="none" disabled selected>Select District</option>
                                <?php
                                if (!($_SESSION['wadaMemberID'] == 0)) {
                                  require_once '../php/address_handler/permanent_address_district_select.php';
                                }
                                ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3 col-12">
                            <div class="form-group">
                              <label for="address-municipality-column">Permanent Address Municipality</label>
                              <select class="form-select" id="permanent_municipality" name="permanent_municipality" data-parsley-required="true" data-parsley-error-message="Municipality is required.">
                                <option value="none" disabled selected>Select Municipality</option>
                                <?php
                                if (!($_SESSION['wadaMemberID'] == 0)) {
                                  require_once '../php/address_handler/permanent_address_municipality_select.php';
                                }
                                ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3 col-12">
                            <div class="form-group">
                              <label for="address-ward-column">Permanent Address Ward</label>
                              <input type="number" id="address-ward-column" name="permanent_ward" class="form-control" placeholder="Ward Number" name="address-ward-column" value="<?php echo $wadaMemberPermanentWard ?>" data-parsley-required="true" data-parsley-error-message="Ward is required.">
                            </div>
                          </div>
                          <div class="col-md-3 col-12">
                            <div class="form-group">
                              <label for="address-province-column">Temporary Address Province</label>
                              <select class="form-select" id="temporary_province" name="temporary_province" onclick="province_select('temporary_province', 'temporary_district', 'temporary_municipality')" data-parsley-required="true" data-parsley-error-message="Province is required.">
                                <option value="none" disabled selected>Select Province</option>
                                <?php
                                if ($_SESSION['wadaMemberID'] == 0) {
                                  echo "<option value='koshi'>Koshi Pradesh</option>";
                                  echo "<option value='madhesh'>Madhesh Pradesh</option>";
                                  echo "<option value='bagmati'>Bagmati Pradesh</option>";
                                  echo "<option value='gandaki'>Gandaki Pradesh</option>";
                                  echo "<option value='lumbini'>Lumbini Pradesh</option>";
                                  echo "<option value='karnali'>Karnali Pradesh</option>";
                                  echo "<option value='sudhur_paschim'>Sudurpaschim Pradesh</option>";
                                } else {
                                  require_once '../php/address_handler/temporary_address_province_select.php';
                                }
                                ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3 col-12">
                            <div class="form-group">
                              <label for="address-district-column">Temporary Address District</label>
                              <select class="form-select" id="temporary_district" name="temporary_district" onclick="district_select('temporary_district', 'temporary_municipality')" data-parsley-required="true" data-parsley-error-message="District is required.">
                                <option value="none" disabled selected>Select District</option>
                                <?php
                                if (!($_SESSION['wadaMemberID'] == 0)) {
                                  require_once '../php/address_handler/temporary_address_district_select.php';
                                }
                                ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3 col-12">
                            <div class="form-group">
                              <label for="address-municipality-column">Temporary Address Municipality</label>
                              <select class="form-select" id="temporary_municipality" name="temporary_municipality" data-parsley-required="true" data-parsley-error-message="Municipality is required.">
                                <option value="none" disabled selected>Select Municipality</option>
                                <?php
                                if (!($_SESSION['wadaMemberID'] == 0)) {
                                  require_once '../php/address_handler/temporary_address_municipality_select.php';
                                }
                                ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3 col-12">
                            <div class="form-group">
                              <label for="address-ward-column">Temporary Address Ward</label>
                              <input type="number" id="address-ward-column" name="temporary_ward" class="form-control" placeholder="Ward Number" name="address-ward-column" value="<?php echo $wadaMemberTemperoryWard ?>" data-parsley-required="true" data-parsley-error-message="Ward is required.">
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
                      <h4 class="card-title">Documents</h4>
                    </div>
                    <div class="card-content">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-4 col-12">
                            <div class="form-group">
                              <label for="profile-image">Profile Image</label><br>
                              <?php
                              if ($wadaMemberDocumentTypeProfilePicture != '') {
                                echo "<img src='../$wadaMemberDocumentTypeProfilePicture' alt='Profile Picture' class='img-thumbnail'>";
                              } else {
                                echo "<input type='file' name='profile_image' class='image-crop-filepond' image-crop-aspect-ratio='1:1'>";
                              }
                              ?>
                            </div>
                          </div>
                          <div class="col-md-4 col-12">
                            <div class="form-group">
                              <label for="citizenship-image">Citizenship Card</label><br>
                              <?php
                              if ($wadaMemberDocumentTypeCitizenshipCard != '') {
                                echo "<img src='../$wadaMemberDocumentTypeCitizenshipCard' alt='Citizenship Card' class='img-thumbnail'>";
                              } else {
                                echo "<input type='file' name='citizenship_image' class='image-preview-filepond'>";
                              }
                              ?>
                            </div>
                          </div>
                          <div class="col-md-4 col-12">
                            <div class="form-group">
                              <label for="signature-image">Signature</label><br>
                              <?php
                              if ($wadaMemberDocumentTypeSignature != '') {
                                echo "<img src='../$wadaMemberDocumentTypeSignature' alt='Signature' class='img-thumbnail'>";
                              } else {
                                echo "<input type='file' name='signature_image' class='image-filter-filepond'>";
                              }
                              ?>
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
                      <h4>Control Buttons</h4>
                    </div>
                    <div class="card-body">
                      <div class="buttons">
                        <button type="submit" class="btn icon icon-left btn-primary"><i data-feather="save"></i>Save</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </section>
        </form>
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
  <script src="../assets/static/js/components/dark.js"></script>
  <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>

  <script src="../assets/compiled/js/app.js"></script>

  <script src="../assets/extensions/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js"></script>
  <script src="../assets/extensions/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js"></script>
  <script src="../assets/extensions/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js"></script>
  <script src="../assets/extensions/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js"></script>
  <script src="../assets/extensions/filepond-plugin-image-filter/filepond-plugin-image-filter.min.js"></script>
  <script src="../assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js"></script>
  <script src="../assets/extensions/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js"></script>
  <script src="../assets/extensions/filepond/filepond.js"></script>
  <script src="../assets/extensions/toastify-js/src/toastify.js"></script>
  <script src="../assets/static/js/pages/filepond.js"></script>

  <script src="../assets/extensions/jquery/jquery.min.js"></script>
  <script src="../assets/extensions/nepalidatepicker/js/nepali-date-picker.min.js"></script>
  <script src="../assets/compiled/js/maritalStatus.js"></script>

  <script src="../assets/extensions/parsleyjs/parsley.min.js"></script>
  <script src="../assets/static/js/pages/parsley.js"></script>

  <script>
    $(document).ready(function() {
      $('.date-picker').nepaliDatePicker({
        dateFormat: 'YYYY-MM-DD',
        closeOnDateSelect: true
      });
    });
  </script>
</body>

</html>