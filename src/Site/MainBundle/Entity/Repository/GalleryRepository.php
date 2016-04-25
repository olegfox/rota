<?php

namespace Site\MainBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * GalleryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GalleryRepository extends EntityRepository
{
    public function findAllArray() {
        $gallery = $this->findBy(array(), array('date' => 'desc'));
        $galleryArray = array();

        foreach($gallery as $g) {
            $galleryArray[$g->getDate()->format('Y')][$g->getDate()->format('m')][$g->getDate()->format('d')] = $g;
        }

        return $galleryArray;
    }
}
