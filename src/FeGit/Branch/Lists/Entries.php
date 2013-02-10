<?php
namespace FeGit\Branch\Lists;

/**
 * @author      J. Dolieslager
 * @category    FeGit
 * @package     Branch
 * @subpackage  Lists
 *
 * @method Entry current
 */
class Entries extends \ArrayObject
{
    /**
     * @var Entry
     */
    protected $activeEntry;

    /**
     * @param Entry $activeEntry
     * @return Entries
     */
    public function setActiveEntry(Entry $activeEntry)
    {
        $this->activeEntry = $activeEntry;

        return $this;
    }

    /**
     * @return Entry
     */
    public function getActiveEntry()
    {
        return $this->activeEntry;
    }

}
