<?php

namespace App\Services\IO;

/**
 * interface CSVReaderInterface
 *
 * @package App\Services\IO
 */
interface CSVReaderInterface
{
    /**
     * @param string $inputFilePath
     *
     * @return array
     */
    public function readCSV(string $inputFilePath): array;
}
