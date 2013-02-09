<?php
namespace FeGit;

use FeSshConnect\Adapter\Adapter;
use FeSshConnect\Exception;
use FeSshConnect\Plugin\PluginInterface;

class Plugin implements PluginInterface
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function cloneRepo($targetDirectory, $url, $quiet = false)
    {
        $workingDirectory = dirname($targetDirectory);
        $folder           = basename($targetDirectory);

        $command = "cd {$workingDirectory}; git clone ";
        if ($quiet === true) {
            $command .= "-q ";
        }

        $command .= "{$url} {$folder}";

        return $this->execute($command);
    }

    public function checkout(
        $gitDirectory,
        $branch,
        $createBranch      = false,
        $quiet             = false,
        $force             = false,
        $mergeLocalChanges = false
    ) {
        $command = "cd {$gitDirectory}; git checkout ";

        if ($quiet === true) {
            $command .= "-q ";
        }

        if ($force === true) {
            $command .= "-f ";
        }

        if ($mergeLocalChanges === true) {
            $command .= "-m ";
        }

        $command .= "{$branch}";

        return $this->execute($command);
    }

    public function pull(
        $gitDirectory,
        $refSpec,
        $quiet      = false,
        $noCommit   = false,
        $rebase     = false,
        $fetchAll   = false,
        $force      = false
    ) {
        $command = "cd {$gitDirectory}; git pull ";

        if ($quiet === true) {
            $command .= "-q ";
        }

        if ($noCommit === true) {
            $command .= "--no-commit ";
        }

        if ($rebase === true) {
            $command .= "--rebase ";
        }

        if ($fetchAll === true) {
            $command .= "--all ";
        }

        if ($force === true) {
            $command .= "-f ";
        }

        $command .= $refSpec;

        return $this->execute($command);
    }

    public function fetch(
        $gitDirectory,
        $refSpec,
        $quiet      = false,
        $dryRun     = false,
        $fetchAll   = false,
        $append     = false,
        $force      = false,
        $keep       = false,
        $prune      = false,
        $noTags     = false,
        $allTags    = false
    ) {
        $command = "cd {$gitDirectory}; git fetch ";

        if ($quiet === true) {
            $command .= "-q ";
        }

        if ($dryRun === true) {
            $command .= "--dry-run ";
        }

        if ($fetchAll === true) {
            $command .= "--all ";
        }

        if ($append === true) {
            $command .= "-a ";
        }

        if ($force === true) {
            $command .= "-f ";
        }

        if ($keep === true) {
            $command .= "-k ";
        }

        if ($prune === true) {
            $command .= "-p ";
        }

        if ($noTags === true) {
            $command .= "--no-tags ";
        }

        if ($allTags === true) {
            $command .= "--tags ";
        }

        $command .= $refSpec;

        return $this->execute($command);
    }

    public function merge(
        $gitDirectory,
        $refSpec,
        $quiet      = false,
        $noCommit   = false,
        $abort      = false
    ) {
        $command = "cd {$gitDirectory}; git fetch ";

        if ($quiet === true) {
            $command .= "-q ";
        }

        if ($noCommit === true) {
            $command .= "--no-commit ";
        }

        if ($abort === true) {
            $command .= "--abort ";
        }

        $command .= $refSpec;

        return $this->execute($command);
    }


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
