<?php
namespace FeGit\Checkout;

use FeGit\AbstractPlugin;
use FeSshConnect\Exception;

/**
 * @author      J. Dolieslager
 * @category    FeGit
 * @package     Checkout
 */
class Plugin extends AbstractPlugin
{

     /**
     * Switch to an existing local branch
     *
     * @param string        $gitDirectory       The directory that holds the .git folder
     * @param string        $branchName         The name of the new branch
     * @param boolean       $quiet              Quiet, suppress feedback messages.
     *
     * @param boolean       $force              When switching branches, proceed even if the index
     *                                          or the working tree differs from HEAD.
     *                                          This is used to throw away local changes.
     *
     * @param boolean       $merge              a three-way merge between the current branch,
     *                                          your working tree contents, and the new branch is done,
     *                                          and you will be on the new branch.
     * @return string
     */
    public function switchBranch(
        $gitDirectory,
        $branchName,
        $quiet          = true,
        $force          = false,
        $merge          = false
    ) {
        $command = "cd {$gitDirectory}; git checkout ";

        if ($quiet === true) {
            $command .= "-q ";
        }

        if ($force === true) {
            $command .= "-f ";
        }

        if ($merge === true) {
            $command .= "-m ";
        }

        $command .= $branchName;

        return $this->execute($command);
    }

    /**
     * Creates a new branch
     *
     * @param string        $gitDirectory       The directory that holds the .git folder
     * @param string        $branchName         The name of the new branch
     * @param null|string   $startPoint         The name of a commit at which to start the new branch;
     * @param boolean       $quiet              Quiet, suppress feedback messages.
     *
     * @param boolean       $force              When switching branches, proceed even if the index
     *                                          or the working tree differs from HEAD.
     *                                          This is used to throw away local changes.
     *
     * @param boolean       $merge              a three-way merge between the current branch,
     *                                          your working tree contents, and the new branch is done,
     *                                          and you will be on the new branch.
     *
     * @param boolean       $switchOnExists     if it already exists, then reset it to <start_point>.
     *
     * @param boolean       $createOrphan       The first commit made on this new branch will have no parents
     *                                          and it will be the root of a new history totally disconnected
     *                                          from all the other branches and commits.
     * @return string
     */
    public function createBranch(
        $gitDirectory,
        $branchName,
        $startPoint     = null,
        $quiet          = true,
        $force          = false,
        $merge          = false,
        $switchOnExists = false,
        $createOrphan   = false
    ) {
        $command = "cd {$gitDirectory}; git checkout ";

        if ($quiet === true) {
            $command .= "-q ";
        }

        if ($force === true) {
            $command .= "-f ";
        }

        if ($merge === true) {
            $command .= "-m ";
        }

        // Only one of the three can be set
        if ($createOrphan === true) {
            $command .= "--orphan ";
        } else if ($switchOnExists === true) {
            $command .= "-B ";
        } else {
            $command .= "-b ";
        }

        $command .= $branchName;

        if ($startPoint !== null) {
            $command .= " {$startPoint}";
        }

        return $this->execute($command);
    }
}
