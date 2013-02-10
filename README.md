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

## Additional register separate plugins
It's possible to use parts of this plugin. All the `<module>\Plugin.php` are compactible.

```php
<?php
$sshConnect->getPluginManager()->registerPlugin('git.branch', 'FeGit\Branch\Plugin');
$sshConnect->getPluginManager()->registerPlugin('git.checkout', 'FeGit\Checkout\Plugin');
$sshConnect->getPluginManager()->registerPlugin('git.cloning', 'FeGit\Cloning\Plugin');
$sshConnect->getPluginManager()->registerPlugin('git.config', 'FeGit\Config\Plugin');
$sshConnect->getPluginManager()->registerPlugin('git.fetch', 'FeGit\Fetch\Plugin');
$sshConnect->getPluginManager()->registerPlugin('git.remote', 'FeGit\Remote\Plugin');
$sshConnect->getPluginManager()->registerPlugin('git.tag', 'FeGit\Tag\Plugin');
```
