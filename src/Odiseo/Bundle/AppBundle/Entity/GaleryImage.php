<?php

namespace Odiseo\Bundle\AppBundle\Entity;

use Symfony\Component\HttpFoundation\File\File;

class GaleryImage
{
    protected $id;
    protected $name;
    protected $preference;
    protected $imageName;
    protected $imageFile;
    protected $createdAt;
    protected $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
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
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

    public function getImageName()
    {
        return $this->imageName;
    }

    public function setImageFile(File $imageFile)
    {
        if($imageFile instanceof File)
        {
            $this->imageFile = $imageFile;

            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
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
        return (string)$this->getName();
    }
}