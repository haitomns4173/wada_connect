<?php

require_once 'database_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['fname-column']) && isset($_POST['lname-column']) && isset($_POST['dob-bs-column']) && isset($_POST['gender-column']) && isset($_POST['phone-number-column'])) {

        if (!preg_match("/^[a-zA-Z]*$/", $_POST['fname-column']) || !preg_match("/^[a-zA-Z]*$/", $_POST['lname-column'])) {
            echo "Only letters are allowed in First name and Last name.";
        } else {
            $first_name = $_POST['fname-column'];
            $last_name = $_POST['lname-column'];
        }

        if (isset($_POST['mname-column'])) {
            if (!empty($_POST['mname-column']) && !preg_match("/^[a-zA-Z]*$/", $_POST['mname-column'])) {
                echo "Only letters are allowed in Middle name.";
            } else {
                $middle_name = $_POST['mname-column'];
            }
        } else {
            $middle_name = "";
        }

        $date_of_birth = $_POST['dob-bs-column'];
        $gender = $_POST['gender-column'];

        if (!empty($_POST['phone-number-column']) && !preg_match("/^[0-9]*$/", $_POST['phone-number-column']) && strlen($_POST['phone-number-column']) == 10) {
            echo "Only a valid 10 digit number is allowed in Phone number.";
        } else {
            $phone_number = $_POST['phone-number-column'];
        }
    } else {
        echo "First name, Last name, Date of birth, Gender, and Phone number are required fields.";
    }

    if (isset($_POST['fname-column-np']) && isset($_POST['mname-column-np']) && isset($_POST['lname-column-np'])) {
        if (!preg_match("/^[\x{0900}-\x{097F}\s]+$/u", $_POST['fname-column-np']) || !preg_match("/^[\x{0900}-\x{097F}\s]+$/u", $_POST['lname-column-np'])) {
            echo "Only Nepali characters are allowed in First name and Last name.";
        } else {
            $first_name_np = $_POST['fname-column-np'];
            $last_name_np = $_POST['lname-column-np'];
        }

        if (isset($_POST['mname-column-np'])) {
            if (!empty($_POST['mname-column-np']) && !preg_match("/^[\x{0900}-\x{097F}\s]+$/u", $_POST['mname-column-np'])) {
                echo "Only Nepali characters are allowed in Middle name.";
            } else {
                $middle_name_np = $_POST['mname-column-np'];
            }
        } else {
            $middle_name_np = "";
        }
    } else {
        echo "Nepali First name and Nepali Last name in Nepali are required fields.";
    }

    if (isset($_POST['fathers-name-column']) && isset($_POST['marital-status-column'])) {
        if (!empty($_POST['fathers-name-column']) && !preg_match("/^[a-zA-Z ]*$/", $_POST['fathers-name-column'])) {
            echo "Only letters and spaces are allowed in Father's name.";
        } else {
            $father_name = $_POST['fathers-name-column'];
        }

        if (isset($_POST['mothers-name-column'])) {
            if (!empty($_POST['mothers-name-column']) && !preg_match("/^[a-zA-Z ]*$/", $_POST['mothers-name-column'])) {
                echo "Only letters are allowed in Mother's name.";
            } else {
                $mother_name = $_POST['mothers-name-column'];
            }
        } else {
            $mother_name = "";
        }

        if (isset($_POST['grandfathers-name-column'])) {
            if (!empty($_POST['grandfathers-name-column']) && !preg_match("/^[a-zA-Z ]*$/", $_POST['grandfathers-name-column'])) {
                echo "Only letters are allowed in Grandfather's name.";
            } else {
                $grandfather_name = $_POST['grandfathers-name-column'];
            }
        } else {
            $grandfather_name = "";
        }

        if (isset($_POST['spouse-name-column'])) {
            if (!empty($_POST['spouse-name-column']) && !preg_match("/^[a-zA-Z ]*$/", $_POST['spouse-name-column'])) {
                echo "Only letters are allowed in Spouse's name.";
            } else {
                $spouse_name = $_POST['spouse-name-column'];
            }
        } else {
            $spouse_name = "";
        }

        if (isset($_POST['children-column'])) {
            if (!empty($_POST['children-column']) && !preg_match("/^[0-9]*$/", $_POST['children-column'])) {
                echo "Only numbers are allowed in Children.";
            } else {
                $children = $_POST['children-column'];
            }
        } else {
            $children = "";
        }

        $marital_status = $_POST['marital-status-column'];
        if ($marital_status == "unmarried" && (!empty($spouse_name) || !empty($children))) {
            $spouse_name = "";
            $children = "";
        } else {
            if ($marital_status == "married" && (empty($spouse_name) || empty($children))) {
                echo "Spouse name and Children should not be empty if marital status is Married.";
            }
        }
    } else {
        echo "Father's name and Marital status are required fields.";
    }

    if (isset($_POST['fathers-name-column-np'])) {
        if (!empty($_POST['fathers-name-column-np']) && !preg_match("/^[\x{0900}-\x{097F}\s]+$/u", $_POST['fathers-name-column-np'])) {
            echo "Only Nepali characters and spaces are allowed in Father's name.";
        } else {
            $father_name_np = $_POST['fathers-name-column-np'];
        }

        if (isset($_POST['mothers-name-column-np'])) {
            if (!empty($_POST['mothers-name-column-np']) && !preg_match("/^[\x{0900}-\x{097F}\s]+$/u", $_POST['mothers-name-column-np'])) {
                echo "Only Nepali characters are allowed in Mother's name.";
            } else {
                $mother_name_np = $_POST['mothers-name-column-np'];
            }
        } else {
            $mother_name_np = "";
        }

        if (isset($_POST['grandfathers-name-column-np'])) {
            if (!empty($_POST['grandfathers-name-column-np']) && !preg_match("/^[\x{0900}-\x{097F}\s]+$/u", $_POST['grandfathers-name-column-np'])) {
                echo "Only Nepali characters are allowed in Grandfather's name.";
            } else {
                $grandfather_name_np = $_POST['grandfathers-name-column-np'];
            }
        } else {
            $grandfather_name_np = "";
        }

        if (isset($_POST['spouse-name-column-np'])) {
            if (!empty($_POST['spouse-name-column-np']) && !preg_match("/^[\x{0900}-\x{097F}\s]+$/u", $_POST['spouse-name-column-np'])) {
                echo "Only Nepali characters are allowed in Spouse's name.";
            } else {
                $spouse_name_np = $_POST['spouse-name-column-np'];
            }
        } else {
            $spouse_name_np = "";
        }
    } else {
        echo "Father's name in Nepali is required.";
    }

    if (isset($_POST['citizenship-number-column']) && isset($_POST['citizenship-issued-date-column']) && isset($_POST['citizenship-issued-district-column'])) {
        $citizenship_number = $_POST['citizenship-number-column'];
        $citizenship_issued_date = $_POST['citizenship-issued-date-column'];
        $citizenship_issued_district = $_POST['citizenship-issued-district-column'];
    } else {
        echo "Citizenship number, Citizenship issued date, and Citizenship issued district are required fields.";
    }

    if (isset($_POST['permanent_province']) && isset($_POST['permanent_district']) && isset($_POST['permanent_municipality']) && isset($_POST['permanent_ward'])) {
        $permanent_address_province = $_POST['permanent_province'];
        $permanent_address_district = $_POST['permanent_district'];
        $permanent_address_municipality = $_POST['permanent_municipality'];
        $permanent_address_ward = $_POST['permanent_ward'];
    } else {
        echo "Permanent address is required.";
    }

    if (isset($_POST['temporary_province']) && isset($_POST['temporary_district']) && isset($_POST['temporary_municipality']) && isset($_POST['temporary_ward'])) {
        $temporary_address_province = $_POST['temporary_province'];
        $temporary_address_district = $_POST['temporary_district'];
        $temporary_address_municipality = $_POST['temporary_municipality'];
        $temporary_address_ward = $_POST['temporary_ward'];
    } else {
        echo "Temporary address is required.";
    }

    if (isset($_FILES["profile_image"]) && isset($_FILES["citizenship_image"]) && isset($_FILES["signature_image"])) {
        if ($_FILES["profile_image"]["error"] == 4 || $_FILES["citizenship_image"]["error"] == 4 || $_FILES["signature_image"]["error"] == 4) {
            echo "Profile Image, Citizenship Card, and Signature are required.";
        }
    } else {
        echo "Profile Image, Citizenship Card, and Signature are required.";
    }

    session_start();
    if (isset($_SESSION['wadaMemberUserLoginID'])) {
        $wada_member_login_id = $_SESSION['wadaMemberUserLoginID'];
    } else {
        echo "Session not set";
    }

    $mysqli = db_connect();

    if ($mysqli) {
        $stmt = $mysqli->prepare("INSERT INTO `wadamemberpersonaldetails`(`wadaMemberID`, `wadaMemberUserLoginID`, `wadaMemberType`, `wadaMemberFirstName`, `wadaMemberMiddleName`, `wadaMemberLastName`, `wadaMemberDateOfBirth`, `wadaMemberGender`, `wadaMemberPhoneNo`, `wadaMemberCreationDateTime`) VALUES (NULL, ?, '3', ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");
        $stmt->bind_param("sssssss", $wada_member_login_id, $first_name, $middle_name, $last_name, $date_of_birth, $gender, $phone_number);
        $stmt->execute();
        $stmt->close();

        $wada_member_id = $mysqli->insert_id;
        $_SESSION['wadaMemberID'] = $wada_member_id;

        $stmt = $mysqli->prepare("INSERT INTO `wadamemberfamilydetails`(`wadaMemberFamilyDetailsID`, `wadaMemberFatherName`, `wadaMemberMotherName`, `wadaMemberGrandFatherName`, `wadaMemberMaritalStatus`, `wadaMemberSpouseName`, `wadaMemberNumberOfChildern`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $wada_member_id, $father_name, $mother_name, $grandfather_name, $marital_status, $spouse_name, $children);
        $stmt->execute();
        $stmt->close();

        $stmt = $mysqli->prepare("INSERT INTO `wadamembercitizenshipdetails`(`wadaMemberCitizenshipDetailsID`, `wadaMemberCitizenshipNumber`, `wadaMemberCitizenshipIssuedDate`, `wadaMemberCitizenshipIssuedDistrict`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $wada_member_id, $citizenship_number, $citizenship_issued_date, $citizenship_issued_district);
        $stmt->execute();
        $stmt->close();

        $stmt = $mysqli->prepare("INSERT INTO `wadamemberaddressdetails`(`wadaMemberAddressDetailsID`, `wadaMemberPermanentProvince`, `wadaMemberPermanentDistrict`, `wadaMemberPermanentMunicipality`, `wadaMemberPermanentWard`, `wadaMemberTemperoryProvince`, `wadaMemberTemperoryDistrict`, `wadaMemberTemperoryMunicipality`, `wadaMemberTemperoryWard`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $wada_member_id, $permanent_address_province, $permanent_address_district, $permanent_address_municipality, $permanent_address_ward, $temporary_address_province, $temporary_address_district, $temporary_address_municipality, $temporary_address_ward);
        $stmt->execute();
        $stmt->close();

        $stmt = $mysqli->prepare("INSERT INTO `wadamembernepalidetails`(`wadaMemberNepaliDetailsID`, `wadaMemberFirstNameNP`, `wadaMemberMiddleNameNP`, `wadaMemberLastNameNP`, `wadaMemberFathersNameNP`, `wadaMemberMothersNameNP`, `wadaMemberGrandFatherNameNP`, `wadaMemberSpouseNameNP`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $wada_member_id, $first_name_np, $middle_name_np, $last_name_np, $father_name_np, $mother_name_np, $grandfather_name_np, $spouse_name_np);
        $stmt->execute();
        $stmt->close();

        $main_folder = '../wadaMemberDocuments/';
        $profile_folder = $main_folder . 'profilePictures/';
        $citizenship_folder = $main_folder . 'citizenshipCards/';
        $signature_folder = $main_folder . 'signatures/';

        if (!file_exists($profile_folder)) {
            mkdir($profile_folder, 0755, true);
        }
        if (!file_exists($citizenship_folder)) {
            mkdir($citizenship_folder, 0755, true);
        }
        if (!file_exists($signature_folder)) {
            mkdir($signature_folder, 0755, true);
        }

        $maxFileSize = 1000 * 1024;

        function generateFileName($fileName, $type, $first_name, $middle_name, $last_name, $wada_member_id)
        {
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $baseFileName = "{$first_name}_{$middle_name}_{$last_name}_{$wada_member_id}_{$type}_" . uniqid();
            return "{$baseFileName}.{$fileExtension}";
        }

        function uploadFile($file, $folder, $maxFileSize, $type, $first_name, $middle_name, $last_name, $wada_member_id)
        {
            $validImageTypes = ['image/jpeg', 'image/png'];
            $fileMimeType = mime_content_type($file['tmp_name']);
        
            if (!in_array($fileMimeType, $validImageTypes)) {
                echo "Only JPG, PNG, and GIF image files are allowed.";
                return false;
            }
        
            if ($file['size'] > $maxFileSize) {
                echo "File size exceeds the limit of 500 KB.";
                return false;
            }
        
            $uniqueFileName = generateFileName($file["name"], $type, $first_name, $middle_name, $last_name, $wada_member_id);
            $target_file = $folder . $uniqueFileName;
        
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                return $target_file;
            } else {
                return false;
            }
        }
        

        if (!empty($_FILES["profile_image"]["name"])) {
            $profile_image_path = uploadFile($_FILES["profile_image"], $profile_folder, $maxFileSize, 'ProfilePicture', $first_name, $middle_name, $last_name, $wada_member_id);
            if (!$profile_image_path) {
                echo "Failed to upload Profile Image.";
                exit;
            }
        }

        if (!empty($_FILES["citizenship_image"]["name"])) {
            $citizenship_image_path = uploadFile($_FILES["citizenship_image"], $citizenship_folder, $maxFileSize, 'CitizenshipCard', $first_name, $middle_name, $last_name, $wada_member_id);
            if (!$citizenship_image_path) {
                echo "Failed to upload Citizenship Card.";
                exit;
            }
        }

        if (!empty($_FILES["signature_image"]["name"])) {
            $signature_image_path = uploadFile($_FILES["signature_image"], $signature_folder, $maxFileSize, 'Signature', $first_name, $middle_name, $last_name, $wada_member_id);
            if (!$signature_image_path) {
                echo "Failed to upload Signature.";
                exit;
            }
        }

        $profile_image_path = substr($profile_image_path, 3);
        $citizenship_image_path = substr($citizenship_image_path, 3);
        $signature_image_path = substr($signature_image_path, 3);

        $stmt = $mysqli->prepare("INSERT INTO `wadamembersdocumentdetails`(`wadaMemberDocumentDetailsID`, `wadaMemberDocumentTypeProfilePicture`, `wadaMemberDocumentTypeCitizenshipCard`, `wadaMemberDocumentTypeSignature`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $wada_member_id, $profile_image_path, $citizenship_image_path, $signature_image_path);
        $stmt->execute();
        $stmt->close();

        echo "Files have been uploaded successfully.";

        echo "Wada Member details inserted successfully.";
    } else {
        echo "Database connection failed.";
    }

    db_close($mysqli);
} else {
    echo "Invalid request method. Please use POST.";
}