<?php

use app\container\Container;

$container = Container::getInstance();
$roomsTable = $container->get(\app\classes\tables\RoomsTable::class);
$boxesTable = $container->get(\app\classes\tables\BoxesTable::class);

$file = $_FILES['file_path'];
if (empty($file)) {
    $result = ['success' => false, 'message' => 'Выберите файл!'];
} else {
    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file['tmp_name']);
    $reader->setReadDataOnly(true);
    $data = $reader->load($file['tmp_name'],2);
    $sheets = $data->getAllSheets();
    $arData = [];
    foreach ($sheets as $sheet) {
        $sheetTitle = $sheet->getTitle();
        foreach ($sheet->getRowIterator() as $row) {
            $rowNum = $row->getRowIndex();
            $name = $sheet->getCell('A' . $rowNum)->getValue();
            $count = $sheet->getCell('B' . $rowNum)->getValue();
            $rooms = $sheet->getCell('C' . $rowNum)->getValue();
            $arData[$sheetTitle][$name] = [
                'count' => $count,
                'rooms' => $rooms,
            ];
        }
    }

    $result = ['success' => true, 'message' => 'Ок', 'data' => $arData];
}
echo json_encode($result, JSON_UNESCAPED_UNICODE);