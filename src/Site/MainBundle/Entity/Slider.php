<?php

namespace Site\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Site\MainBundle\Entity\Slider
 *
 * @ORM\Table(name="slider")
 * @ORM\Entity(repositoryClass="Site\MainBundle\Entity\Repository\SliderRepository")
 */
class Slider
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img;

    /**
     * @ORM\ManyToOne(targetEntity="News", inversedBy="slider")
     * @ORM\JoinColumn(name="news_id", referencedColumnName="id")
     **/
    private $news;

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
     * Set img
     *
     * @param string $img
     * @return Slider
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string 
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set news
     *
     * @param \Site\MainBundle\Entity\News $news
     * @return Slider
     */
    public function setNews(\Site\MainBundle\Entity\News $news = null)
    {
        $this->news = $news;

        return $this;
    }

    /**
     * Get news
     *
     * @return \Site\MainBundle\Entity\News 
     */
    public function getNews()
    {
        return $this->news;
    }
}
