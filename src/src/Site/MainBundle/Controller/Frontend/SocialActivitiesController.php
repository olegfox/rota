<?php

namespace Site\MainBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
include_once("Mobile_Detect.php");

class SocialActivitiesController extends Controller
{
    public function indexAction($slug = null)
    {
        $Mobile_Detect = new Mobile_Detect();
        $repository_page = $this->getDoctrine()->getRepository('SiteMainBundle:Page');
        $repository_social_activities = $this->getDoctrine()->getRepository('SiteMainBundle:SocialActivities');

        $page = $repository_page->findOneBySlug('sotsial-naia-dieiatiel-nost');

        $socialActivities = $repository_social_activities->findBy(array('main' => true));

        return $this->render('SiteMainBundle:Frontend/SocialActivities:index.html.twig', array(
            'page' => $page,
            'socialActivities' => $socialActivities,
            'mobile' => $Mobile_Detect->isTablet() || $Mobile_Detect->isMobile()
        ));
    }
}
