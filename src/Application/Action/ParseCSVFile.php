<?php

declare(strict_types=1);

namespace App\Application\Action;


class ParseCSVFile
{
    public function __construct() {}

    public function __invoke(string $filePath): array
    {
        $headers = $data = $errors = [];
        $handle = fopen($filePath, "r");
        while (($row = fgetcsv($handle, 0, ';')) !== FALSE) {
            if (0 === count($headers)) {
                $headers = $row;
            } else {
                try {
                    $data[] = array_combine($headers, $row);
                } catch (\Throwable $th) {
                    $errors[] = $row;
                }
            }            
        }

        fclose($handle);
        return $data;
    }
}
