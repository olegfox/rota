<?php

namespace Site\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Site\MainBundle\Entity\Gallery
 *
 * @ORM\Table(name="gallery")
 * @ORM\Entity(repositoryClass="Site\MainBundle\Entity\Repository\GalleryRepository")
 */
class Gallery
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="datetime", type="date", nullable=false)
     */
    private $date;

    /**
     * Ссылка на видео в форме
     **/
    private $videoUrl;

    /**
     * Список фото из формы
     **/
    private $gallery;

    /**
     * @ORM\OneToMany(targetEntity="GalleryElementPhoto", mappedBy="gallery", cascade={"persist", "remove"})
     **/
    private $galleryElementPhotos;

    /**
     * @ORM\OneToMany(targetEntity="GalleryElementVideo", mappedBy="gallery", cascade={"persist", "remove"})
     **/
    private $galleryElementVideo;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->galleryElementPhotos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->galleryElementVideo = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Gallery
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Add galleryElementPhotos
     *
     * @param \Site\MainBundle\Entity\GalleryElementPhoto $galleryElementPhotos
     * @return Gallery
     */
    public function addGalleryElementPhoto(\Site\MainBundle\Entity\GalleryElementPhoto $galleryElementPhotos)
    {
        $this->galleryElementPhotos[] = $galleryElementPhotos;

        return $this;
    }

    /**
     * Remove galleryElementPhotos
     *
     * @param \Site\MainBundle\Entity\GalleryElementPhoto $galleryElementPhotos
     */
    public function removeGalleryElementPhoto(\Site\MainBundle\Entity\GalleryElementPhoto $galleryElementPhotos)
    {
        $this->galleryElementPhotos->removeElement($galleryElementPhotos);
    }

    /**
     * Get galleryElementPhotos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGalleryElementPhotos()
    {
        return $this->galleryElementPhotos;
    }

    /**
     * Add galleryElementVideo
     *
     * @param \Site\MainBundle\Entity\GalleryElementVideo $galleryElementVideo
     * @return Gallery
     */
    public function addGalleryElementVideo(\Site\MainBundle\Entity\GalleryElementVideo $galleryElementVideo)
    {
        $this->galleryElementVideo[] = $galleryElementVideo;

        return $this;
    }

    /**
     * Remove galleryElementVideo
     *
     * @param \Site\MainBundle\Entity\GalleryElementVideo $galleryElementVideo
     */
    public function removeGalleryElementVideo(\Site\MainBundle\Entity\GalleryElementVideo $galleryElementVideo)
    {
        $this->galleryElementVideo->removeElement($galleryElementVideo);
    }

    /**
     * Get galleryElementVideo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGalleryElementVideo()
    {
        return $this->galleryElementVideo;
    }

    public function setVideoUrl($videoUrl)
    {
        $this->videoUrl = $videoUrl;

        return $this;
    }

    public function getVideoUrl()
    {
        return $this->videoUrl;
    }

    public function getGallery()
    {
        return $this->gallery;
    }

    public function setGallery($gallery)
    {
        $this->gallery = $gallery;

        return $this;
    }
}
