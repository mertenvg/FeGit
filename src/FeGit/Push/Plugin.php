<?php
namespace FeGit\Push;

use FeGit\AbstractPlugin;

/**
 * @author  J. Dolieslager
 * @package FeGit
 * @package Push
 */
class Plugin extends AbstractPlugin
{
    /**
     * Push on a normal way
     *
     * @param  string      $gitDirectory The directory that holds the .git folder
     * @param  string      $repository   The repository you want to update
     * @param  string|null $refspec      The refspec
     * @param  boolean     $quiet        Suppress all output, including the listing of
     *                                   updated refs, unless an error occurs.
     * @param  boolean     $force        Usually, the command refuses to update a remote ref
     *                                   that is not an ancestor of the local ref used to
     *                                   overwrite it. This flag disables the check.
     *                                   This can cause the remote repository to lose
     *                                   commits; use it with care.
     * @param  boolean     $dryRun       Do everything except actually send the updates.
     * @param  boolean     $porceLain    Produce machine-readable output. The output status
     *                                   line for each ref will be tab-separated and sent
     *                                   to stdout instead of stderr.
     * @param  boolean     $noThin       A thin transfer significantly reduces the amount
     *                                   of sent data when the sender and receiver share
     *                                   many of the same objects in common.
     * @return boolean
     */
    public function normal(
        $gitDirectory,
        $repository,
        $refspec   = null,
        $quiet     = true,
        $force     = false,
        $dryRun    = false,
        $porceLain = false,
        $noThin    = false
    ) {
        return $this->general(
            $gitDirectory,
            $repository,
            $refspec,
            null,
            $quiet,
            $force,
            $dryRun,
            $porceLain,
            $noThin
        );
    }

    /**
     * Instead of naming each ref to push, specifies that all refs under refs/heads/ be pushed.
     *
     * @param  string      $gitDirectory The directory that holds the .git folder
     * @param  string      $repository   The repository you want to update
     * @param  string|null $refspec      The refspec
     * @param  boolean     $quiet        Suppress all output, including the listing of
     *                                   updated refs, unless an error occurs.
     * @param  boolean     $force        Usually, the command refuses to update a remote ref
     *                                   that is not an ancestor of the local ref used to
     *                                   overwrite it. This flag disables the check.
     *                                   This can cause the remote repository to lose
     *                                   commits; use it with care.
     * @param  boolean     $dryRun       Do everything except actually send the updates.
     * @param  boolean     $porceLain    Produce machine-readable output. The output status
     *                                   line for each ref will be tab-separated and sent
     *                                   to stdout instead of stderr.
     * @param  boolean     $noThin       A thin transfer significantly reduces the amount
     *                                   of sent data when the sender and receiver share
     *                                   many of the same objects in common.
     * @return boolean
     */
    public function all(
        $gitDirectory,
        $repository,
        $refspec   = null,
        $quiet     = true,
        $force     = false,
        $dryRun    = false,
        $porceLain = false,
        $noThin    = false
    ) {
        return $this->general(
            $gitDirectory,
            $repository,
            $refspec,
            'all',
            $quiet,
            $force,
            $dryRun,
            $porceLain,
            $noThin
        );
    }

    /**
     *  Instead of naming each ref to push, specifies that all refs under refs/
     *  (which includes but is not limited to refs/heads/, refs/remotes/, and refs/tags/)
     *  be mirrored to the remote repository. Newly created local refs will be pushed to
     *  the remote end, locally updated refs will be force updated on the remote end,
     *  and deleted refs will be removed from the remote end. This is the default
     *  if the configuration option remote.<remote>.mirror is set.
     *
     * @param  string      $gitDirectory The directory that holds the .git folder
     * @param  string      $repository   The repository you want to update
     * @param  string|null $refspec      The refspec
     * @param  boolean     $quiet        Suppress all output, including the listing of
     *                                   updated refs, unless an error occurs.
     * @param  boolean     $force        Usually, the command refuses to update a remote ref
     *                                   that is not an ancestor of the local ref used to
     *                                   overwrite it. This flag disables the check.
     *                                   This can cause the remote repository to lose
     *                                   commits; use it with care.
     * @param  boolean     $dryRun       Do everything except actually send the updates.
     * @param  boolean     $porceLain    Produce machine-readable output. The output status
     *                                   line for each ref will be tab-separated and sent
     *                                   to stdout instead of stderr.
     * @param  boolean     $noThin       A thin transfer significantly reduces the amount
     *                                   of sent data when the sender and receiver share
     *                                   many of the same objects in common.
     * @return boolean
     */
    public function mirror(
        $gitDirectory,
        $repository,
        $refspec   = null,
        $quiet     = true,
        $force     = false,
        $dryRun    = false,
        $porceLain = false,
        $noThin    = false
    ) {
        return $this->general(
            $gitDirectory,
            $repository,
            $refspec,
            'mirror',
            $quiet,
            $force,
            $dryRun,
            $porceLain,
            $noThin
        );
    }

