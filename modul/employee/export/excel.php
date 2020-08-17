<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../../../connect/connect_mysql.php";
require_once "../../../vendors/Classes/PHPExcel.php";

$excel = new PHPExcel();
$excel -> setActiveSheetIndex(0);

$sql = "SELECT * FROM employee";
$result_emp = $db->query($sql);
$num = 2;
while( $data = mysqli_fetch_object($result_emp) ){
         $excel->getActiveSheet()
         ->setCellValue('A'.$num , $data->EmployeeId )
         ->setCellValue('B'.$num , $data->EmployeeName )
         ->setCellValue('C'.$num , $data->EmployeeAddress )
         ->setCellValue('D'.$num , $data->EmployeeDepartment );
         $num++;
}

$excel -> getActiveSheet()->getColumnDimension('A')->setWidth(10);
$excel -> getActiveSheet()->getColumnDimension('B')->setWidth(30);
$excel -> getActiveSheet()->getColumnDimension('C')->setWidth(50);
$excel -> getActiveSheet()->getColumnDimension('D')->setWidth(30);

		$excel->getActiveSheet()
				-> setCellValue('A1' , 'ID')
				-> setCellValue('B1' , 'Name')
				-> setCellValue('C1' , 'Address')
				-> setCellValue('D1' , 'Department');

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Employee.xlsx"');
header('Cache-control: max-age=0');

$file = PHPExcel_IOFactory::createWriter($excel,'Excel2007');
$file -> save('php://output');

?>
