<?php
namespace FeGit\Tag\Lists;

/**
 * @author      J. Dolieslager
 * @category    FeGit
 * @package     Tag
 * @subpackage  Lists
 */
class Entry
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
