<?php
session_start();
require '../../vendor/autoload.php';

include '../connectDB.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

//EXPORT FILE

if (isset($_POST['export_excel_btn'])) {
    $file_ext_name = $_POST['export_file_type'];
    $filename = 'user_sheet';

    $sql = $conn->prepare("SELECT * FROM user");
    $sql->execute();
    $count = $sql->rowCount();
    if ($count > 0) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'id');
        $sheet->setCellValue('B1', 'firstname');
        $sheet->setCellValue('C1', 'lastname');
        $sheet->setCellValue('D1', 'email');

        $rowCount = 2; //lấy 2 hàng đầu 
        foreach ($sql as $data) {
            $sheet->setCellValue('A' . $rowCount, $data['id']);
            $sheet->setCellValue('B' . $rowCount, $data['firstname']);
            $sheet->setCellValue('C' . $rowCount, $data['lastname']);
            $sheet->setCellValue('D' . $rowCount, $data['email']);
            $rowCount++;
        }

        if ($file_ext_name == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
            $final_filename = $filename . '.xlsx';
        } elseif ($file_ext_name == 'xls') {
            $writer = new Xls($spreadsheet);
            $final_filename = $filename . '.xls';
        } elseif ($file_ext_name == 'csv') {
            $writer = new Csv($spreadsheet);
            $final_filename = $filename . '.csv';
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.speardsheetml.sheet');
        header('Content-Disposition: attacment; filename="' . urldecode($final_filename) . '" ');
        $writer->save('php://output');
    } else {
        $_SESSION['message'] = "Không tìm thấy file";
        header('location: publisher.php');
        exit(0);
    }
} else {
    header('location:user.php');
}
?>