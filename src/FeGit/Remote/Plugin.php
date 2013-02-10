<?php
namespace FeGit\Remote;

use FeGit\AbstractPlugin;
use FeSshConnect\Exception;

/**
 * @author      J. Dolieslager
 * @category    FeGit
 * @package     Remote
 */
class Plugin extends AbstractPlugin
{
    /**
     * Holds all the exceptions that can be thrown by this class
     *
     * @var array
     */
    private static $exceptions = array(
        1 => 'Could not parse lists line. Line given: %s',
        2 => "url type '%s' is new. Inform developer to update the code.",
        3 => "Mirror can contain value fetch or push. Value given '%s'",
    );

    /**
     * Get a list of remotes with the specified urls
     *
     * @param  string        $gitDirectory The directory that holds the .git folder
     * @return Lists\Entries
     */
    public function lists($gitDirectory)
    {
        $response = trim($this->execute("cd {$gitDirectory};  git remote -v"));
        $lines    = explode("\n", $response);
        $entries  = new Lists\Entries();

        foreach ($lines as $line) {
            if (!preg_match('/^([^\s]+)\s+([^\s]+)\s+\(([^\)]+)\)/', $line, $matches)) {
                throw new Exception\RuntimeException(
                    sprintf(self::$exceptions[1], $line),
                    1
                );
            }

            // If entry already exists we deal with the same remote
            if (array_key_exists($matches[1], $entries)) {
                $entry = $entries[$matches[1]];
            } else {
                // Create entry
                $entry = new Lists\Entry();
                $entry->setName($matches[1]);

                // Add the entry
                $entries[$matches[1]] = $entry;
            }

            // Set the url on the correct property
            switch ($matches[3]) {
                case 'fetch':
                    $entry->setFetchUrl($matches[2]);
                    break;
                case 'push':
                    $entry->setPushUrl($matches[2]);
                    break;
                default:
                    throw new Exception\RuntimeException(
                        sprintf(self::$exceptions[2], $matches[3]),
                        2
                    );
            }
        }

        return $entries;
    }

    /**
     * Add a new remote
     *
     * @param  string      $gitDirectory The directory that holds the .git folder
     * @param  string      $name         The name of the remote
     * @param  string      $url          The location of the remote repository
     * @param  boolean     $fetch        Git fetch <name> is run immediately after the remote information is set up.
     * @param  null|string $branch       A refspec to track only <branch> is created.
     * @param  null|string $master       A symbolic-ref refs/remotes/<name>/HEAD is set up to point at remote’s <master> branch
     * @param  null|string $noTags       Git fetch <name> does not import tags from the remote repository.
     * @param  null|string $mirror       When a fetch mirror is created with --mirror=fetch,
     *                                   the refs will not be stored in the refs/remotes/ namespace,
     *                                   but rather everything in refs/ on the remote will be directly
     *                                   mirrored into refs/ in the local repository.
     *                                   This option only makes sense in bare repositories,
     *                                   because a fetch would overwrite any local commits.
     *                                   When a push mirror is created with --mirror=push,
     *                                   then git push will always behave as if --mirror was passed.
     *
     * @return boolean                   TRUE on success
     */
    public function add(
        $gitDirectory,
        $name,
        $url,
        $fetch  = false,
        $branch = null,
        $master = null,
        $noTags = false,
        $mirror = null
    ) {
        // Check if the mirror parameter is correct
        if ($mirror !== null && $mirror !== 'fetch' && $mirror !== 'push') {
            throw new Exception\InvalidArgumentException(
                sprintf(self::$exceptions[3], $mirror),
                3
            );
        }

        $command = "cd {$gitDirectory}; git remote add ";

        if ($branch !== null) {
            $command .= "-t {$branch} ";
        }

        if ($master !== null) {
            $command .= "-m {$master} ";
        }

        if ($fetch === true) {
            $command .= '-f ';
        }

        if ($noTags === true) {
            $command .= '--no-tags ';
        }

        if ($mirror !== null) {
            $command .= "--mirror={$mirror} ";
        }

        $command .= "{$name} {$url}";

        $this->execute($command);

        return true;
    }

    /**
     * Delete a remote
     *
     * @param  string  $gitDirectory The directory that holds the .git folder
     * @param  string  $name         The name of the remote
     * @return boolean               TRUE on success
     */
    public function delete($gitDirectory, $name)
    {
        $this->execute("cd {$gitDirectory}; git remote rm {$name}");
        return true;
    }

    /**
     * Delete a remote
     *
     * @param  string  $gitDirectory The directory that holds the .git folder
     * @param  string  $oldName      The current name
     * @param  string  $newName      The new name
     * @return boolean               TRUE on success
     */
    public function rename($gitDirectory, $oldName, $newName)
    {
        $this->execute("cd {$gitDirectory}; git remote rename {$oldName} {$newName}");
        return true;
    }
}
