<?php

namespace Site\MainBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GroupCompanyController extends Controller
{
    /**
     * Group Company Content
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $repository_group_company = $this->getDoctrine()->getRepository('SiteMainBundle:GroupCompany');

        $groupCompanies = $repository_group_company->findAll();

        return $this->render('SiteMainBundle:Frontend/GroupCompany:index.html.twig', array(
            'groupCompanies' => $groupCompanies
        ));
    }

    /**
     * @param null $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function oneAction($slug = null)
    {
        $repository_page = $this->getDoctrine()->getRepository('SiteMainBundle:Page');
        $repository_group_company = $this->getDoctrine()->getRepository('SiteMainBundle:GroupCompany');
        $repository_news = $this->getDoctrine()->getRepository('SiteMainBundle:News');
        $repository_sliders = $this->getDoctrine()->getRepository('SiteMainBundle:Background');

        $groupCompany = $repository_group_company->findOneBy(array('slug' => $slug));

        $groupCompanies = $repository_group_company->findAll();
        $news = $repository_news->findLastAll(3);
        $sliders = $repository_sliders->findBy(array('main' => true));
        $pages = $repository_page->findAll();

        return $this->render('SiteMainBundle:Frontend/Main:index.html.twig', array(
            'groupCompany' => $groupCompany,
            'pages' => $pages,
            'groupCompanies' => $groupCompanies,
            'news' => $news,
            'sliders' => $sliders
        ));
    }
}
