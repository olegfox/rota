<?php

namespace Site\MainBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Site\MainBundle\Form\FeedbackFormType; 
use Site\MainBundle\Form\Feedback;
use Symfony\Component\HttpFoundation\Response;
include_once("Mobile_Detect.php");

class NewsController extends Controller
{
    /**
     * News Content
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $repository_news = $this->getDoctrine()->getRepository('SiteMainBundle:News');

        $news = $repository_news->findAll();

        return $this->render('SiteMainBundle:Frontend/News:index.html.twig', array(
            'news' => $news
        ));
    }

    /**
     * Get one news
     *
     * @param $slug
     * @return Response
     */
    public function oneAction($slug)
    {
        $Mobile_Detect = new Mobile_Detect();
        $repository_page = $this->getDoctrine()->getRepository('SiteMainBundle:Page');
        $repository_group_company = $this->getDoctrine()->getRepository('SiteMainBundle:GroupCompany');
        $repository_news = $this->getDoctrine()->getRepository('SiteMainBundle:News');
        $repository_sliders = $this->getDoctrine()->getRepository('SiteMainBundle:Background');

        if(is_null($slug)){
            $page = $repository_page->findOneBySlug('glavnaia');
        }else{
            $page = $repository_page->findOneBySlug($slug);
        }

        $groupCompanies = $repository_group_company->findAll();
        $newsOne = $repository_news->findOneBySlug($slug);      
        $news = $repository_news->findLastAll(3);
        $sliders = $repository_sliders->findBy(array('main' => true), array('position' => 'ASC'));

        $pages = $repository_page->findAll();
        $feedbackForm = $this->createCreateFeedbackForm(new Feedback());

        return $this->render('SiteMainBundle:Frontend/Main:index.html.twig', array(
            'page' => $page,
            'pages' => $pages,
            'groupCompanies' => $groupCompanies,
            'newsOne' => $newsOne,
            'news' => $news,
            'sliders' => $sliders,
            'feedbackForm' => $feedbackForm->createView(),
            'mobile' => $Mobile_Detect->isTablet() || $Mobile_Detect->isMobile()
        ));
    }

    /**
     * Get one news ajax
     *
     * @param $slug
     * @return Response
     */
    public function ajaxOneAction($slug)
    {
        $repository_news = $this->getDoctrine()->getRepository('SiteMainBundle:News');

        $newsOne = $repository_news->findOneBySlug($slug);

        return new Response($this->renderView('SiteMainBundle:Frontend/News:one.html.twig', array(
            'newsOne' => $newsOne
        )));
    }

    /**
     * Создание формы обратной связи
     *
     * @param Feedback $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createCreateFeedbackForm(Feedback $entity)
    {
        $form = $this->createForm(new FeedbackFormType(), $entity, array(
            'action' => $this->generateUrl('frontend_feedback'),
            'method' => 'POST',
        ));

        return $form;
    }
}
