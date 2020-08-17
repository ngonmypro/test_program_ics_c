<?php include "../../../connect/connect_mysql.php";
require_once "../../../vendors/Classes/PHPExcel.php";
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Asia/Bangkok'); //set timezone ให้ตรงกับประเทศไทย

$Y = date("Y");
  $m = date("m");
  $d = date("d");
  $H = date("H");
  $i = date("i");
  $s = date("s");
  $date = $Y.$m.$d.'_'.$H.$i.$s;
  $target_dir = "../uploads/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
  rename ($target_dir . basename( $_FILES["fileToUpload"]["name"]), $target_dir . 'Employee_import_'.$date . '.' . $imageFileType);
  $target_file_n = $target_dir.'Employee_import_'.$date . '.' . $imageFileType;
  //echo $target_file_n;
  } else {
    unlink($target_file_n);
    $type = 'N';
  }

    $tmpfname = $target_file_n;
    $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
		$excelObj = $excelReader->load($tmpfname);
		$worksheet = $excelObj->getSheet(0);
		$lastRow = $worksheet->getHighestRow();

    if (isset($lastRow)) {
		    for ($row = 2; $row <= $lastRow; $row++) {
			    $id = $worksheet->getCell('A'.$row)->getValue();
      	  $name = $worksheet->getCell('B'.$row)->getValue();
			    $address = $worksheet->getCell('C'.$row)->getValue();
			    $depratment = $worksheet->getCell('D'.$row)->getValue();

      $sql_se = "SELECT * FROM employee WHERE EmployeeName = '".$name."' AND EmployeeAddress = '".$address."' AND EmployeeDepartment = '".$depratment."'";
      $result_se = $db->query($sql_se);
        if (mysqli_num_rows($result_se) == 0) {
          $sql = "INSERT INTO employee (EmployeeName, EmployeeAddress, EmployeeDepartment) VALUES ('".$name."','".$address."','".$depratment."')";
          $result_in = $db->query($sql);
          $type = 'Y';
        }else {
          unlink($target_file_n);
          $type = "N";
        }
		   }
    }else {
      unlink($target_file_n);
      $type = 'N';
    }
    echo $type;
?>
