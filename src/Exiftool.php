<?php

namespace ExiftoolWrapper;

use ExiftoolWrapper\Runner\ExiftoolRunner;
use ExiftoolWrapper\Exception\ExiftoolException;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Exiftool
 */
class Exiftool
{
    /**
     * Get info of exiftool
     * @param string $filePath
     * @param array $arguments
     * @return array
     * @throws ExiftoolException
     */
    public function getInfo(string $filePath, array $arguments = []): array
    {
        if (!filter_var($filePath, FILTER_VALIDATE_URL)) {
            throw new ExiftoolException('The path must be a url');
        }
        if (is_dir($filePath)) {
            throw new ExiftoolException('The path must be not a directory');
        }
        return $this->buildParseMetaData($filePath, $arguments);
    }

    /**
     * @param string $filePath
     * @param array $arguments
     * @return string
     * @throws ExiftoolException
     */
    private function outputMetadata(string $filePath, array $arguments = []): string
    {
        $tempFile = $this->tempFile($filePath);
        if (!$tempFile) {
            throw new ExiftoolException('Error when try it to make tmp file');
        }
        $process = $this->makeProcess($tempFile, $arguments);
        $runner = new ExiftoolRunner($process);
        try {
            $data = $runner->run();
        } catch (ProcessFailedException $exception) {
            throw new ExiftoolException('Error when try to run the command');
        }
        return $data;
    }

    /**
     * @param string $filePath
     * @param array $arguments
     * @return Process
     */
    private function makeProcess(string $filePath, array $arguments = []): Process
    {
        $command = ExiftoolRunner::getCommand();
        $arguments += [
            'FILE_PATH' => $filePath
        ];
        return new Process(
            array_merge([$command], array_values($arguments))
        );
    }

    /**
     * Make temp file
     * @param string $filePath
     * @return false|string
     */
    private function tempFile(string $filePath): string|false
    {
        $temp = tempnam(sys_get_temp_dir(), 'tmp');
        file_put_contents($temp, file_get_contents($filePath));
        return $temp;
    }

    /**
     * @param string $filePath
     * @param array $arguments
     * @return array
     * @throws ExiftoolException
     */
    private function buildParseMetaData(string $filePath, array $arguments = []): array
    {
        $metaData = $this->outputMetadata($filePath, $arguments);
        $arrayData = explode(PHP_EOL, $metaData);
        $formatData = array();
        foreach ($arrayData as $data) {
            $explodeData = explode(":", $data);
            $formatKey = str_replace(' ', '_', strtolower(trim($explodeData[0])));
            if(!empty($formatKey)) {
                $formatData[$formatKey] = @$explodeData[1];
            }
        }
        return $formatData;
    }
}
