<?php

    $mysqli = db_connect();

    if(isset($_SESSION['wadaMemberID']) && $_SESSION['wadaMemberID'] != 0){
        $wadaMemberUserLoginID = $_SESSION['wadaMemberID'];
        $stmt = $mysqli->prepare("SELECT * FROM wadamemberpersonaldetails INNER JOIN wadamemberfamilydetails on wadaMemberID = wadaMemberFamilyDetailsID INNER JOIN wadamembernepalidetails ON wadaMemberID = wadaMemberNepaliDetailsID INNER JOIN wadamembercitizenshipdetails ON wadaMemberID=wadaMemberCitizenshipDetailsID INNER JOIN wadamemberaddressdetails ON wadaMemberID = wadaMemberAddressDetailsID INNER JOIN wadamembersdocumentdetails ON wadaMemberID = wadaMemberDocumentDetailsID WHERE wadaMemberID = ?");
        $stmt->bind_param('i', $wadaMemberUserLoginID);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result( $wadaMemberID, $wadaMemberUserLoginID, $wadaMemberType, $wadaMemberFirstName,$wadaMemberMiddleName, 
                            $wadaMemberLastName, $wadaMemberDateOfBirth, $wadaMemberGender,$wadaMemberPhoneNo, 
                            $wadaMemberCreatingDateTime, $wadaMemberFamilyDetailsID, $wadaMemberFatherName, 
                            $wadaMemberMotherName, $wadaMemberGrandFatherName, $wadaMemberMaritalStatus, $wadaMemberSpouseName, 
                            $wadaMemberNumberOfChildern, $wadaMemberNepaliDetailsID, $wadaMemberFirstNameNP, $wadaMemberMiddleNameNP, 
                            $wadaMemberLastNameNP, $wadaMemberFatherNameNP, $wadaMemberMotherNameNP, $wadaMemberGrandFatherNameNP, 
                            $wadaMemberSpouseNameNP, $wadaMemberCitizenshipDetailsID, $wadaMemberCitizenshipNumber, 
                            $wadaMemberCitizenshipIssuedDate, $wadaMemberCitizenshipIssuedDistrict, $wadaMemberAddressDetailsID, 
                            $wadaMemberPermanentProvince, $wadaMemberPermanentDistrict, $wadaMemberPermanentMunicipality, 
                            $wadaMemberPermanentWard, $wadaMemberTemperoryProvince, $wadaMemberTemperoryDistrict, 
                            $wadaMemberTemperoryMunicipality, $wadaMemberTemperoryWard, $wadaMemberDocumentDetailsID, 
                            $wadaMemberDocumentTypeProfilePicture, $wadaMemberDocumentTypeCitizenshipCard, $wadaMemberDocumentTypeSignature
                        );

        $stmt->fetch();
        $stmt->close();
        
        if($wadaMemberMiddleName == "" || $wadaMemberMiddleNameNP == ""){
            $wadaMemberMiddleNameNP = " ";
        }
    }
    else{
        $wadaMemberID = $wadaMemberUserLoginID = $wadaMemberType = $wadaMemberFirstName = $wadaMemberMiddleName = $wadaMemberLastName = $wadaMemberDateOfBirth = $wadaMemberGender = $wadaMemberPhoneNo = $wadaMemberCreatingDateTime = $wadaMemberFamilyDetailsID = $wadaMemberFatherName = $wadaMemberMotherName = $wadaMemberGrandFatherName = $wadaMemberMaritalStatus = $wadaMemberSpouseName = $wadaMemberNumberOfChildern = $wadaMemberNepaliDetailsID = $wadaMemberFirstNameNP = $wadaMemberMiddleNameNP = $wadaMemberLastNameNP = $wadaMemberFatherNameNP =$wadaMemberMotherNameNP = $wadaMemberGrandFatherNameNP = $wadaMemberSpouseNameNP = $wadaMemberCitizenshipDetailsID = $wadaMemberCitizenshipNumber = $wadaMemberCitizenshipIssuedDate = $wadaMemberCitizenshipIssuedDistrict = $wadaMemberAddressDetailsID = $wadaMemberPermanentProvince = $wadaMemberPermanentDistrict = $wadaMemberPermanentMunicipality = $wadaMemberPermanentWard = $wadaMemberTemperoryProvince = $wadaMemberTemperoryDistrict = $wadaMemberTemperoryMunicipality = $wadaMemberTemperoryWard = $wadaMemberDocumentDetailsID = $wadaMemberDocumentTypeProfilePicture = $wadaMemberDocumentTypeCitizenshipCard = $wadaMemberDocumentTypeSignature = "";
    }
    db_close($mysqli);
?>