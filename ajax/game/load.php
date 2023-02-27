<?php

use app\classes\Db\DbFactory;
use app\container\Container;

/**
 * @var Container $container
 * @var \app\classes\Db\Query\DeleteQuery $query
 * @var \app\classes\tables\RoomsTable $roomsTable
 * @var \app\classes\Db\MysqlDb $db
 */
$container = Container::getInstance();
$db = $this->container->get(DbFactory::class)->get();
//$dbRes = $db->query('DROP TABLE rooms');
//$dbRes = $db->query('SELECT  *  FROM `rooms`');
$dbRes = $db->query("SELECT IF(COUNT(*)>0, 'YES', 'NO') AS 'EXIST' FROM `information_schema`.`TABLES` WHERE `TABLE_SCHEMA`='game' AND `TABLE_NAME`='rooms'")->fetch_row()[0];
//$dbRes = $db->query("CREATE TABLE IF NOT EXISTS `rooms`(`id` int(3) NOT NULL AUTO_INCREMENT ,`name` varchar(100) NULL COLLATE utf8_unicode_ci, PRIMARY KEY (`id`)) ENGINE = InnoDB");
//$dbRes = $db->query("SELECT IF(COUNT(*)>0, 'YES', 'NO') AS 'EXIST' FROM `information_schema`.`TABLES` WHERE `TABLE_SCHEMA`='game' AND `TABLE_NAME`='rooms'")->fetch_row()[0];
//$dbRes = $db->query("INSERT INTO `rooms` (`id`,`name`)  VALUES  (1, 'Первая комната'),
//(2, 'Вторая комната'),
//(3, 'Третья комнатка'),
//(4, 'Четвертая комната'),
//(5, 'Пятая комнатка')");
$roomsTable = $container->get(\app\classes\tables\RoomsTable::class);
$rooms = [
    ['id' => 1, 'name' => 'Первая комната'],
    ['id' => 2, 'name' => 'Вторая комната'],
    ['id' => 3, 'name' => 'Третья комнатка'],
    ['id' => 4, 'name' => 'Четвертая комната'],
    ['id' => 5, 'name' => 'Пятая комнатка'],
];
$res = $roomsTable->add($rooms);
//$roomsTable->delete(3);
$r = $roomsTable->getList();
$file = $_FILES['file_path'];
if (empty($file)) {
    $result = ['success' => false, 'message' => 'Выберите файл!'];
} else {
    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file['tmp_name']);
    $reader->setReadDataOnly(true);
    $data = $reader->load($file['tmp_name'], 2);
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