    /**
     *  All refs under refs/tags are pushed, in addition to refspecs
     *  explicitly listed on the command line.
     *
     * @param  string      $gitDirectory The directory that holds the .git folder
     * @param  string      $repository   The repository you want to update
     * @param  string|null $refspec      The refspec
     * @param  boolean     $quiet        Suppress all output, including the listing of
     *                                   updated refs, unless an error occurs.
     * @param  boolean     $force        Usually, the command refuses to update a remote ref
     *                                   that is not an ancestor of the local ref used to
     *                                   overwrite it. This flag disables the check.
     *                                   This can cause the remote repository to lose
     *                                   commits; use it with care.
     * @param  boolean     $dryRun       Do everything except actually send the updates.
     * @param  boolean     $porceLain    Produce machine-readable output. The output status
     *                                   line for each ref will be tab-separated and sent
     *                                   to stdout instead of stderr.
     * @param  boolean     $noThin       A thin transfer significantly reduces the amount
     *                                   of sent data when the sender and receiver share
     *                                   many of the same objects in common.
     * @return boolean
     */
    public function tags(
        $gitDirectory,
        $repository,
        $refspec   = null,
        $quiet     = true,
        $force     = false,
        $dryRun    = false,
        $porceLain = false,
        $noThin    = false
    ) {
        return $this->general(
            $gitDirectory,
            $repository,
            $refspec,
            'tags',
            $quiet,
            $force,
            $dryRun,
            $porceLain,
            $noThin
        );
    }

    /**
     * All listed refs are deleted from the remote repository.
     *
     * @param  string      $gitDirectory The directory that holds the .git folder
     * @param  string      $repository   The repository you want to update
     * @param  string|null $refspec      The refspec
     * @param  boolean     $quiet        Suppress all output, including the listing of
     *                                   updated refs, unless an error occurs.
     * @param  boolean     $force        Usually, the command refuses to update a remote ref
     *                                   that is not an ancestor of the local ref used to
     *                                   overwrite it. This flag disables the check.
     *                                   This can cause the remote repository to lose
     *                                   commits; use it with care.
     * @param  boolean     $dryRun       Do everything except actually send the updates.
     * @param  boolean     $porceLain    Produce machine-readable output. The output status
     *                                   line for each ref will be tab-separated and sent
     *                                   to stdout instead of stderr.
     * @param  boolean     $noThin       A thin transfer significantly reduces the amount
     *                                   of sent data when the sender and receiver share
     *                                   many of the same objects in common.
     * @return boolean
     */
    public function delete(
        $gitDirectory,
        $repository,
        $refspec   = null,
        $quiet     = true,
        $force     = false,
        $dryRun    = false,
        $porceLain = false,
        $noThin    = false
    ) {
        return $this->general(
            $gitDirectory,
            $repository,
            $refspec,
            'delete',
            $quiet,
            $force,
            $dryRun,
            $porceLain,
            $noThin
        );
    }

    /**
     * General method for executing the command
     *
     * @param  string      $gitDirectory The directory that holds the .git folder
     * @param  string      $repository   The repository you want to update
     * @param  string|null $refspec      The refspec
     * @param  string|null $mode         The mode (delete, all, mirror, tags)
     * @param  boolean     $quiet        Suppress all output, including the listing of
     *                                   updated refs, unless an error occurs.
     * @param  boolean     $force        Usually, the command refuses to update a remote ref
     *                                   that is not an ancestor of the local ref used to
     *                                   overwrite it. This flag disables the check.
     *                                   This can cause the remote repository to lose
     *                                   commits; use it with care.
     * @param  boolean     $dryRun       Do everything except actually send the updates.
     * @param  boolean     $porceLain    Produce machine-readable output. The output status
     *                                   line for each ref will be tab-separated and sent
     *                                   to stdout instead of stderr.
     * @param  boolean     $noThin       A thin transfer significantly reduces the amount
     *                                   of sent data when the sender and receiver share
     *                                   many of the same objects in common.
     * @return boolean
     */
    protected function general (
        $gitDirectory,
        $repository,
        $refspec   = null,
        $mode      = null,
        $quiet     = true,
        $force     = false,
        $dryRun    = false,
        $porceLain = false,
        $noThin    = false
    ) {
        $command = "cd {$gitDirectory}; git push ";

        if ($mode !== null) {
            $command .= "--{$mode} ";
        }

        if ($quiet === true) {
            $command .= '-q ';
        }

        if ($dryRun === true) {
            $command .= '-n ';
        }

        if ($porceLain === true) {
            $command .= '--porcelain ';
        }

        if ($noThin === true) {
            $command .= '--no-thin ';
        }

        $command .= "'{$repository}' {$refspec}";

        $this->execute($command);

        return true;
    }
}
