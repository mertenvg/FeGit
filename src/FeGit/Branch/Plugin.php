<?php
namespace FeGit\Branch;

use FeGit\AbstractPlugin;
use FeSshConnect\Exception;

/**
 * @author      J. Dolieslager
 * @category    FeGit
 * @package     Branch
 */
class Plugin extends AbstractPlugin
{
    /**
     * Get a list of branches
     *
     * @param  string        $gitDirectory The directory that holds the .git folder
     * @return Lists\Entries
     */
    public function lists($gitDirectory)
    {
        $command = "cd {$gitDirectory}; git branch --list";
        $result  = trim($this->execute($command));
        $lines   = explode("\n", $result);
        $entries = new Lists\Entries();

        foreach ($lines as $line) {
            $entry = new Lists\Entry();
            $entries->append($entry);

            if ($line[0] === '*') {
                $entry->setActive(true);
                $entries->setActiveEntry($entry);
                $line = substr($line, 2);
            }

            $entry->setName($line);
        }

        return $entries;
    }

    /**
     * Delete a branch
     *
     * @param  string  $gitDirectory       The directory that holds the .git folder
     * @param  string  $branch             The name of the branch
     * @param  boolean $ignoreMergedStatus Delete a branch irrespective of its merged status.
     * @param  boolean $deleteRemoteBranch Delete the remote-tracking branches.
     * @return boolean                     TRUE on success
     */
    public function delete(
        $gitDirectory,
        $branch,
        $ignoreMergedStatus = false,
        $deleteRemoteBranch = false
    ) {
        $command = "cd {$gitDirectory}; git branch ";

        if ($ignoreMergedStatus === true) {
            $command .= '-D ';
        } else {
            $command .= '-d ';
        }

        if ($deleteRemoteBranch === true) {
            $command .= '-r ';
        }

        $command .= $branch;

        $this->execute($command);

        return true;
    }

    /**
     * Rename a branch
     *
     * @param  string  $gitDirectory           The directory that holds the .git folder
     * @param  string  $oldBranch              The name of the current branch
     * @param  string  $newBranch              The name for the name branch
     * @param  boolean $overrideExistingBranch Rename a branch even if the new branch name already exists.
     * @return boolean                         TRUE on success
     */
    public function rename($gitDirectory, $oldBranch, $newBranch, $overrideExistingBranch = false)
    {
        $command = "cd {$gitDirectory}; git branch ";

        if ($overrideExistingBranch === true) {
            $command .= "-M ";
        } else {
            $command .= "-m ";
        }

        $command .= "{$oldBranch} {$newBranch}";

        $this->execute($command);

        return true;
    }
}
