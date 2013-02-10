<?php
namespace FeGit\Fetch;

use FeGit\AbstractPlugin;
use FeSshConnect\Exception;

/**
 * @author      J. Dolieslager
 * @category    FeGit
 * @package     Fetch
 */
class Plugin extends AbstractPlugin
{
    /**
     * Fetch a single repository
     *
     * @param  string      $gitDirectory   The directory that holds the .git folder
     * @param  mixed       $repository     A repository name
     * @param  string|null $refspec        Refespec
     * @param  booolean    $quiet          Progress is not reported to the standard error stream.
     * @param  booolean    $append         Append ref names and object names of fetched refs to the existing contents of .git/FETCH_HEAD.
     * @param  string|null $depth          Deepen the history of a shallow repository created by git clone
     * @param  booolean    $dryRun         Show what would be done, without making any changes.
     * @param  booolean    $force          When git fetch is used with <rbranch>:<lbranch> refspec, it refuses to update the local branch
     *                                     <lbranch> unless the remote branch <rbranch> it fetches is a descendant of <lbranch>.
     *                                     This option overrides that check.
     * @param  booolean    $keep           Keep downloaded pack.
     * @param  booolean    $noTags         This option disables this automatic tag following.
     * @param  booolean    $updateHeadOk   By default git fetch refuses to update the head which corresponds to the current branch.
     *                                     This flag disables the check.
     * @param  string|null $uploadPack     When given, and the repository to fetch from is handled by git fetch-pack
     * @return booolean
     */
    public function single(
        $gitDirectory,
        $repository   = null,
        $refspec      = null,
        $quiet        = true,
        $append       = false,
        $depth        = null,
        $dryRun       = false,
        $force        = false,
        $keep         = false,
        $noTags       = false,
        $updateHeadOk = false,
        $uploadPack   = null
    ) {
        return $this->fetch(
            $gitDirectory,
            $repository,
            $refspec,
            false,
            false,
            $append,
            $depth,
            $dryRun,
            $force,
            $keep,
            $noTags,
            $updateHeadOk,
            $uploadPack,
            $quiet
        );
    }

    /**
     * Fetch all the repositories
     *
     * @param  string      $gitDirectory   The directory that holds the .git folder
     * @param  booolean    $quiet          Progress is not reported to the standard error stream.
     * @param  booolean    $append         Append ref names and object names of fetched refs to the existing contents of .git/FETCH_HEAD.
     * @param  string|null $depth          Deepen the history of a shallow repository created by git clone
     * @param  booolean    $dryRun         Show what would be done, without making any changes.
     * @param  booolean    $force          When git fetch is used with <rbranch>:<lbranch> refspec, it refuses to update the local branch
     *                                     <lbranch> unless the remote branch <rbranch> it fetches is a descendant of <lbranch>.
     *                                     This option overrides that check.
     * @param  booolean    $keep           Keep downloaded pack.
     * @param  booolean    $noTags         This option disables this automatic tag following.
     * @param  booolean    $updateHeadOk   By default git fetch refuses to update the head which corresponds to the current branch.
     *                                     This flag disables the check.
     * @param  string|null $uploadPack     When given, and the repository to fetch from is handled by git fetch-pack
     * @return booolean
     */
    public function all(
        $gitDirectory,
        $quiet        = true,
        $append       = false,
        $depth        = null,
        $dryRun       = false,
        $force        = false,
        $keep         = false,
        $noTags       = false,
        $updateHeadOk = false,
        $uploadPack   = null
    ) {
        return $this->fetch(
            $gitDirectory,
            null,
            null,
            true,
            false,
            $append,
            $depth,
            $dryRun,
            $force,
            $keep,
            $noTags,
            $updateHeadOk,
            $uploadPack,
            $quiet
        );
    }

