<?php
namespace FeGit\Tag;

use FeGit\AbstractPlugin;

/**
 * @author      J. Dolieslager
 * @category    FeGit
 * @package     Tag
 */
class Plugin extends AbstractPlugin
{
    /**
     * Get a list of branches
     *
     * @param  string        $gitDirectory The directory that holds the .git folder
     * @param  string        $pattern      The pattern is a shell wildcard (i.e., matched using fnmatch(3)).
     *                                     Multiple patterns may be given
     * @return Lists\Entries
     */
    public function lists($gitDirectory, $pattern = null)
    {
        $command = "cd {$gitDirectory}; git tag --list {$pattern}";
        $result  = trim($this->execute($command));
        $lines   = explode("\n", $result);
        $entries = new Lists\Entries();

        // Return empty list on empty result
        if (empty($result)) {
            return $entries;
        }

        foreach ($lines as $line) {
            // Create single entry
            $entry = new Lists\Entry();
            $entry->setName($line);

            // Add entry to the list
            $entries->append($entry);
        }

        return $entries;
    }

    /**
     * Delete a tag
     *
     * @param  string  $gitDirectory The directory that holds the .git folder
     * @param  string  $tag          The name of the tag
     * @return boolean               TRUE on success
     */
    public function delete($gitDirectory, $tag)
    {
        $this->execute("cd {$gitDirectory}; git tag -d {$tag}");
        return true;
    }

    /**
     * Verify the gpg signature of a tag
     *
     * @param  string  $gitDirectory The directory that holds the .git folder
     * @param  string  $tag          The name of the tag
     * @return string
     */
    public function verify($gitDirectory, $tag)
    {
        return $this->execute("cd {$gitDirectory}; git tag -v {$tag}");
    }

    /**
     * Create a new tag
     *
     * @param  string  $gitDirectory The directory that holds the .git folder
     * @param  string  $tagname      The name of the tag
     * @param  string  $message      The message for the tag
     * @param  boolean $signed       Make a GPG-signed tag, using the default e-mail address’s key.
     * @param  boolean $force        Replace an existing tag with the given name (instead of failing)
     * @param  string  $fromCommit   Create a tag till specified commit
     * @return boolean               TRUE on success
     */
    public function create(
        $gitDirectory,
        $tagname,
        $message,
        $signed      = false,
        $force       = false,
        $fromCommit  = null
    ) {
        $command = "cd {$gitDirectory}; git tag ";
        $escaped = filter_var($message, FILTER_SANITIZE_MAGIC_QUOTES);

        if ($signed === true) {
            $command .= '-s ';
        } else {
            $command .= '-a ';
        }

        if ($force === true) {
            $command .= '-f ';
        }
        
        $command .= "-m '{$escaped}' {$tagname} {$fromCommit}";

        $this->execute($command);

        return true;
    }
}
