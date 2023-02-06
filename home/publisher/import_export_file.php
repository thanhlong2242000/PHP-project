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
    $filename = 'publisher_sheet';

    $sql1 = $conn->prepare("SELECT * FROM publisher");
    $sql1->execute();
    $count = $sql1->rowCount();
    if ($count > 0) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'id');
        $sheet->setCellValue('B1', 'name_publisher');
        $sheet->setCellValue('C1', 'url_publisher');
        $sheet->setCellValue('D1', 'crawled');
        $sheet->setCellValue('E1', 'created_date');
        $sheet->setCellValue('F1', 'modified_date');

        $rowCount = 2; //lấy 2 hàng đầu 
        foreach ($sql1 as $data) {
            $sheet->setCellValue('A' . $rowCount, $data['id']);
            $sheet->setCellValue('B' . $rowCount, $data['name_publisher']);
            $sheet->setCellValue('C' . $rowCount, $data['url_publisher']);
            $sheet->setCellValue('D' . $rowCount, $data['crawled']);
            $sheet->setCellValue('E' . $rowCount, $data['created_date']);
            $sheet->setCellValue('F' . $rowCount, $data['modified_date']);
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
        $_SESSION['message'] = "không tìm thấy file";
        header('location: publisher.php');
        exit(0);
    }
}

//IMPORT FILE
if ($_SESSION['role'] != 0) {
    if (isset($_POST['save_excel_data'])) {
        $filename = $_FILES['import_file']['name'];
        $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
        $allowed_ext = ['xls', 'csv', 'xlsx'];
        if (in_array($file_ext, $allowed_ext)) {
            $inputFileNamePath = $_FILES['import_file']['tmp_name'];
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
            $data = $spreadsheet->getActiveSheet()->toArray();
            $count = "0";
            $flag = true;
            $countrow = "0";
            foreach ($data as $row) {
                $countrow = $countrow + 1;
                for ($col = 0; $col < 3; $col++) {
                    $column = $col + 1;
                    if ($row[$col] == NULL) {
                        $a = $a . "<br>" . "Hàng: " . "$countrow" . " Cột: " . "$column";
                        header('location: publisher.php');
                        $flag = false;
                    }
                }
            }

            $_SESSION['message_error_import'] = $a;

            if ($flag == true) {
                foreach ($data as $row) {
                    if ($count > 0) { 
                        $name_publisher = $row['0'];
                        $url_publisher = $row['1'];
                        $crawled = $row['2'];
                        $created_date = gmdate("Y-m-d H:i:s");
                        $modified_date = gmdate("Y-m-d H:i:s");

                        $sql = "INSERT INTO publisher (name_publisher, url_publisher, crawled, created_date, modified_date ) VALUES (?, ?, ?, ?, ?)";
                        $sql_run = $conn->prepare($sql);
                        $sql_run->execute([$name_publisher, $url_publisher, $crawled, $created_date, $modified_date]);
                        $_SESSION['import-publisher'] = "Import File thành công!";
                        header('location: publisher.php');
                    } else {
                        $count = "1";
                    }

                }
            }
        } else {
            $_SESSION['file_error'] = "File không hợp lệ";
            header('location: publisher.php');
            exit(0);
        }
    }
} else {
    header('location:publisher.php');
}
?>