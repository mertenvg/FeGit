<?php
namespace FeGit;

use FeSshConnect\Exception;

/**
 * @author      J. Dolieslager
 * @category    FeGit
 */
class Plugin extends AbstractPlugin
{
    /**
     * Get the branch plugin
     *
     * @return Branch\Plugin
     */
    public function branch()
    {
        $plugin = new Branch\Plugin();
        $plugin->setAdapter($this->getAdapter());

        return $plugin;
    }

    /**
     * Get the Checkout plugin
     *
     * @return Checkout\Plugin
     */
    public function checkout() {
        $plugin = new Checkout\Plugin();
        $plugin->setAdapter($this->getAdapter());

        return $plugin;
    }

    /**
     * Get the clone plugin
     *
     * @return Cloning\Plugin
     */
    public function cloning()
    {
        $plugin = new Cloning\Plugin();
        $plugin->setAdapter($this->getAdapter());

        return $plugin;
    }

    /**
     * Get the Config plugin
     *
     * @return Config\Plugin
     */
    public function config()
    {
        $plugin = new Config\Plugin();
        $plugin->setAdapter($this->getAdapter());

        return $plugin;
    }

    /**
     * Get the fetch plugin
     *
     * @return Fetch\Plugin
     */
    public function fetch()
    {
        $plugin = new Fetch\Plugin();
        $plugin->setAdapter($this->getAdapter());

        return $plugin;
    }

    /**
     * Get the pull plugin
     *
     * @return Pull\Plugin
     */
    public function pull()
    {
        $plugin = new Pull\Plugin();
        $plugin->setAdapter($this->getAdapter());

        return $plugin;
    }

    /**
     * Get the remote plugin
     *
     * @return Remote\Plugin
     */
    public function remote()
    {
        $plugin = new Remote\Plugin();
        $plugin->setAdapter($this->getAdapter());

        return $plugin;
    }

    /**
     * Get the Tag Plugin
     *
     * @return Tag\Plugin
     */
    public function tag()
    {
        $plugin = new Tag\Plugin();
        $plugin->setAdapter($this->getAdapter());

        return $plugin;
    }
}
