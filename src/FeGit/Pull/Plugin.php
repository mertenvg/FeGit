<?php
namespace FeGit\Pull;

use FeGit\AbstractPlugin;
use FeSshConnect\Exception;

/**
 * @author      J. Dolieslager
 * @category    FeGit
 * @package     Pull
 */
class Plugin extends AbstractPlugin
{
    /**
     * Perform an git-fetch and git-merge from a given repository
     *
     * @param  string       $gitDirectory       The directory that holds the .git folder
     *
     * @param  string       $repository         The repository you want to pull from
     *
     * @param  string|null  $refspec            Refspec
     *
     * @param  boolean      $quiet              Operate quietly
     *
     * @param  boolean      $noCommit           Perform the merge but pretend the merge failed
     *                                          and do not autocommit
     *
     * @param  boolean      $noFastForward      Create a merge commit even when the merge
     *                                          resolves as a fast-forward.
     *
     * @param  boolean      $onlyFastForward    Refuse to merge and exit with a non-zero status
     *                                          unless the current HEAD is already up-to-date or
     *                                          the merge can be resolved as a fast-forward.
     *
     * @param  boolean      $noLog              Do not list one-line descriptions from the actual
     *                                          commits being merged.
     *
     * @param  boolean      $noStat             Do not show a diffstat at the end of the merge.
     *
     * @param  string|null  $strategy           Use the given merge strategy
     *
     * @param  string|null  $strategyOption     Pass merge strategy specific option through to
     *                                          the merge strategy.
     *
     * @param  boolean      $rebase             Rebase the current branch on top of the upstream
     *                                          branch after fetching.
     *
     * @param  boolean      $all                Fetch all remotes.
     *
     * @param  boolean      $append             Append ref names and object names of fetched refs
     *                                          to the existing contents of .git/FETCH_HEAD
     *
     * @param  string|null  $depth              Deepen the history of a shallow repository created by git clone
     *
     * @param  boolean      $force              When git fetch is used with <rbranch>:<lbranch> refspec,
     *                                          it refuses to update the local branch <lbranch> unless the
     *                                          remote branch <rbranch> it fetches is a descendant of <lbranch>.
     *                                          This option overrides that check.
     *
     * @param  boolean      $keep               Keep downloaded pack.
     *
     * @param  boolean      $noTags             This option disables this automatic tag following.
     *
     * @param  boolean      $updateHeadOk       By default git fetch refuses to update the head which corresponds
     *                                          to the current branch. This flag disables the check.
     *
     * @param  string|null  $uploadPack         When given, and the repository to fetch from
     *                                          is handled by git fetch-pack, --exec=<upload-pack>
     *                                          is passed to the command to specify non-default path
     *                                          for the command run on the other end.
     *
     * @return boolean
     */
    public function pull(
        $gitDirectory,
        $repository,
        $refspec         = null,
        $quiet           = true,
        $noCommit        = false,
        $noFastForward   = false,
        $onlyFastForward = false,
        $noLog           = false,
        $noStat          = false,
        $strategy        = null,
        $strategyOption  = null,
        $rebase          = false,
        $all             = false,
        $append          = false,
        $depth           = null,
        $force           = false,
        $keep            = false,
        $noTags          = false,
        $updateHeadOk    = false,
        $uploadPack      = null
    ) {
        $command = "cd {$gitDirectory}; git pull ";

        if ($quiet === true) {
            $command .= '-q ';
        }

        if ($noCommit === true) {
            $command .= '--no-commit ';
        }

        if ($noFastForward === true) {
            $command .= '--no-ff ';
        }

        if ($onlyFastForward === true) {
            $command .= '--ff-only ';
        }

        if ($noLog === true) {
            $command .= '--no-log ';
        }

        if ($noStat === true) {
            $command .= '--no-stat ';
        }

        if ($strategy !== null) {
            $command .= "-s {$strategy} ";
        }

        if ($strategyOption !== null) {
            $command .= "-X {$strategyOption} ";
        }

        if ($rebase === true) {
            $command .= '--rebase ';
        }

        if ($all === true) {
            $command .= '--all ';
        }

        if ($depth !== null) {
            $command .= "--depth={$depth} ";
        }

        if ($force === true) {
            $command .= '-f ';
        }

        if ($keep === true) {
            $command .= '-k ';
        }

        if ($noTags === true) {
            $command .= '--no-tags ';
        }

        if ($updateHeadOk === true) {
            $command .= '-u ';
        }

        if ($uploadPack !== null) {
            $command .= "--upload-pack {$uploadPack} ";
        }

        $command .= "{$repository} {$refspec}";

        $this->execute($command);

        return true;
    }
}
