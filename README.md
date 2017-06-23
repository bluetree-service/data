Bluetree Service Data
============

[![Build Status](https://travis-ci.org/bluetree-service/data.svg)](https://travis-ci.org/bluetree-service/data)
[![Latest Stable Version](https://poser.pugx.org/bluetree-service/data/v/stable.svg)](https://packagist.org/packages/bluetree-service/data)
[![Total Downloads](https://poser.pugx.org/bluetree-service/data/downloads.svg)](https://packagist.org/packages/bluetree-service/data)
[![License](https://poser.pugx.org/bluetree-service/data/license.svg)](https://packagist.org/packages/bluetree-service/data)
[![Documentation Status](https://readthedocs.org/projects/)](https://readthedocs.org/projects/)
[![Coverage Status](https://coveralls.io/repos/bluetree-service/data/badge.svg)](https://coveralls.io/r/bluetree-service/data)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects//mini.png)](https://insight.sensiolabs.com/projects/)
[![Code Climate](https://codeclimate.com/github/bluetree-service/data/badges/gpa.svg)](https://codeclimate.com/github/bluetree-service/data)


Main files for all class libraries. Include classes to use BlueObject as trait and
independent Object with xml data handling. Also allow to use Register to create
objects and singletons. That package is base package for all Class libraries, but
also can be used independent.

### Included libraries
* **BlueData\Data\Xml** - extends DOMDocument to handle xml data
* **BlueData\Calculation\Math** - 
* **BlueData\Check\Validator** - 

Documentation
--------------
* [BlueData\Data\Xml](https://github.com/bluetree-service/data/blob/develop/doc/Xml.md "Xml")
* [BlueData\Calculation\Math](https://github.com/bluetree-service/data/blob/develop/doc/Math.md "Math")
* [BlueData\Check\Validator](https://github.com/bluetree-service/data/blob/develop/doc/Validator.md "Validator")

Install via Composer
--------------
To use packages you can just download package and pace it in your code. But recommended
way to use _BlueData_ is install it via Composer. To include _BlueData_
libraries paste into composer json:

```json
{
    "require": {
        "bluetree-service/data": "version_number"
    }
}
```

Project description
--------------

### Used conventions

* **Namespaces** - each library use namespaces
* **PSR-4** - [PSR-4](http://www.php-fig.org/psr/psr-4/) coding standard
* **Composer** - [Composer](https://getcomposer.org/) usage to load/update libraries

### Requirements

* PHP 5.5 or higher
* DOM extension enabled

Change log
--------------
All release version changes:  
[Change log](https://github.com/bluetree-service/data/blob/develop/doc/changelog.md "Change log")

License
--------------
This bundle is released under the Apache license.  
[Apache license](https://github.com/bluetree-service/data/LICENSE "Apache license")

Travis Information
--------------
[Travis CI Build Info](https://travis-ci.org/bluetree-service/data)
