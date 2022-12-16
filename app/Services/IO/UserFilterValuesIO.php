<?php

namespace App\Services\IO;

/**
 * class CsvExtractService
 *
 * @package App\Services
 */
class UserFilterValuesIO implements CSVReaderInterface, JsonWriterInterface
{
    /**
     * Extracts csv content into an associative array
     *
     * @param string $inputFilePath
     *
     * @return array
     */
    public function readCSV(string $inputFilePath): array
    {
        $result = [];

        $fileStream = fopen($inputFilePath, 'r');

        $firstRow = fgetcsv($fileStream, null, ';');

        while (($csvLine = fgetcsv($fileStream, null, ';')) !== false) {
            $resultKey = '';
            $resultValue = [];

            foreach ($csvLine as $key => $value) {
                if ($firstRow[$key] === 'email') {
                    $resultKey = $value;
                    continue;
                }

                $resultValue[$firstRow[$key]] = $value;
            }

            $result[$resultKey] = $resultValue;
        }

        fclose($fileStream);

        return $result;
    }

    /**
     * @param string $outputPath
     * @param array  $data
     *
     * @return void
     */
    public function writeJson(string $outputPath, array $data): void
    {
        $json = json_encode($data);

        $outputFile = fopen($outputPath, "w");
        fwrite($outputFile, $json);
        fclose($outputFile);
    }
}
