<?php

/*
 * This file is part of GetID3.
 *
 * (c) James Heinrich <info@getid3.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GetId3\Tests\Modules;

use GetId3\GetId3Core;

class GraphicTest extends \PHPUnit_Framework_TestCase
{
    protected static $jpgFile;
    protected static $pngFile;
    protected static $bmpFile;
    protected static $svgFile;
    protected static $tiffFile;
    protected static $class;

    protected function setUp()
    {
        self::$jpgFile = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Fixtures'.DIRECTORY_SEPARATOR.'jpgsample.jpg';
        self::$pngFile = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Fixtures'.DIRECTORY_SEPARATOR.'pngsample.png';
        self::$bmpFile = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Fixtures'.DIRECTORY_SEPARATOR.'bmpsample.bmp';
        self::$svgFile = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Fixtures'.DIRECTORY_SEPARATOR.'svgsample.svg';
        self::$tiffFile = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Fixtures'.DIRECTORY_SEPARATOR.'tiffsample.tif';
        self::$class = 'GetId3\\GetId3Core';
    }

    public function testClass()
    {
        if (!class_exists(self::$class)) {
            $this->markTestSkipped(self::$class.' is not available.');
        }
        $this->assertTrue(class_exists(self::$class));
        $this->assertClassHasAttribute('option_md5_data', self::$class);
        $this->assertClassHasAttribute('option_md5_data_source', self::$class);
        $this->assertClassHasAttribute('encoding', self::$class);
        $rc = new \ReflectionClass(self::$class);
        $this->assertTrue($rc->hasMethod('analyze'));
        $rm = new \ReflectionMethod(self::$class, 'analyze');
        $this->assertTrue($rm->isPublic());
    }

    public function testJpgFile()
    {
        $this->assertFileExists(self::$jpgFile);
        $this->assertTrue(is_readable(self::$jpgFile));
    }

    /**
     * @depends testClass
     * @depends testJpgFile
     */
    public function testReadJpg()
    {
        $getId3 = new GetId3Core();
        $image = $getId3
            ->setOptionMD5Data(true)
            ->setOptionMD5DataSource(true)
            ->setEncoding('UTF-8')
            ->analyze(self::$jpgFile)
            ;

        $this->assertArrayNotHasKey('error', $image);
        $this->assertArrayHasKey('mime_type', $image);
        $this->assertSame('image/jpeg', $image['mime_type']);
        $this->assertArrayHasKey('fileformat', $image);
        $this->assertSame('jpg', $image['fileformat']);
        $this->assertArrayHasKey('video', $image);
        $this->assertArrayHasKey('dataformat', $image['video']);
        $this->assertSame('jpg', $image['video']['dataformat']);
        $this->assertArrayHasKey('lossless', $image['video']);
        $this->assertArrayHasKey('bits_per_sample', $image['video']);
        $this->assertArrayHasKey('pixel_aspect_ratio', $image['video']);
        $this->assertArrayHasKey('resolution_x', $image['video']);
        $this->assertSame(313, $image['video']['resolution_x']);
        $this->assertArrayHasKey('resolution_y', $image['video']);
        $this->assertSame(234, $image['video']['resolution_y']);
        $this->assertArrayHasKey('compression_ratio', $image['video']);
        $this->assertSame(0.0069313599665037, $image['video']['compression_ratio']);
    }

    public function testPngFile()
    {
        $this->assertFileExists(self::$pngFile);
        $this->assertTrue(is_readable(self::$pngFile));
    }

    /**
     * @depends testClass
     * @depends testPngFile
     */
    public function testReadPng()
    {
        $getId3 = new GetId3Core();
        $image = $getId3
            ->setOptionMD5Data(true)
            ->setOptionMD5DataSource(true)
            ->setEncoding('UTF-8')
            ->analyze(self::$pngFile)
            ;

        $this->assertArrayNotHasKey('error', $image);
        $this->assertArrayHasKey('mime_type', $image);
        $this->assertSame('image/png', $image['mime_type']);
        $this->assertArrayHasKey('fileformat', $image);
        $this->assertSame('png', $image['fileformat']);
        $this->assertArrayHasKey('video', $image);
        $this->assertArrayHasKey('dataformat', $image['video']);
        $this->assertSame('png', $image['video']['dataformat']);
        $this->assertArrayHasKey('lossless', $image['video']);
        $this->assertArrayHasKey('bits_per_sample', $image['video']);
        $this->assertArrayHasKey('resolution_x', $image['video']);
        $this->assertSame(300, $image['video']['resolution_x']);
        $this->assertArrayHasKey('resolution_y', $image['video']);
        $this->assertSame(225, $image['video']['resolution_y']);
        $this->assertArrayHasKey('compression_ratio', $image['video']);
        $this->assertSame(0.17746296296296, $image['video']['compression_ratio']);
        $this->assertArrayHasKey('png', $image);
        $this->assertArrayHasKey('IHDR', $image['png']);
        $this->assertArrayHasKey('width', $image['png']['IHDR']);
        $this->assertSame(300, $image['png']['IHDR']['width']);
        $this->assertArrayHasKey('height', $image['png']['IHDR']);
        $this->assertSame(225, $image['png']['IHDR']['height']);
        $this->assertArrayHasKey('compression_method_text', $image['png']['IHDR']);
        $this->assertSame('deflate/inflate', $image['png']['IHDR']['compression_method_text']);
        $this->assertArrayHasKey('bKGD', $image['png']);
        $this->assertArrayHasKey('background_red', $image['png']['bKGD']);
        $this->assertSame(1095233372415, $image['png']['bKGD']['background_red']);
    }

    public function testBmpFile()
    {
        $this->assertFileExists(self::$bmpFile);
        $this->assertTrue(is_readable(self::$bmpFile));
    }

    /**
     * @depends testClass
     * @depends testBmpFile
     */
    public function testReadBmp()
    {
        $getId3 = new GetId3Core();
        $image = $getId3
            ->setOptionMD5Data(true)
            ->setOptionMD5DataSource(true)
            ->setEncoding('UTF-8')
            ->analyze(self::$bmpFile)
            ;

        $this->assertArrayNotHasKey('error', $image);
        $this->assertArrayHasKey('mime_type', $image);
        $this->assertSame('image/bmp', $image['mime_type']);
        $this->assertArrayHasKey('fileformat', $image);
        $this->assertSame('bmp', $image['fileformat']);
        $this->assertArrayHasKey('video', $image);
        $this->assertArrayHasKey('dataformat', $image['video']);
        $this->assertSame('bmp', $image['video']['dataformat']);
        $this->assertArrayHasKey('lossless', $image['video']);
        $this->assertArrayHasKey('bits_per_sample', $image['video']);
        $this->assertArrayHasKey('resolution_x', $image['video']);
        $this->assertSame(300, $image['video']['resolution_x']);
        $this->assertArrayHasKey('resolution_y', $image['video']);
        $this->assertSame(150, $image['video']['resolution_y']);
        $this->assertArrayHasKey('compression_ratio', $image['video']);
        $this->assertSame(1.0239555555556, $image['video']['compression_ratio']);
        $this->assertArrayHasKey('bmp', $image);
        $this->assertArrayHasKey('header', $image['bmp']);
        $this->assertArrayHasKey('compression', $image['bmp']['header']);
        $this->assertSame('BI_RGB', $image['bmp']['header']['compression']);
    }

    public function testSvgFile()
    {
        $this->assertFileExists(self::$svgFile);
        $this->assertTrue(is_readable(self::$svgFile));
    }

    /**
     * @depends testClass
     * @depends testSvgFile
     */
    public function testReadSvg()
    {
        $getId3 = new GetId3Core();
        $image = $getId3
            ->setOptionMD5Data(true)
            ->setOptionMD5DataSource(true)
            ->setEncoding('UTF-8')
            ->analyze(self::$svgFile)
            ;

        $this->assertArrayNotHasKey('error', $image);
        $this->assertArrayNotHasKey('warning', $image);
        $this->assertArrayHasKey('mime_type', $image);
        $this->assertSame('image/svg+xml', $image['mime_type']);
        $this->assertArrayHasKey('fileformat', $image);
        $this->assertSame('svg', $image['fileformat']);
        $this->assertArrayHasKey('video', $image);
        $this->assertArrayHasKey('dataformat', $image['video']);
        $this->assertSame('svg', $image['video']['dataformat']);
        $this->assertArrayHasKey('lossless', $image['video']);
        $this->assertArrayHasKey('pixel_aspect_ratio', $image['video']);
        $this->assertArrayHasKey('resolution_x', $image['video']);
        $this->assertSame(1062, $image['video']['resolution_x']);
        $this->assertArrayHasKey('resolution_y', $image['video']);
        $this->assertSame(637, $image['video']['resolution_y']);
        $this->assertArrayHasKey('svg', $image);
        $this->assertArrayHasKey('xml', $image['svg']);
        $this->assertArrayHasKey('svg', $image['svg']);
        $this->assertArrayHasKey('version', $image['svg']);
        $this->assertSame('1.0', $image['svg']['version']);
    }

    public function testTiffFile()
    {
        $this->assertFileExists(self::$tiffFile);
        $this->assertTrue(is_readable(self::$tiffFile));
    }

    /**
     * @depends testClass
     * @depends testTiffFile
     */
    public function testReadTiff()
    {
        $getId3 = new GetId3Core();
        $image = $getId3
            ->setOptionMD5Data(true)
            ->setOptionMD5DataSource(true)
            ->setEncoding('UTF-8')
            ->analyze(self::$tiffFile)
            ;

        $this->assertArrayNotHasKey('error', $image);
        $this->assertArrayNotHasKey('warning', $image);
        $this->assertArrayHasKey('mime_type', $image);
        $this->assertSame('image/tiff', $image['mime_type']);
        $this->assertArrayHasKey('fileformat', $image);
        $this->assertSame('tiff', $image['fileformat']);
        $this->assertArrayHasKey('video', $image);
        $this->assertArrayHasKey('dataformat', $image['video']);
        $this->assertSame('tiff', $image['video']['dataformat']);
        $this->assertArrayHasKey('lossless', $image['video']);
        $this->assertArrayHasKey('resolution_x', $image['video']);
        $this->assertSame(1728, $image['video']['resolution_x']);
        $this->assertArrayHasKey('resolution_y', $image['video']);
        $this->assertSame(2376, $image['video']['resolution_y']);
        $this->assertArrayHasKey('tiff', $image);
        $this->assertArrayHasKey('byte_order', $image['tiff']);
        $this->assertSame('Intel', $image['tiff']['byte_order']);
        $this->assertArrayHasKey('encoding', $image['tiff']);
        $this->assertArrayHasKey('comments', $image['tiff']);
    }
}
