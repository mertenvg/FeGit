<?php
namespace FeGit\Cloning;

use FeGit\AbstractPlugin;
use FeSshConnect\Exception;

/**
 * @author      J. Dolieslager
 * @category    FeGit
 * @package     Cloning
 */
class Plugin extends AbstractPlugin
{
    /**
     * Perform a clone from a local repository
     *
     * @param  string      $directory       The directory to clone to
     *
     * @param  string      $repository      The repository path
     *
     * @param  boolean     $quiet           Operate quietly.
     *
     * @param  boolean     $shared          When the repository to clone is on the local machine,
     *                                      instead of using hard links, automatically setup
     *                                      .git/objects/info/alternates to share the objects
     *                                      with the source repository
     *
     * @param  boolean     $noHardLinks     Optimize the cloning process from a repository on a
     *                                      local filesystem by copying files under .git/objects directory.
     *
     * @param  boolean     $noCheckout      No checkout of HEAD is performed after the clone is complete.
     *
     * @param  boolean     $bare            Make a bare GIT repository.
     *
     * @param  boolean     $mirror          Set up a mirror of the source repository.
     *
     * @param  string|null $origin          Instead of using the remote name origin to keep track of the upstream repository
     *
     * @param  string|null $branch          Instead of pointing the newly created HEAD to the branch
     *                                      pointed to by the cloned repository’s HEAD, point to <name> branch instead.
     *                                      In a non-bare repository, this is the branch that will be checked out.
     *
     * @param  string|null $reference       If the reference repository is on the local machine, automatically setup
     *                                      .git/objects/info/alternates to obtain objects from the reference repository.
     *                                      Using an already existing repository as an alternate will require fewer objects
     *                                      to be copied from the repository being cloned, reducing network and local storage costs.
     *
     * @param  string|null $separateGitDir  Instead of placing the cloned repository where it is supposed to be, place the cloned
     *                                      repository at the specified directory, then make a filesytem-agnostic git symbolic link to there.
     *                                      The result is git repository can be separated from working tree.
     *
     * @param  string|null $depth           Create a shallow clone with a history truncated to the specified number of revisions.
     *                                      A shallow repository has a number of limitations (you cannot clone or fetch from it,
     *                                      nor push from nor into it), but is adequate if you are only interested in the recent
     *                                      history of a large project with a long history, and would want to send in fixes as patches.
     *
     * @param  boolean     $recursive       After the clone is created, initialize all submodules within, using their default settings.
     *                                      This is equivalent to running git submodule update --init --recursive immediately
     *                                      after the clone is finished.
     *                                      This option is ignored if the cloned repository does not have a worktree/checkout
     *
     * @return boolean
     */
    public function local(
        $directory,
        $repository,
        $quiet          = true,
        $shared         = false,
        $noHardLinks    = false,
        $noCheckout     = false,
        $bare           = false,
        $mirror         = false,
        $origin         = null,
        $branch         = null,
        $reference      = null,
        $separateGitDir = null,
        $depth          = null,
        $recursive      = false
    ) {
        return $this->cloneIt(
            $directory,
            $repository,
            true,
            $quiet,
            $shared,
            $noHardLinks,
            $noCheckout,
            $bare,
            $mirror,
            $origin,
            $branch,
            null,
            $reference
        );
    }

    /**
     * Perform a clone from a local repository
     *
     * @param  string      $directory       The directory to clone to
     *
     * @param  string      $repository      The repository path
     *
     * @param  boolean     $quiet           Operate quietly.
     *
     * @param  boolean     $noCheckout      No checkout of HEAD is performed after the clone is complete.
     *
     * @param  boolean     $bare            Make a bare GIT repository.
     *
     * @param  boolean     $mirror          Set up a mirror of the source repository.
     *
     * @param  string|null $origin          Instead of using the remote name origin to keep track of the upstream repository
     *
     * @param  string|null $branch          Instead of pointing the newly created HEAD to the branch
     *                                      pointed to by the cloned repository’s HEAD, point to <name> branch instead.
     *                                      In a non-bare repository, this is the branch that will be checked out.
     *
     * @param  string|null $uploadPack      When given, and the repository to clone from is accessed via ssh,
     *                                      this specifies a non-default path for the command run on the other end.
     *
     * @param  string|null $separateGitDir  Instead of placing the cloned repository where it is supposed to be, place the cloned
     *                                      repository at the specified directory, then make a filesytem-agnostic git symbolic link to there.
     *                                      The result is git repository can be separated from working tree.
     *
     * @param  string|null $depth           Create a shallow clone with a history truncated to the specified number of revisions.
     *                                      A shallow repository has a number of limitations (you cannot clone or fetch from it,
     *                                      nor push from nor into it), but is adequate if you are only interested in the recent
     *                                      history of a large project with a long history, and would want to send in fixes as patches.
     *
     * @param  boolean     $recursive       After the clone is created, initialize all submodules within, using their default settings.
     *                                      This is equivalent to running git submodule update --init --recursive immediately
     *                                      after the clone is finished.
     *                                      This option is ignored if the cloned repository does not have a worktree/checkout
     *
     * @return boolean
     */
    public function remote(
        $directory,
        $repository,
        $quiet          = true,
        $noCheckout     = false,
        $bare           = false,
        $mirror         = false,
        $origin         = null,
        $branch         = null,
        $uploadPack     = null,
        $separateGitDir = null,
        $depth          = null,
        $recursive      = false
    ) {
        return $this->cloneIt(
            $directory,
            $repository,
            false,
            $quiet,
            false,
            false,
            $noCheckout,
            $bare,
            $mirror,
            $origin,
            $branch,
            $uploadPack,
            null,
            $separateGitDir,
            $depth,
            $recursive
        );
    }

    /**
     * See above
     */
    protected function cloneIt(
        $directory,
        $repository,
        $local          = false,
        $quiet          = true,
        $shared         = false,
        $noHardLinks    = false,
        $noCheckout     = false,
        $bare           = false,
        $mirror         = false,
        $origin         = null,
        $branch         = null,
        $uploadPack     = null,
        $reference      = null,
        $separateGitDir = null,
        $depth          = null,
        $recursive      = false
    ) {
        $command = "git clone ";

        if ($local === true) {
            $command .= "-l ";
        }

        if ($shared === true) {
            $command .= "-s ";
        }

        if ($noHardLinks === true) {
            $command .= "--no-hardlinks ";
        }

        if ($quiet === true) {
            $command .= "-q ";
        }

        if ($noCheckout === true) {
            $command .= '-n ';
        }

        if ($bare ===  true) {
            $command .= '--bare ';
        }

        if ($mirror === true) {
            $command .= '--mirror ';
        }

        if ($origin !== null) {
            $command .= "-o {$origin} ";
        }

        if ($branch !== null) {
            $command .= "-b {$branch} ";
        }

        if ($uploadPack !== null) {
            $command .= "-u {$uploadPack} ";
        }

        if ($reference !== null) {
            $command .= "--reference {$reference} ";
        }

        if ($separateGitDir !== null) {
            $command .= "--seperate-git-dir={$separateGitDir} ";
        }

        if ($depth !== null) {
            $command .= "--depth {$depth} ";
        }

        if ($recursive === true) {
            $command .= '--recursive ';
        }

        $command .= "{$repository} {$directory}";

        $this->execute($command);

        return true;
    }
}
