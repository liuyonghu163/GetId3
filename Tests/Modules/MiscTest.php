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

class MiscTest extends \PHPUnit_Framework_TestCase
{
    protected static $cueFile;
    protected static $class;

    protected function setUp()
    {
        self::$cueFile = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Fixtures'.DIRECTORY_SEPARATOR.'cuesample.cue';
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

    public function testCueFile()
    {
        $this->assertFileExists(self::$cueFile);
        $this->assertTrue(is_readable(self::$cueFile));
    }

    /**
     * @depends testClass
     * @depends testCueFile
     */
    public function testReadCue()
    {
        $getId3 = new GetId3Core();
        $properties = $getId3
            ->setOptionMD5Data(true)
            ->setOptionMD5DataSource(true)
            ->setEncoding('UTF-8')
            ->analyze(self::$cueFile)
            ;

        $this->assertArrayNotHasKey('error', $properties);
        $this->assertArrayNotHasKey('warning', $properties);
        $this->assertArrayHasKey('mime_type', $properties);
        $this->assertSame('application/octet-stream', $properties['mime_type']);
        $this->assertArrayHasKey('encoding', $properties);
        $this->assertSame('UTF-8', $properties['encoding']);
        $this->assertArrayHasKey('filesize', $properties);
        $this->assertSame(314, $properties['filesize']);
        $this->assertArrayHasKey('fileformat', $properties);
        $this->assertSame('cue', $properties['fileformat']);
        $this->assertArrayHasKey('cue', $properties);
        $this->assertArrayHasKey('tracks', $properties['cue']);
        $this->assertCount(8, $properties['cue']['tracks']);
        $this->assertArrayHasKey('encoding', $properties['cue']);
    }
}
