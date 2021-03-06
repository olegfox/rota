<?php

namespace Site\MainBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * BackgroundRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BackgroundRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll(){
        return $this->findBy(array(), array('position' => 'ASC'));
    }

    /**
     * @return bool
     */
    public function findBackground(){
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT b FROM SiteMainBundle:Background b
            WHERE b.main = 1
            ORDER BY b.id DESC
        ');

        if(count($query->getResult()) > 0){
            return $query->getResult()[0];
        }

        return false;
    }

    /**
     * Поис всех слайдеров, где есть только изображения
     *
     * @return array|bool
     */
    public function findByOnlyImage(){
        $em = $this->getEntityManager();

        $query = $em->createQuery('
            SELECT b FROM SiteMainBundle:Background b
            WHERE b.main = 1 AND b.video IS NULL
            ORDER BY b.id DESC
        ');

        if(count($query->getResult()) > 0){
            return $query->getResult();
        }

        return false;
    }
}
