<?php
namespace FeGit\Remote\Lists;

/**
 * @author      J. Dolieslager
 * @category    FeGit
 * @package     Remote
 * @subpackage  Lists
 */
class Entry
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $pushUrl;

    /**
     * @var string
     */
    protected $fetchUrl;

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
     * @param string $pushUrl
     * @return self
     */
    public function setPushUrl($pushUrl)
    {
        $this->pushUrl = $pushUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getPushUrl()
    {
        return $this->pushUrl;
    }

    /**
     * @param string $fetchUrl
     * @return self
     */
    public function setFetchUrl($fetchUrl)
    {
        $this->fetchUrl = $fetchUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getFetchUrl()
    {
        return $this->fetchUrl;
    }

}
