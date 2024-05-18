<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dateFrom = $_POST['training_date_from'];
    $dateTo = $_POST['training_date_to'];
    $training_id = $_POST['training_id'];
    $training_type = $_POST['training_type'];
    $department = $_POST['department'];
    $vendor_name = $_POST['vendor_name'];

    // Dummy data for demonstration
    $data = [
        ['trainingDate' => '2023-05-01', 'parameter' => 'A', 'detail' => 'Detail A1'],
        ['trainingDate' => '2023-05-02', 'parameter' => 'B', 'detail' => 'Detail B1'],
        ['trainingDate' => '2023-05-03', 'parameter' => 'A', 'detail' => 'Detail A2'],
        ['trainingDate' => '2023-05-04', 'parameter' => 'C', 'detail' => 'Detail C1'],
        // Add more data as needed
    ];

    // Filter data based on user input
    $filteredData = array_filter($data, function($item) use ($dateFrom, $dateTo) {
        return (!$dateFrom || $dateFrom <= $item['trainingDate']) && (!$dateTo || $item['trainingDate'] <= $dateTo);
    });

    // Load PhpSpreadsheet library
    require 'vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Set header row
    $sheet->setCellValue('A1', 'Training Date');
    $sheet->setCellValue('B1', 'Parameter');
    $sheet->setCellValue('C1', 'Detail');
    
    // Populate data rows
    $row = 2;
    foreach ($filteredData as $item) {
        $sheet->setCellValue('A' . $row, $item['trainingDate']);
        $sheet->setCellValue('B' . $row, $item['parameter']);
        $sheet->setCellValue('C' . $row, $item['detail']);
        $row++;
    }

    // Write the file and download
    $writer = new Xlsx($spreadsheet);
    $filename = 'report.xlsx';
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
}
?>
