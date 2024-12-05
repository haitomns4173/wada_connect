<?php
require_once 'database_connection.php';

$wadaOfficeProvinceID = 0;
$wadaOfficeDistrictID = 0;

function generateWadaOfficeProvinceOptions($provinceName)
{
  $mysqli = db_connect();
  $stmt = $mysqli->prepare("SELECT `provinceNepalID`, `provinceEnglishName` FROM `wadaconnectprovincenepal`;");
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($provinceNepalID, $provinceEnglishName);

  while ($stmt->fetch()) {
    $lowerProvinceEnglishName = strtolower($provinceEnglishName);
    if ($provinceEnglishName == $provinceName) {
      $GLOBALS['wadaOfficeProvinceID'] = $provinceNepalID;
      echo "<option value='$lowerProvinceEnglishName' selected>$provinceEnglishName Pradesh</option>";
    } else {
      echo "<option value='$lowerProvinceEnglishName'>$provinceEnglishName Pradesh</option>";
    }
  }

  $stmt->close();

  db_close($mysqli);
}

function generateWadaOfficeDistrictOptions($districtName)
{
  $mysqli = db_connect();
  $stmt = $mysqli->prepare("SELECT `districtNepalID`, `districtEnglishName` FROM `wadaconnectdistrictnepal` WHERE `provinceDistrictNepalID` = ?;");
  $stmt->bind_param("i", $GLOBALS['wadaOfficeProvinceID']);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($districtNepalID, $districtEnglishName);

  while ($stmt->fetch()) {
    if ($districtEnglishName == $districtName) {
      $GLOBALS['wadaOfficeDistrictID'] = $districtNepalID;
      echo "<option value='$districtEnglishName' selected>$districtEnglishName</option>";
    } else {
      echo "<option value='$districtEnglishName'>$districtEnglishName</option>";
    }
  }

  $stmt->close();

  db_close($mysqli);
}

function generateWadaOfficeMunicipalityOptions($municipalityName)
{
  $mysqli = db_connect();
  $stmt = $mysqli->prepare("SELECT `localLevelNepalID`, `localLevelEnglishName` FROM `wadaconnectlocallevelnepal` WHERE `localLevelDistrictID` = ?");
  $stmt->bind_param("i", $GLOBALS['wadaOfficeDistrictID']);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($localLevelNepalID, $localLevelEnglishName);

  while ($stmt->fetch()) {
    if ($localLevelEnglishName == $municipalityName) {
      echo "<option value='$localLevelEnglishName' selected>$localLevelEnglishName</option>";
    } else {
      echo "<option value='$localLevelEnglishName'>$localLevelEnglishName</option>";
    }
  }

  $stmt->close();

  db_close($mysqli);
}

function generateWadaOfficeMunicipalityTypeOptions($municipalityType)
{
  $municipalityTypes = array('Metropolitan', 'Sub-Metropolitan', 'Municipality');
  foreach ($municipalityTypes as $municipalityTypesData) {
    if ($municipalityTypesData == $municipalityType) {
      echo "<option value='$municipalityTypesData' selected>$municipalityTypesData</option>";
    } else {
      echo "<option value='$municipalityTypesData'>$municipalityTypesData</option>";
    }
  }
}