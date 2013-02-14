<?php
namespace FeGit;

use Zend\Loader\AutoloaderFactory;
use Zend\Loader\StandardAutoloader;

/**
 * @author  J. Dolieslager
 * @package FeGit
 */
class Module
{
    public function getConfig()
    {
        return require __DIR__ . '/../../config/zf2.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            AutoloaderFactory::STANDARD_AUTOLOADER => array(
                StandardAutoloader::LOAD_NS => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }
}
