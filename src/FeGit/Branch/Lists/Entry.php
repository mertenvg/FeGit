<?php
namespace FeGit\Branch\Lists;

/**
 * @author      J. Dolieslager
 * @category    FeGit
 * @package     Branch
 * @subpackage  Lists
 */
class Entry
{
    /**
     * @var boolean
     */
    protected $active = false;

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

    /**
     * @param boolean $active
     * @return self
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }
}
