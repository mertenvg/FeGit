<?php
namespace FeGit\Service;

use FeSshConnect\SshConnect;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author      J. Dolieslager
 * @category    FeGit
 * @package     Service
 */
class Initializers
{
    public static function sshConnect($instance, ServiceLocatorInterface $locator)
    {
        if ($instance instanceOf SshConnect) {
            /** @var SshConnect $instance */
            $instance->getPluginManager()->registerPlugin('git', 'FeGit\Plugin');
        }
    }
}
