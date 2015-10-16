<?php

namespace Site\MainBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction($slug = null)
    {
        $repository_page = $this->getDoctrine()->getRepository('SiteMainBundle:Page');

        $page = $repository_page->findOneBy(array('slug' => $slug));

        if(!$page){
            throw $this->createNotFoundException('Страница не найдена');
        }

        return $this->render('SiteMainBundle:Frontend/Page:index.html.twig', array(
            'page' => $page
        ));
    }
}
