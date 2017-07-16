# Using BlueData\Calculation\Math class

Math class store some methods to make some specific mathematics calculations.  
All fo them are static methods and there are very simple to use.

List of available methods
-------------------------

* **getPercentDifference** - Calculates percent difference between two numbers
  * **$from** - Value from which we take difference
  * **$into** - Value to compare _(if 0 method will return `false`)_
* **numberToPercent** - Calculate which percent is one number of other
  * **$part** - Value to check
  * **$all** - Value from which percent will be calculated _(if 0 method will return `false`)_
* **percent** - Calculate percent form value
  * **$part** - Value to check
  * **$all** - Value from which percent will be calculated _(if 0 method will return `false`)_
* **end** - Estimate time to end, by given current usage value and max value `getElementById`
  * **$edition** - Maximum number of value
  * **$used** - Value that was currently loaded
  * **$start** - Start timestamp
  * **$timeNow** - Current timestamp
* **median** - Calculate median from given values
* **average** - Calculate average from given values
