<?php

/*
 * This file is part of GetID3.
 *
 * (c) James Heinrich <info@getid3.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GetId3\Tests\Write;

use GetId3\GetId3Core;
use GetId3\Write\Tags;

class AudioTest extends \PHPUnit_Framework_TestCase
{
    protected static $mp3File;
    protected static $class;
    protected static $classWriter;

    protected function setUp()
    {
        self::$mp3File = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Fixtures'.DIRECTORY_SEPARATOR.'mp3demo.mp3';
        self::$class = 'GetId3\\GetId3Core';
        self::$classWriter = 'GetId3\\Write\\Tags';
    }

    public function testClassCore()
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

    /**
     * @depends testClassCore
     */
    public function testClassWriter()
    {
        if (!class_exists(self::$classWriter)) {
            $this->markTestSkipped(self::$classWriter.' is not available.');
        }

        $this->assertTrue(class_exists(self::$classWriter));
        $this->assertClassHasAttribute('filename', self::$classWriter);
        $this->assertClassHasAttribute('tagformats', self::$classWriter);
        $this->assertClassHasAttribute('tag_encoding', self::$classWriter);
        $rc = new \ReflectionClass(self::$classWriter);
        $this->assertTrue($rc->hasMethod('WriteTags'));
        $rm = new \ReflectionMethod(self::$classWriter, 'WriteTags');
        $this->assertTrue($rm->isPublic());
    }

    public function testMp3File()
    {
        $this->assertFileExists(self::$mp3File);
        $this->assertTrue(is_readable(self::$mp3File));
        $this->assertTrue(is_writable(self::$mp3File));
    }

    /**
     * @depends testClassWriter
     * @depends testMp3File
     */
    public function testWriteId3Tags()
    {
        $tagwriter = new Tags();
        $tagwriter->filename = self::$mp3File;
        $tagwriter->tagformats = array('id3v1', 'id3v2.3');
        $tagwriter->overwrite_tags = true;
        $tagwriter->tag_encoding = 'UTF-8';
        $tagwriter->remove_other_tags = true;

        $hash = ' '.substr(md5(mt_rand()), 0, 8);
        $tagData = array(
            'title' => array('My Song'.$hash),
            'artist' => array('The Artist'.$hash),
            'album' => array('Greatest Hits'.$hash),
            'year' => array('1986'.$hash),
            'genre' => array('Electronic'.$hash),
            'comment' => array('excellent!'.$hash),
            'track' => array('04/16'.$hash),
        );
        $tagwriter->tag_data = $tagData;

        $this->assertTrue($tagwriter->WriteTags());
        $this->assertAttributeEmpty('warnings', $tagwriter);

        $getId3 = new GetId3Core();
        $getId3->setOptionMD5Data(true);
        $getId3->setOptionMD5DataSource(true);
        $getId3->setEncoding('UTF-8');
        $audio = $getId3->analyze(self::$mp3File);
        $this->assertArrayNotHasKey('error', $audio);
        $this->assertArrayHasKey('audio', $audio);
        $this->assertArrayHasKey('dataformat', $audio['audio']);
        $this->assertSame('mp3', $audio['audio']['dataformat']);
        $this->assertArrayHasKey('tags', $audio);
        $this->assertArrayHasKey('id3v1', $audio['tags']);
        $this->assertArrayHasKey('id3v2', $audio['tags']);

        $this->assertArrayHasKey('title', $audio['tags']['id3v1']);
        $this->assertArrayHasKey(0, $audio['tags']['id3v1']['title']);
        $this->assertSame($tagData['title'][0], $audio['tags']['id3v1']['title'][0]);

        $this->assertArrayHasKey('title', $audio['tags']['id3v2']);
        $this->assertArrayHasKey(0, $audio['tags']['id3v2']['title']);
        $this->assertSame($tagData['title'][0], $audio['tags']['id3v2']['title'][0]);
    }
}
