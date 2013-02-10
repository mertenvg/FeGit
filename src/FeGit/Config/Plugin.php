<?php
namespace FeGit\Config;

use FeGit\AbstractPlugin;
use FeSshConnect\Exception;

/**
 * @author      J. Dolieslager
 * @category    FeGit
 * @package     Config
 */
class Plugin extends AbstractPlugin
{

    /**
     * Holds all the exception that this class can throw
     *
     * @var array
     */
    private static $exceptions = array(
        1 => "Scope '%s' does not exists. Use local, global or system",
        2 => "Could not parse config line '%s'.",
    );

    /**
     * Get an config value(s) from the repository
     *
     * @param string  $gitDirectory The directory that holds the .git folder
     * @param string $needle        The key that you want
     * @param boolean $list         When TRUE all the key/value pairs will be returned
     * @param mixed $scope          The scope to look in: local, system or global
     * @param mixed $regex          The regex you want to use to grep multiple values
     * @return Get\Entries
     */
    public function get($gitDirectory, $needle, $list = false, $scope = 'local', $regex = null)
    {
        $command = "cd {$gitDirectory}; git config ";
        $command = $this->configSetScopeOption($command, $scope);

        // When using list ignore other get parameters
        if ($list === true) {
            $command .= '-l ';
        } else {
            if ($regex !== null) {
                $command .= '--get-regexp ';
            } else {
                $command .= '--get ';
            }

            $command .= $needle;
        }

        // Execute command
        $result  = trim($this->execute($command));

        // Explode on EOL
        $lines   = explode("\n", $result);

        // Create result object
        $entries = new Get\Entries();

        foreach ($lines as $line) {
            // Create entry object
            $entry = new Get\Entry();
            $entry->setScope($scope);

            // Append entry to the list
            $entries->append($entry);

            // In list mode we need to extract the key
            if ($list === true || $regex !== null) {
                // List use = as separator, not a space
                $separator = $list ? '=' : '\s';
                if (!preg_match("/^([^{$separator}]+){$separator}(.*)\$/", $line, $matches)) {
                    throw new Exception\RuntimeException(
                        sprintf(self::$exceptions[2], $line),
                        2
                    );
                }
                $entry->setKey($matches[1])->setValue($matches[2]);
            } else {
                $entry->setKey($needle)->setValue(trim($line));
            }
        }

        return $entries;
    }

    /**
     * Add a new key/value pair to the config. This will not override existing values
     *
     * @param   string  $gitDirectory   The directory that holds the .git folder
     * @param   string  $key            The key that holds the value
     * @param   string  $value          The value you want to set
     * @param   string  $scope          The scope to look in: local, system or global
     * @return  boolean TRUE            on success
     */
    public function add($gitDirectory, $key, $value, $scope = 'local')
    {
        // Build command string
        $command  = "cd {$gitDirectory}; git config ";
        $command  = $this->configSetScopeOption($command, $scope);
        $command .= "--add {$key} {$value}";

        // Execute command
        $this->execute($command);

        // Return true on success
        return true;
    }

    /**
     * Remove a whole section from the config
     *
     * @param   string  $gitDirectory   The directory that holds the .git folder
     * @param   string  $key            The key that holds the value
     * @param   string  $scope          The scope to look in: local, system or global
     * @return  boolean TRUE            on success
     */
    public function removeSection($gitDirectory, $key, $scope = 'local')
    {
        // Build command string
        $command  = "cd {$gitDirectory}; git config ";
        $command  = $this->configSetScopeOption($command, $scope);
        $command .= "--remove-section {$key}";

        // Execute command
        $this->execute($command);

        // Return true on success
        return true;
    }

    /**
     * Unset a single entry from a section
     *
     * @param   string  $gitDirectory   The directory that holds the .git folder
     * @param   string  $key            The key that holds the value
     * @param   string  $scope          The scope to look in: local, system or global
     * @return  boolean TRUE            on success
     */
    public function unsetKey($gitDirectory, $key, $scope = 'local')
    {
        // Build command string
        $command  = "cd {$gitDirectory}; git config ";
        $command  = $this->configSetScopeOption($command, $scope);
        $command .= "--unset {$key}";

        // Execute command
        $this->execute($command);

        // Return true on success
        return true;
    }

    /**
     * Creates the scope option
     *
     * @param string $command
     * @param string $scope
     * @return string The new command string
     */
    protected function configSetScopeOption($command, $scope)
    {
        switch ($scope) {
            case 'global':
                $command .= '--global ';
                break;
            case 'system':
                $command .= '--system ';
                break;
            case 'local':
                $command .= '--local ';
                break;
            default:
                throw new Exception\InvalidArgumentException(
                    sprintf(self::$exceptions[1], $scope),
                    1
                );
        }

        return $command;
    }
}
