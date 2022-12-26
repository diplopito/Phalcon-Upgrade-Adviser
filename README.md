# Phalcon Upgrade Adviser (Unofficial)
This console application aims to smooth the upgrade process from Phalcon 3.4.x to 4.0.x or Phalcon 4.0.x up to 5.1.3 by indexing all the PHP files in a project and listing all the Phalcon classes that must be changed per file. 

The Adviser is a companion to the [Official Phalcon upgrade guide to v4](https://github.com/phalcon/docs/blob/4.0/en/upgrade.md) and to the [Official Phalcon upgrade guide to v5](https://github.com/phalcon/docs/blob/5.0/en/upgrade.md): whenever the log points to a _renamed_ class, it is recommended to check the guide to know exactly what has to be changed. The Adviser is limited to new, renamed and removed classes. Other changes, like adding a handle to new applications, must be done following the guide.

## Requirements
- Php 7+ or 8+;

## Usage
- Open a terminal window;
- Command line `php cli.php {upgradePath} {pathToObj} {logfile} ` where:
1. `upgradePath` (Required): must be `v3to4`to upgrade from Phalcon 3 to 4 or `v4to5` to upgrade from Phalcon 4 to 5;
2. `pathToObj` (Required): must be the path to the directory of the project that you want to upgrade or to a single file;
3. `logfile` (optional): file to log the upgrading steps (if not provided, "upgraderLog.txt" will be used by default).

### Example:
```php
//Migrating a project from Phalcon 3.4.5 to 4.1.2
//For full app upgrade provide the path to the app:
php cli.php v3to4 /mnt/f/xampp/htdocs/xtest/vokuro vokuroLog.txt //stores result in log file `vokuroLog.txt`
```
View [Log file](https://github.com/diplopito/Phalcon-Upgrade-Adviser/blob/master/vokuroLog.txt)

```php
//Migrating a project from Phalcon 4.1.3 to 5.1.3
php cli.php v4to5 F:\xampp\htdocs\xtest\vokuro-4.1 vokuro4to5.txt
```
View [Log file](https://github.com/diplopito/Phalcon-Upgrade-Adviser/blob/master/vokuro4to5.txt)

```php
//To check just one file; result will be returned to terminal:
php cli.php v3to4 /mnt/f/xampp/htdocs/xtest/vokuro/app/library/Acl/Acl.php

//Returns:
/mnt/f/xampp/htdocs/xtest/vokuro/app/library/Acl/Acl.php:
Phalcon\Mvc\User\Component =>  Renamed to Phalcon\Di\AbstractInjectionAware
Phalcon\Acl\Adapter\Memory => No changes (Might need to check types)
Phalcon\Acl\Role => No changes (Might need to check types)
Phalcon\Acl\Resource =>  Renamed to Phalcon\Acl\Component
Phalcon\Acl\Adapter\Memory => No changes (Might need to check types)
Phalcon\Acl\Adapter\Memory => No changes (Might need to check types)
Phalcon\Acl\Adapter\Memory => No changes (Might need to check types)
Phalcon\Acl::DENY) => Check possible changes in constant
```


## Note
The Adviser will skip the _.volt_ files, _.git_ and _vendor_ directories.
