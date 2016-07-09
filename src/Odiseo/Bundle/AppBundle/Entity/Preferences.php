<?php

namespace Odiseo\Bundle\AppBundle\Entity;

use DateTime;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;


class Preferences
{
    protected $id;
    protected $datetimeCountdown;
    protected $textBiography;
    protected $textCaso;
    protected $textFreeOscar;
    protected $textBiographyEs;
    protected $textCasoEs;
    protected $textFreeOscarEs;
    protected $images;
    protected $news;
    protected $videos;


    public function __construct()
    {
        $this->dateTime = new \DateTime();
        $this->images = new ArrayCollection();
        $this->news = new ArrayCollection();
        $this->videos = new ArrayCollection();
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setImages($images)
    {
        foreach($this->images as $localImages)
        {
            $localImages->removePreference();
        }
        $this->images->clear();

        foreach($images as $image)
        {
            $this->addImage($image);
        }
    }

    public function getImages()
    {
        return $this->images;
    }

    public function addImage(GaleryImage $image)
    {
        $this->images->add($image);
        $image->setPreference($this);
    }

    public function getNews()
    {
        return $this->news;
    }
    public function setNews($news)
    {
        foreach($this->news as $localNews)
        {
            $localNews->removePreference();
        }
        $this->news->clear();

        foreach($news as $notice)
        {
            $this->addNews($notice);
        }
    }

    public function addNews(News $news)
    {
        $this->news->add($news);
        $news->setPreference($this);
    }


    public function getVideos()
    {
        return $this->videos;
    }

    public function setVideos($videos)
    {
        foreach($this->videos as $localVideo)
        {
            $localVideo->removePreference();
        }
        $this->videos->clear();

        foreach($videos as $video)
        {
            $this->addVideo($video);
        }
    }

    public function addVideo($video)
    {
        $this->videos->add($video);
        $video->setPreference($this);
    }

    /**
     * @return mixed
     */
    public function getDatetimeCountdown()
    {
        return $this->datetimeCountdown;
    }

    /**
     * @param mixed $datetimeCountdown
     */
    public function setDatetimeCountdown($datetimeCountdown)
    {
        $this->datetimeCountdown = $datetimeCountdown;
    }

    /**
     * @return mixed
     */
    public function getTextBiography()
    {
        return $this->textBiography;
    }

    /**
     * @param mixed $textBiography
     */
    public function setTextBiography($textBiography)
    {
        $this->textBiography = $textBiography;
    }

    /**
     * @return mixed
     */
    public function getTextCaso()
    {
        return $this->textCaso;
    }

    /**
     * @param mixed $textCaso
     */
    public function setTextCaso($textCaso)
    {
        $this->textCaso = $textCaso;
    }

    /**
     * @return mixed
     */
    public function getTextFreeOscar()
    {
        return $this->textFreeOscar;
    }

    /**
     * @param mixed $textFreeOscar
     */
    public function setTextFreeOscar($textFreeOscar)
    {
        $this->textFreeOscar = $textFreeOscar;
    }

    /**
     * @return mixed
     */
    public function getTextBiographyEs()
    {
        return $this->textBiographyEs;
    }

    /**
     * @param mixed $textBiographyEs
     */
    public function setTextBiographyEs($textBiographyEs)
    {
        $this->textBiographyEs = $textBiographyEs;
    }

    /**
     * @return mixed
     */
    public function getTextCasoEs()
    {
        return $this->textCasoEs;
    }

    /**
     * @param mixed $textCasoEs
     */
    public function setTextCasoEs($textCasoEs)
    {
        $this->textCasoEs = $textCasoEs;
    }

    /**
     * @return mixed
     */
    public function getTextFreeOscarEs()
    {
        return $this->textFreeOscarEs;
    }

    /**
     * @param mixed $textFreeOscarEs
     */
    public function setTextFreeOscarEs($textFreeOscarEs)
    {
        $this->textFreeOscarEs = $textFreeOscarEs;
    }

    public function getTextBiographyLocale($locale)
    {
        if($locale == 'en'){
            return $this->textBiography;
        }else{
            return $this->textBiographyEs;
        }
    }

    public function getTextCasoLocale($locale)
    {
        if($locale == 'en'){
            return $this->textCaso;
        }else{
            return $this->textCasoEs;
        }
    }

    public function getTextFreeOscarLocale($locale)
    {
        if($locale == 'en'){
            return $this->textFreeOscar;
        }else{
            return $this->textFreeOscarEs;
        }
    }
    /**
     * @return DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @param DateTime $dateTime
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;
    }

}