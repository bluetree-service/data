# Using BlueData\Check\Validator class

Validator class store some methods to check some data validation.  
All fo them are static methods and there are very simple to use.

List of available methods
-------------------------

* **valid** - Validate given value by regular expression defined in `$regularExpressions` variable
  * **$value** - Value to valid
  * **$type** - String type of validation key
* **mail** - Validate e-mail address _(shortcut for `valid` with type mail)_
* **price** - Validate price value _(shortcut for `valid` with type price)_
* **postcode** - Validate postcode _(shortcut for `valid` with type postcode)_
* **nip** - Check NIP number
* **stringLength** - Check that string length is in given range
* **range** - Check that numeric value is in given range
* **underZero** - Return `true` if numeric value is bellow 0
* **pesel** - Check PESEL number
* **regon** - Check REGON number
* **nrb** - Check NRB number
* **iban** - Check IBAN number
* **url** - Validate url address _(without type - url, type 1 - url_extend, type 2 - url_full)_
* **phone** - Validate phone _(shortcut for `valid` with type phone)_
* **step** - Check that numeric value have correct step

* **$regularExpressions** - static variable that store some validation expressions
