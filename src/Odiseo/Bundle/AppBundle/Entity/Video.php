<?php

namespace Odiseo\Bundle\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;

class Video
{
    protected $id;
    protected $title;
    protected $link;
    protected $preference;
    protected $createdAt;
    protected $updatedAt;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    public function setPreference(Preferences $preference)
    {
        $this->preference = $preference;
    }

    public function getPreference()
    {
        return $this->preference;
    }

    public function removePreference()
    {
        $this->preference = null;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function __toString()
    {
        return (string) $this->title;
    }
}