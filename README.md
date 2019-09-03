# phalconUpgrader
Console application that indexes all PHP files in a Phalcon application and returns a log with all the classes that need to be change in order to upgrade from version 3.x to 4.x. Can be used to check a single file as well.

## Requirements
- Phalcon 3.x or 4.x;
- PHP 5.6, 7.x

## Usage
- Open a terminal window;
- Run cli.php. Accepts two string parameters:
-- 1. File name or path to application;
-- 2. Log file (if not given, default is "upgraderLog.txt")

### Example:
```php
//For full app check provide the path to the app:
\home\user\upgrader\php cli.php \home\user\Vokuro upgrader.txt

//To check just one file; result will be returned to terminal:
\home\user\upgrader\php cli.php \home\user\Vokuro\app\library\Acl\Acl.php
