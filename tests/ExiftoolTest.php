<?php

namespace Test;

use ExiftoolWrapper\Exception\ExiftoolException;
use ExiftoolWrapper\Exiftool;
use PHPUnit\Framework\TestCase;

final class ExiftoolTest extends TestCase
{
    /**
     * @return void
     * @throws ExiftoolException
     */
    public function testGetInfoExpectExceptionWhenPathIsNotAnUrl()
    {
        $this->expectException(ExiftoolException::class);
        $this->expectErrorMessage('The path must be a url');
        $exiftool = new Exiftool();
        $response = $exiftool->getInfo('asdasd');
    }

    /**
     * Test get info expect exception when path is a dir
     * @return void
     * @throws ExiftoolException
     */
    public function testGetInfoExpectExceptionWhenPathIsADir()
    {
        $this->expectException(ExiftoolException::class);
        $exiftool = new Exiftool();
        $exiftool->getInfo(__DIR__);
    }

    /**
     * Test get info success
     * @return void
     */
    public function testGetInfoSuccess()
    {
        $file = 'https://s3.amazonaws.com/assets.dev.tenet.io/public/organizations/1/assets/bba1641c-183d-43d6-92ed-227385d288fc/barca.png';
        $exiftool = new Exiftool();
        $response = $exiftool->getInfo($file);
        echo $response;
    }
}