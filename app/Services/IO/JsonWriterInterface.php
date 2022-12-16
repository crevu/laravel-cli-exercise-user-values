<?php

namespace App\Services\IO;

/**
 * interface JsonWriterInterface
 *
 * @package App\Services\IO
 */
interface JsonWriterInterface
{
    /**
     * @param string $outputPath
     * @param array  $data
     *
     * @return void
     */
    public function writeJson(string $outputPath, array $data): void;
}
