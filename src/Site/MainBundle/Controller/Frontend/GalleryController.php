<?php

namespace Site\MainBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class GalleryController extends Controller
{
    /**
     * Gallery Content
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $repository_gallery = $this->getDoctrine()->getRepository('SiteMainBundle:Gallery');

        $gallery = $repository_gallery->findAllArray();

        return $this->render('SiteMainBundle:Frontend/Gallery:index.html.twig', array(
            'gallery' => $gallery
        ));
    }
}
