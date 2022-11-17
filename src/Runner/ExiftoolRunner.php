<?php

namespace ExiftoolWrapper\Runner;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Exiftool Runner
 */
class ExiftoolRunner
{
    /**
     * @param Process $process
     */
    public function __construct(private readonly Process $process)
    {

    }

    /**
     * @return string
     */
    public function run(): string
    {
        $this->process->run();
        if (!$this->process->isSuccessful()) {
            throw new ProcessFailedException($this->process);
        }
        return $this->process->getOutput();
    }

    public static function getCommand()
    {
        if (isset($_ENV['EXIFTOOL_BINARY'])) {
            return $_ENV['EXIFTOOL_BINARY'];
        }
        return 'exiftool';
    }
}