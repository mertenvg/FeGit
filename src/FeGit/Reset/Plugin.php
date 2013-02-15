<?php
namespace FeGit\Reset;

use FeGit\AbstractPlugin;
use FeSshConnect\Exception;

/**
 * @author      J. Dolieslager
 * @category    FeGit
 * @package     Reset
 */
class Plugin extends AbstractPlugin
{
    /**
     * This form resets the index entries for all <paths> to their state at <commit>.
     * (It does not affect the working tree, nor the current branch.)
     *
     * @param  string      $gitDirectory The directory that holds the .git folder
     * @param  boolean     $quiet        Be quiet, only report errors.
     * @param  string|null $commit       The <commit> defaults to HEAD in all forms.
     * @param  string|null $paths
     * @return boolean TRUE on success
     */
    public function normal($gitDirectory, $quiet = false, $commit = null, $paths = null)
    {
        return $this->general(
            $gitDirectory,
            null,
            $quiet,
            $commit,
            $paths
        );
    }

    /**
     * Interactively select hunks in the difference between the index and <commit>
     * (defaults to HEAD). The chosen hunks are applied in reverse to the index.
     *
     * @param  string      $gitDirectory The directory that holds the .git folder
     * @param  boolean     $quiet        Be quiet, only report errors.
     * @param  string|null $commit       The <commit> defaults to HEAD in all forms.
     * @param  string|null $paths
     * @return boolean TRUE on success
     */
    public function patch($gitDirectory, $quiet = true, $commit = null, $paths = null)
    {
        return $this->general(
            $gitDirectory,
            'patch',
            $quiet,
            $commit,
            $paths
        );
    }

    /**
     * Does not touch the index file nor the working tree at all
     * (but resets the head to <commit>, just like all modes do). This leaves
     * all your changed files "Changes to be committed", as git status would put it.
     *
     * @param  string      $gitDirectory The directory that holds the .git folder
     * @param  boolean     $quiet        Be quiet, only report errors.
     * @param  string|null $commit       The <commit> defaults to HEAD in all forms.
     * @return boolean TRUE on success
     */
    public function soft($gitDirectory, $quiet = true, $commit = null)
    {
        return $this->general(
            $gitDirectory,
            'soft',
            $quiet,
            $commit,
            null
        );
    }

    /**
     * Resets the index but not the working tree (i.e., the changed files are
     * preserved but not marked for commit) and reports what has not been updated.
     * This is the default action.
     *
     * @param  string      $gitDirectory The directory that holds the .git folder
     * @param  boolean     $quiet        Be quiet, only report errors.
     * @param  string|null $commit       The <commit> defaults to HEAD in all forms.
     * @return boolean TRUE on success
     */
    public function mixed($gitDirectory, $quiet = true, $commit = null)
    {
        return $this->general(
            $gitDirectory,
            'mixed',
            $quiet,
            $commit,
            null
        );
    }

    /**
     * Resets the index and working tree. Any changes to tracked files in the
     * working tree since <commit> are discarded.
     *
     * @param  string      $gitDirectory The directory that holds the .git folder
     * @param  boolean     $quiet        Be quiet, only report errors.
     * @param  string|null $commit       The <commit> defaults to HEAD in all forms.
     * @return boolean TRUE on success
     */
    public function hard($gitDirectory, $quiet = true, $commit = null)
    {
        return $this->general(
            $gitDirectory,
            'hard',
            $quiet,
            $commit,
            null
        );
    }

    /**
     * Resets the index and updates the files in the working tree that are
     * different between <commit> and HEAD, but keeps those which are different
     * between the index and working tree (i.e. which have changes which have
     * not been added). If a file that is different between <commit> and the
     * index has unstaged changes, reset is aborted.
     *
     * @param  string      $gitDirectory The directory that holds the .git folder
     * @param  boolean     $quiet        Be quiet, only report errors.
     * @param  string|null $commit       The <commit> defaults to HEAD in all forms.
     * @return boolean TRUE on success
     */
    public function merge($gitDirectory, $quiet = true, $commit = null)
    {
        return $this->general(
            $gitDirectory,
            'merge',
            $quiet,
            $commit,
            null
        );
    }

    /**
     * Resets index entries and updates files in the working tree that are
     * different between <commit> and HEAD. If a file that is different between
     * <commit> and HEAD has local changes, reset is aborted.
     *
     * @param  string      $gitDirectory The directory that holds the .git folder
     * @param  boolean     $quiet        Be quiet, only report errors.
     * @param  string|null $commit       The <commit> defaults to HEAD in all forms.
     * @return boolean TRUE on success
     */
    public function keep($gitDirectory, $quiet = true, $commit = null)
    {
        return $this->general(
            $gitDirectory,
            'keep',
            $quiet,
            $commit,
            null
        );
    }

    /**
     * General method for the reset
     *
     * @param  string      $gitDirectory The directory that holds the .git folder
     * @param  string      $mode         The mode of the reset (patch, soft, hard, mixed, merge, keep)
     * @param  boolean     $quiet        Be quiet, only report errors.
     * @param  string|null $commit       The <commit> defaults to HEAD in all forms.
     * @param  string|null $paths
     * @return boolean TRUE on success
     */
    protected function general(
        $gitDirectory,
        $mode   = null,
        $quiet  = false,
        $commit = null,
        $paths  = null
    ) {
        $command = "cd {$gitDirectory}; git reset ";

        if ($mode !== null) {
            $command .= "--{$mode} ";
        }

        if ($quiet === true) {
            $command .= '-q ';
        }

        if ($commit !== null) {
            $command .= "{$commit} ";
        }

        if ($paths !== null) {
            $command .= $paths;
        }

        $this->execute($command);

        return true;
    }
}
