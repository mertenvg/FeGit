FeGit
=====

## Installation standalone
```php
<?php
$sshConnect->getPluginManager()->registerPlugin('git', 'FeGit\Plugin');
```

## Installation Zend Framework 2
1. Add the module to your application.config.php and the plugin will be registered under the name 'git'
```php
<?php
return array(
    'Application',
    'FeSshConnect',
    'FeGit',
);

```