Bluetree Service Data
============

[![Build Status](https://travis-ci.org/bluetree-service/data.svg)](https://travis-ci.org/bluetree-service/data)
[![Latest Stable Version](https://poser.pugx.org/bluetree-service/data/v/stable.svg)](https://packagist.org/packages/bluetree-service/data)
[![Total Downloads](https://poser.pugx.org/bluetree-service/data/downloads.svg)](https://packagist.org/packages/bluetree-service/data)
[![License](https://poser.pugx.org/bluetree-service/data/license.svg)](https://packagist.org/packages/bluetree-service/data)
[![Documentation Status](https://readthedocs.org/projects/class-kernel/badge/?version=latest)](https://readthedocs.org/projects/class-kernel/?badge=latest)
[![Coverage Status](https://coveralls.io/repos/bluetree-service/data/badge.svg)](https://coveralls.io/r/bluetree-service/data)

Main files for all class libraries. Include classes to use BlueObject as trait and
independent Object with xml data handling. Also allow to use Register to create
objects and singletons. That package is base package for all Class libraries, but
also can be used independent.  
Its recommended to use packages `ClassEvents` and optionally `ClassBenchmark`.

### Included libraries
* **BlueData\Base\BlueObject** - trait class to store data as object
* **BlueData\Data\Object** - include BlueObject trait for create object
* **BlueData\Data\Xml** - extends DOMDocument to handle xml data

Documentation
--------------
* [BlueData\Base\BlueObject](https://github.com/bluetree-service/data/wiki/BlueData_Base_BlueObject "BlueObject and Object")
* [BlueData\Data\Xml](https://github.com/bluetree-service/data/wiki/BlueData_Data_Xml "Xml")

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

* PHP 5.4 or higher
* DOM extension enabled

Change log
--------------
All release version changes:  
[Change log](https://github.com/bluetree-service/data/wiki/Change-log "Change log")

License
--------------
This bundle is released under the Apache license.  
[Apache license](https://github.com/bluetree-service/data/LICENSE "Apache license")

Travis Information
--------------
[Travis CI Build Info](https://travis-ci.org/bluetree-service/data)
