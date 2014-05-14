php-pdfimages
=============

[![Build Status](https://travis-ci.org/waarneembemiddeling/php-pdfimages.png?branch=master)](https://travis-ci.org/waarneembemiddeling/php-pdfimages)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/waarneembemiddeling/php-pdfimages/badges/quality-score.png?s=690ba3465d629f9876678af9ae4a41a346c994ab)](https://scrutinizer-ci.com/g/waarneembemiddeling/php-pdfimages/)

PHP wrapper for the [pdfimages command](http://en.wikipedia.org/wiki/Pdfimages) available on most linux distro's.

Usage
-------------
```
use Waarneembemiddeling\PdfImages\PdfImages;
$pdfImages = PdfImages::create();
// $result is an instance of \FilesystemIterator
$result = $pdfImages->extractImages('path/to/pdf');
$result2 = $pdfImages->extractImages('path/to/pdf', 'path/to/other/destination/dir/then/tmp');

```

PNG output
-------------
PNG images will not be converted to jpeg but will be extracted as one or more ppm files.

Testing
-------------

```
cp phpunit.xml.dist phpunit.xml
```

Change the phpunit.xml ```env``` ```binary``` directive if necessary.

```
composer install
```

```
php vendor/bin/phpunit
```
