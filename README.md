# Phalcon Upgrade Adviser (Unofficial)
This console application aims to smooth the upgrade process from Phalcon 3.x to 4.x by indexing all the PHP files in a project and listing all the Phalcon classes that must be changed per file. It is a _proactive_ approach: rather than bumping from error to error, it helps the developer to make (hopefully) all the changes necessary before running the app to upgrade. It can be used along the upgrade process to follow up all the pending tasks; at the end, there should be no _renamed_ or _removed_ 3.x classes listed in the log file. 

The Adviser is a companion to the [Official Phalcon upgrade guide](https://github.com/phalcon/docs/blob/4.0/en/upgrade.md): whenever the log points to a _renamed_ class, it is recommendable to check the guide to know exactly what has to be changed. The Adviser is limited to new, renamed and removed classes. Other changes, like adding a handle to new applications, must be done following the guide.

## Changelog
Nov. 16/19: Updated to v4.0.0-RC3
Nov. 3/19: Updated to v4.0.0-RC2

## Requirements
- Phalcon 4.x;

## Usage
- Open a terminal window;
- Command line `php cli.php Main createLog ` // Accepts two string parameters:
1. Required: File name or path to application;
2. Optional Log file ("upgraderLog.txt" by default).

### Example:
```php
//For full app check provide the path to the app:
php cli.php Main createLog /mnt/f/xampp/htdocs/xtest/vokuro vokuroLog.txt //stores result in log file
```
View [Log file](https://github.com/diplopito/Phalcon-Upgrade-Adviser/blob/master/vokuroLog.txt)
```php
//To check just one file; result will be returned to terminal:
php cli.php Main createLog /mnt/f/xampp/htdocs/xtest/vokuro/app/library/Acl/Acl.php

//Returns:
/mnt/f/xampp/htdocs/xtest/vokuro/app/library/Acl/Acl.php:
Phalcon\Mvc\User\Component => Renamed to Phalcon\Plugin
Phalcon\Acl\Adapter\Memory => No changes (Might need to check types)
Phalcon\Acl\Role => No changes (Might need to check types)
Phalcon\Acl\Resource => Renamed to Phalcon\Acl\Component
Phalcon\Acl\Adapter\Memory => No changes (Might need to check types)
Phalcon\Acl\Adapter\Memory => No changes (Might need to check types)
Phalcon\Acl\Adapter\Memory => No changes (Might need to check types)
Phalcon\Acl::DENY) => Check changes in constant
```


## Note
The Adviser will skip the _.git_ and _vendor_ directories.
