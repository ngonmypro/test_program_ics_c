<?php require($_SERVER['DOCUMENT_ROOT']."/icstest_B/vendors/phpmailer/PHPMailerAutoload.php");

header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Asia/Bangkok'); //set timezone ให้ตรงกับประเทศไทย
  $Y = date("Y");
  $m = date("m");
  $d = date("d");
  $H = date("H");
  $i = date("i");
  $s = date("s");
  $date = $Y.$m.$d.'_'.$H.$i.$s;
  $toemail = $_GET['email'];
	$target_dir = "../files/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	rename ($target_dir . basename( $_FILES["fileToUpload"]["name"]), $target_dir . 'Employee_'.$date . '.' . $imageFileType);
	$target_file_n = $target_dir.'Employee_'.$date . '.' . $imageFileType;
	} else {

	}

$mail = new PHPMailer;
$mail->CharSet = "utf-8";
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;


$gmail_username = "pongpichan.ns57@kru.ac.th"; // gmail ที่ใช้ส่ง
$gmail_password = "black0988738261"; // รหัสผ่าน gmail
// ตั้งค่าอนุญาตการใช้งานได้ที่นี่ https://myaccount.google.com/lesssecureapps?pli=1


$sender = "Ngon Test Sendmail"; // ชื่อผู้ส่ง
$email_sender = "noreply@ibsone.com"; // เมล์ผู้ส่ง
$email_receiver = $toemail; // เมล์ผู้รับ ***

$subject = "Send file to E-mail"; // หัวข้อเมล์

$mail->Username = $gmail_username;
$mail->Password = $gmail_password;
$mail->setFrom($email_sender, $sender);
$mail->addAddress($email_receiver);
$mail->addAttachment($target_file_n);
$mail->Subject = $subject;

$email_content = "
	<!DOCTYPE html>
	<html>
		<head>
			<meta charset=utf-8'/>
			<title>Send file to E-mail</title>
		</head>
		<body>
		<h1>File excel employee</h1>
		</body>
    <footer>
        Create by <a href='https://www.facebook.com/ngonblackdevil' target='_blank'>Pongpichan Niramitwasu.</a>
    </footer>
	</html>
";

//  ถ้ามี email ผู้รับ
if($email_receiver){
	$mail->msgHTML($email_content);


	if (!$mail->send()) {  // สั่งให้ส่ง email
		// กรณีส่ง email ไม่สำเร็จ
    unlink($target_file_n);
		echo $mail->ErrorInfo; // ข้อความ รายละเอียดการ error
	}else{
		// กรณีส่ง email สำเร็จ
		echo "Y";
	}
}



?>
