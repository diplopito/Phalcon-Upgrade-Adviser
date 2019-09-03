# phalconUpgrader
Console application that indexes all PHP files in a Phalcon application and returns a log with all the classes that need to be changed in order to upgrade from version 3.x to 4.x. Can be used to check a single file as well.

## Requirements
- Phalcon 3.x or 4.x;
- PHP 5.6, 7.x

## Usage
- Open a terminal window;
- Command line cli.php Main createLog // Accepts two string parameters:
1. Required: File name or path to application;
2. Optional Log file ("upgraderLog.txt" by default).

### Example:
```php
//For full app check provide the path to the app:
php cli.php Main createLog /home/user/Vokuro upgrader.txt //stores result in log file

//To check just one file; result will be returned to terminal:
php cli.php Main createLog /home/user/Vokuro/app/library/Acl/Acl.php

//Returns:
/home/user/Vokuro/app/library/Acl/Acl.php:
Phalcon\Mvc\User\Component => Renamed to Phalcon\Plugin
Phalcon\Acl\Adapter\Memory => No changes (Might need to check types)
Phalcon\Acl\Role => No changes (Might need to check types)
Phalcon\Acl\Resource => Renamed to Phalcon\Acl\Component
Phalcon\Acl\Adapter\Memory => No changes (Might need to check types)
Phalcon\Acl\Adapter\Memory => No changes (Might need to check types)
Phalcon\Acl\Adapter\Memory => No changes (Might need to check types)
Phalcon\Acl::DENY) => Check changes in constant
```

