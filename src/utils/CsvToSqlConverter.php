<?php

declare(strict_types=1);

namespace TaskForce\utils;

use TaskForce\exceptions\CsvToSqlException;
use TaskForce\exceptions\FileSourceException;

use SplFileObject;
use RuntimeException;

class CsvToSqlConverter
{
    public function __construct($sql_directory)
    {
        if (!file_exists($sql_directory)) {
            throw new CsvToSqlException("Папка " . $sql_directory . " не найдена.");
        }
        $this->sql_directory = $sql_directory;
    }

    public function convert_csv_file($csv_file_name) //: void
    {
        $csv_file = new SplFileObject($csv_file_name);

        try {
            $sql_file_path = pathinfo($csv_file_name, PATHINFO_FILENAME);
            $sql_file_names = explode('.', $sql_file_path)[0] ?? null;
            $sql_file_name = $this->sql_directory . $csv_file_name . '.sql';
            $sql_file = new SplFileObject($sql_file_name, 'w');
        } catch (RuntimeException $exception) {
            throw new FileSourceException("Ошибка создания sql-файла.");
        }


        // print($sql_file_path);
    }
}
