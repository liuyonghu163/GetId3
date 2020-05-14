GetId3
======
[![Build Status](https://secure.travis-ci.org/phansys/GetId3.png?branch=master)](http://travis-ci.org/phansys/GetId3)

This fork of GetId3 library **only works in PHP  +5.3.3**. It updates to
[PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)
/ [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md)
standards, adds namespaces and makes it installable by composer.

Useful links
------------
* [Main site](http://www.getid3.org)
* [Support](http://support.getid3.org)

License
-------

For license info please read [LICENSE](Resources/doc/license.txt)

For commercial license read [Resources/doc/license.commercial.txt](Resources/doc/license.commercial.txt)

## Installation via [composer](http://getcomposer.org/)

##### Run composer to install the library:

``` bash
$ composer require "liuyonghu163/tp6_getId3: ^2.1@dev"
```

Quick use example reading audio properties
------------------------------------------
``` php
<?php
namespace My\Project;

use \GetId3\GetId3Core as GetId3;

class MyClass
{
    // ...
    private function myMethod()
    {
        $mp3File = '/path/to/my/mp3file.mp3';
        $getId3 = new GetId3();
        $audio = $getId3
            ->setOptionMD5Data(true)
            ->setOptionMD5DataSource(true)
            ->setEncoding('UTF-8')
            ->analyze($mp3File)
        ;

        if (isset($audio['error'])) {
            throw new \RuntimeException(sprintf('Error at reading audio properties from "%s" with GetId3: %s.', $mp3File, $audio['error']));
        }
        $this->setLength(isset($audio['playtime_seconds']) ? $audio['playtime_seconds'] : '');

        // var_dump($audio);
    }
}

```
