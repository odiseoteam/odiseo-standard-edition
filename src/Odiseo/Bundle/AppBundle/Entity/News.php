<?php

namespace Odiseo\Bundle\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Sylius\Component\Resource\Model\TranslatableInterface;
use Sylius\Component\Resource\Model\TranslatableTrait;


class News
{

    protected $id;
    protected $text;
    protected $textEs;
    protected $preference;
    protected $imageName;
    protected $imageFile;
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
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getTextEs()
    {
        return $this->textEs;
    }

    /**
     * @param mixed $text
     */
    public function setTextEs($text)
    {
        $this->textEs = $text;
    }


    public function getTextLocale($locale)
    {
        if($locale == 'en'){
            return $this->text;
        }else{
            return $this->textEs;
        }
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
        return (string)  substr($this->text,0,15)."...";
    }
}