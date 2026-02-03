Bluetree Service Data
============

[![Latest Stable Version](https://poser.pugx.org/bluetree-service/data/v/stable.svg?style=flat-square)](https://packagist.org/packages/bluetree-service/data)
[![Total Downloads](https://poser.pugx.org/bluetree-service/data/downloads.svg?style=flat-square)](https://packagist.org/packages/bluetree-service/data)
[![License](https://poser.pugx.org/bluetree-service/data/license.svg?style=flat-square)](https://packagist.org/packages/bluetree-service/data)

[![Build Status](https://travis-ci.org/bluetree-service/data.svg?style=flat-square)](https://travis-ci.org/bluetree-service/data)
[![Coverage Status](https://coveralls.io/repos/github/bluetree-service/data/badge.svg?style=flat-square&branch=master)](https://coveralls.io/github/bluetree-service/data?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/bluetree-service/data/badges/build.png?style=flat-square&b=master)](https://scrutinizer-ci.com/g/bluetree-service/data/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/bluetree-service/data/badges/coverage.png?style=flat-square&b=master)](https://scrutinizer-ci.com/g/bluetree-service/data/?branch=master)

[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=bluetree-service_data&metric=bugs)](https://sonarcloud.io/summary/new_code?id=bluetree-service_data)
[![Code Smells](https://sonarcloud.io/api/project_badges/measure?project=bluetree-service_data&metric=code_smells)](https://sonarcloud.io/summary/new_code?id=bluetree-service_data)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=bluetree-service_data&metric=coverage)](https://sonarcloud.io/summary/new_code?id=bluetree-service_data)
[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=bluetree-service_data&metric=reliability_rating)](https://sonarcloud.io/summary/new_code?id=bluetree-service_data)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=bluetree-service_data&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=bluetree-service_data)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=bluetree-service_data&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=bluetree-service_data)
[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=bluetree-service_data&metric=vulnerabilities)](https://sonarcloud.io/summary/new_code?id=bluetree-service_data)

[![SonarQube Cloud](https://sonarcloud.io/images/project_badges/sonarcloud-dark.svg)](https://sonarcloud.io/summary/new_code?id=bluetree-service_data)

var_dump
Main files for all class libraries. Include classes to use BlueObject as trait and
independent Object with xml data handling. Also allow to use Register to create
objects and singletons. That package is base package for all Class libraries, but
also can be used independent.

### Included libraries
* **BlueData\Data\Xml** - extends DOMDocument to handle xml data
* **BlueData\Calculation\Math** - Store some mathematics calculations as static methods
* **BlueData\Check\Validator** - Store some validations as static methods

Documentation
--------------
* [BlueData\Data\Xml](https://github.com/bluetree-service/data/blob/develop/doc/Xml.md "Xml")
* [BlueData\Data\Formats](https://github.com/bluetree-service/data/blob/develop/doc/Formats.md "Formats")
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

* PHP 8.2 or higher
* DOM extension enabled
* Multibyte String extension enabled

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