    /**
     * Fetch multiple repositories and/or groups
     *
     * @param  string      $gitDirectory   The directory that holds the .git folder
     * @param  mixed       $repositories   An array with repos and groups to fetch
     * @param  booolean    $quiet          Progress is not reported to the standard error stream.
     * @param  booolean    $append         Append ref names and object names of fetched refs to the existing contents of .git/FETCH_HEAD.
     * @param  string|null $depth          Deepen the history of a shallow repository created by git clone
     * @param  booolean    $dryRun         Show what would be done, without making any changes.
     * @param  booolean    $force          When git fetch is used with <rbranch>:<lbranch> refspec, it refuses to update the local branch
     *                                     <lbranch> unless the remote branch <rbranch> it fetches is a descendant of <lbranch>.
     *                                     This option overrides that check.
     * @param  booolean    $keep           Keep downloaded pack.
     * @param  booolean    $noTags         This option disables this automatic tag following.
     * @param  booolean    $updateHeadOk   By default git fetch refuses to update the head which corresponds to the current branch.
     *                                     This flag disables the check.
     * @param  string|null $uploadPack     When given, and the repository to fetch from is handled by git fetch-pack
     * @param  booolean    $quiet          Progress is not reported to the standard error stream.
     * @return booolean
     */
    public function multiple(
        $gitDirectory,
        array $repositories,
        $quiet        = true,
        $append       = false,
        $depth        = null,
        $dryRun       = false,
        $force        = false,
        $keep         = false,
        $noTags       = false,
        $updateHeadOk = false,
        $uploadPack   = null
    ) {
        return $this->fetch(
            $gitDirectory,
            $repositories,
            null,
            false,
            true,
            $append,
            $depth,
            $dryRun,
            $force,
            $keep,
            $noTags,
            $updateHeadOk,
            $uploadPack,
            $quiet
        );
    }

    /**
     * General execution of fetch
     *
     * @param  string      $gitDirectory   The directory that holds the .git folder
     * @param  mixed       $repository     A repository name, multiple repositories / groups
     * @param  string|null $refspec        Refespec
     * @param  booolean    $all            Fetch all the remote
     * @param  booolean    $multiple       Fetch multiple repositories / groups
     * @param  booolean    $append         Append ref names and object names of fetched refs to the existing contents of .git/FETCH_HEAD.
     * @param  string|null $depth          Deepen the history of a shallow repository created by git clone
     * @param  booolean    $dryRun         Show what would be done, without making any changes.
     * @param  booolean    $force          When git fetch is used with <rbranch>:<lbranch> refspec, it refuses to update the local branch
     *                                     <lbranch> unless the remote branch <rbranch> it fetches is a descendant of <lbranch>.
     *                                     This option overrides that check.
     * @param  booolean    $keep           Keep downloaded pack.
     * @param  booolean    $noTags         This option disables this automatic tag following.
     * @param  booolean    $updateHeadOk   By default git fetch refuses to update the head which corresponds to the current branch.
     *                                     This flag disables the check.
     * @param  string|null $uploadPack     When given, and the repository to fetch from is handled by git fetch-pack
     * @param  booolean    $quiet          Progress is not reported to the standard error stream.
     * @return booolean
     */
    protected function fetch(
        $gitDirectory,
        $repository   = null,
        $refspec      = null,
        $all          = false,
        $multiple     = false,
        $append       = false,
        $depth        = null,
        $dryRun       = false,
        $force        = false,
        $keep         = false,
        $noTags       = false,
        $updateHeadOk = false,
        $uploadPack   = null,
        $quiet        = true
    ) {
        $command = "cd {$gitDirectory}; git fetch ";

        if ($all === true) {
            $command .= '--all ';
        } else if ($multiple === true) {
            $command .= '--multiple ';
        }

        if ($append === true) {
            $command .= '-a ';
        }

        if ($depth !== null) {
            $command .= "--depth={$depth} ";
        }

        if ($dryRun === true) {
            $command .= '--dry-run ';
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

        if ($quiet === true) {
            $command .= '-q ';
        }

        // When array is given we performing a multiple repository fetch
        if (is_array($repository)) {
            $command .= implode(' ', $repository);
        } else {
            $command .= "{$repository} {$refspec}";
        }

        $this->execute($command);
        return true;
    }
}
