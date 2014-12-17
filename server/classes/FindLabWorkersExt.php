<?php

class FindLabWorkersExt {
    
 public static function ExcelCreate($data){
     
     global $Options;
 
    $stringDate = date('dmYHis');
    $filename = "LabWorkers".$stringDate.".xlsx";
  
    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();

    // Set document properties
    $objPHPExcel->getProperties()->setCreator("MyLab Administrator")
                                 ->setTitle("MyLab myLabWorkers xlsx")
                                 ->setSubject("Export myLabWorkers xlsx format")
                                 ->setDescription("First level xls data. Saved at server folder.");
    // Set format codes 
    $objPHPExcel->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);
    
    // Create a first sheet
    $objPHPExcel->getActiveSheet()->setCellValue('A1', "Κωδικός Β.Δ. Εργαζομενου");
    $objPHPExcel->getActiveSheet()->setCellValue('B1', "Αριθμός Μητρωου Εργαζομενου", PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValue('C1', "UID Εργαζομενου");
    $objPHPExcel->getActiveSheet()->setCellValue('D1', "Όνομα");
    $objPHPExcel->getActiveSheet()->setCellValue('E1', "Επίθετο");
    $objPHPExcel->getActiveSheet()->setCellValue('F1', "Όνομα Πατρός");
    $objPHPExcel->getActiveSheet()->setCellValue('G1', "Email");
    $objPHPExcel->getActiveSheet()->setCellValue('H1', "Ειδικότητα Εργαζόμενου");
    $objPHPExcel->getActiveSheet()->setCellValue('I1', "Πρωτογενής Πηγή");

//Loop throught data result of get api function
$i=2;
foreach($data["data"] as $worker_data)
{    
    // Set values from get api function to excell cells
    $objPHPExcel->getActiveSheet()->setCellValue("A$i", $worker_data["worker_id"]);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit("B$i", $worker_data["registry_no"], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->setCellValue("C$i", $worker_data["uid"]);
    $objPHPExcel->getActiveSheet()->setCellValue("D$i",  $worker_data["firstname"]);
    $objPHPExcel->getActiveSheet()->setCellValue("E$i", $worker_data["lastname"]);
    $objPHPExcel->getActiveSheet()->setCellValue("F$i", $worker_data["fathername"]);
    $objPHPExcel->getActiveSheet()->setCellValue("G$i", $worker_data["email"]);
    $objPHPExcel->getActiveSheet()->setCellValue("H$i", $worker_data["worker_specialization_name"]);
    $objPHPExcel->getActiveSheet()->setCellValue("I$i", $worker_data["worker_lab_source_name"]);
           
    $i++;
}

//    // Set auto size column width
//    foreach(range('A','I') as $columnID) {
//        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
//            ->setAutoSize(true);
//    }
     
//// Redirect output to a client’s web browser (Excel2007)
//    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//    header("Content-Disposition: attachment;filename=\"".$filename."\"");
//    header('Cache-Control: max-age=0');
//    // If you're serving to IE 9, then the following may be needed
//    header('Cache-Control: max-age=1');
//
//    // Save Excel 2007 file
//    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//    $objWriter->save('php://output');   

    // Save Excel 2007 file
    $file = $Options["TmpFolder"].$filename;
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//  $objWriter->save(str_replace('.php', '.xlsx', $file));
    $objWriter->save($file);
    
    return $filename;
}

}
?>