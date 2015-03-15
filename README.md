Config Component
=======
[![Build Status](https://scrutinizer-ci.com/g/RobinCK/config/badges/build.png?b=master)](https://scrutinizer-ci.com/g/RobinCK/config/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/RobinCK/config/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/RobinCK/config/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/kasseler/config/v/stable.svg)](https://packagist.org/packages/kasseler/config) 
[![Total Downloads](https://poser.pugx.org/kasseler/config/downloads.svg)](https://packagist.org/packages/kasseler/config) 
[![Latest Unstable Version](https://poser.pugx.org/kasseler/config/v/unstable.svg)](https://packagist.org/packages/kasseler/config) 
[![License](https://poser.pugx.org/kasseler/config/license.svg)](https://packagist.org/packages/kasseler/config)

Config Component is a file configuration loader and saver that supports PHP, XML, JSON, and YAML files.
### Requirements
 - PHP >= 5.4
 - symfony/yaml

### Installation
```sh
$ composer require kasseler/config
```

### Usage
Initialization Yaml configuration

```php
$config = new Repository(new YamlFileReader(), new YamlFileWriter(), __DIR__.'/app/config/');
```
Initialization XML configuration
```php
$config = new Repository(new XmlFileReader(), new XmlFileWriter(), __DIR__.'/app/config/');
```
Initialization JSON configuration
```php
$config = new Repository(new JsonFileReader(), new JsonFileWriter(), __DIR__.'/app/config/');
```
Initialization PHP array configuration
```php
$config = new Repository(new ArrayFileReader(), new ArrayFileWriter(), __DIR__.'/app/config/');

$config
    ->set('database.host', 'localhost')
    ->set('database.user', 'root')
    ->set('database.password', '')
    ->set('database.database', 'config')
    ->write();
    
$config->get('database.host');
```
