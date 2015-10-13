<?php

namespace Site\MainBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SocialActivitiesController extends Controller
{
    public function indexAction($slug = null)
    {
        $repository_page = $this->getDoctrine()->getRepository('SiteMainBundle:Page');
        $repository_social_activities = $this->getDoctrine()->getRepository('SiteMainBundle:SocialActivities');

        $page = $repository_page->findOneBySlug('sotsial-naia-dieiatiel-nost');

        $socialActivities = $repository_social_activities->findBy(array('main' => true));

        return $this->render('SiteMainBundle:Frontend/SocialActivities:index.html.twig', array(
            'page' => $page,
            'socialActivities' => $socialActivities
        ));
    }
}
