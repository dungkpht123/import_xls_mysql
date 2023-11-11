<?php
session_start();
include('dbconfig.php');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if(isset($_POST['save_excel_data']))
{
    $fileName = $_FILES['import_file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowed_ext = ['xls','csv','xlsx'];

    if(in_array($file_ext, $allowed_ext))
    {
        $inputFileNamePath = $_FILES['import_file']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
        $data = $spreadsheet->getActiveSheet()->toArray();

        $count = "0";
        foreach($data as $row)
        {
            if($count > 0)
            {
                $MaTram = $row['0'];
                $TenTram = $row['1'];
                $DiaChi = $row['2'];
                $Quan = $row['3'];
                $ViDo = $row['4'];
                $KinhDo = $row['5'];
             
                $ParkingQuery = "INSERT INTO parking (MaTram,TenTram,DiaChi,Quan,ViDo,KinhDo) VALUES ('$MaTram','$TenTram','$DiaChi','$Quan','$ViDo','$KinhDo')";
                $result = mysqli_query($con, $ParkingQuery);
                $msg = true;
            }
            else
            {
                $count = "1";
            }
        }

        if(isset($msg))
        {
            $_SESSION['message'] = "Successfully Imported";
            header('Location: index.php');
            exit(0);
        }
        else
        {
            $_SESSION['message'] = "Not Imported";
            header('Location: index.php');
            exit(0);
        }
    }
    else
    {
        $_SESSION['message'] = "Invalid File";
        header('Location: index.php');
        exit(0);
    }
}
?>