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

class ArchiveTest extends \PHPUnit_Framework_TestCase
{
    protected static $zipFile;
    protected static $class;

    protected function setUp()
    {
        self::$zipFile = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Fixtures'.DIRECTORY_SEPARATOR.'zipsample.zip';
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

    public function testZipFile()
    {
        $this->assertFileExists(self::$zipFile);
        $this->assertTrue(is_readable(self::$zipFile));
    }

    /**
     * @depends testClass
     * @depends testZipFile
     */
    public function testReadZip()
    {
        $getId3 = new GetId3Core();
        $archive = $getId3
            ->setOptionMD5Data(true)
            ->setOptionMD5DataSource(true)
            ->setEncoding('UTF-8')
            ->analyze(self::$zipFile)
            ;

        $this->assertArrayNotHasKey('error', $archive);
        $this->assertArrayHasKey('mime_type', $archive);
        $this->assertSame('application/zip', $archive['mime_type']);
        $this->assertArrayHasKey('zip', $archive);
        $this->assertArrayHasKey('fileformat', $archive);
        $this->assertSame('zip', $archive['fileformat']);
        $this->assertArrayHasKey('encoding', $archive['zip']);
        $this->assertArrayHasKey('files', $archive['zip']);
        $this->assertArrayHasKey('entries_count', $archive['zip']);
    }
}
