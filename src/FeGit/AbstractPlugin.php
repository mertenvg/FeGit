<?php
namespace FeGit;

use FeSshConnect\Adapter\Adapter;
use FeSshConnect\Exception;
use FeSshConnect\Plugin\PluginInterface;

/**
 * @author      J. Dolieslager
 * @category    FeGit
 */
abstract class AbstractPlugin implements PluginInterface
{
    /**
     * @var Adapter
     */
    protected $adapter;

    /**
     * Execute a simple statement. Throws exception on errors
     * and return response on success
     *
     * @param string $command
     * @return string
     */
    protected function execute($command)
    {
        $response = $this->getAdapter()->execute($command);
        if ($response->hasErrors()) {
            throw new Exception\RuntimeException($response->getErrorResponse());
        }

        return $response->getResponse();
    }

    /**
     * Set the adapter
     *
     * @param Adapter $adapter
     * @return Basic
     */
    public function setAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;

        return $this;
    }

    /**
     * Return the adapter
     *
     * @return Adapter
     */
    public function getAdapter()
    {
        return $this->adapter;
    }
}