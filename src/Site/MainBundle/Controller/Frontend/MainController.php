<?php

namespace Site\MainBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Site\MainBundle\Form\FeedbackFormType;
use Site\MainBundle\Form\Feedback;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
include_once("Mobile_Detect.php");

class MainController extends Controller
{
    /**
     * @param null $slug
     * @return Response
     */
    public function indexAction($slug = null)
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
        $news = $repository_news->findLastAll(3);
        $sliders = $repository_sliders->findBy(array('main' => true), array('position' => 'ASC'));

        $pages = $repository_page->findAll();
        $feedbackForm = $this->createCreateFeedbackForm(new Feedback());

        return $this->render('SiteMainBundle:Frontend/Main:index.html.twig', array(
            'page' => $page,
            'pages' => $pages,
            'groupCompanies' => $groupCompanies,
            'news' => $news,
            'sliders' => $sliders,
            'feedbackForm' => $feedbackForm->createView(),
            'mobile' => $Mobile_Detect->isTablet() || $Mobile_Detect->isMobile()
        ));
    }

    /**
     * Отправка сообшения через форму контактов
     *
     * @param Request $request
     * @return Response
     */
    public function feedbackAction(Request $request){
        $feedbackForm = new Feedback();

        $form = $this->createForm(new FeedbackFormType(), $feedbackForm, array(
            'action' => $this->generateUrl('frontend_feedback'),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if($form->isValid()){

            $swift = \Swift_Message::newInstance()
                ->setSubject('Рота (Обратная связь)')
                ->setFrom(array('info@rota.ru' => "Рота"))
                ->setTo(array('1991oleg22@gmail.com'))
                ->setBody(
                    $this->renderView(
                        'SiteMainBundle:Frontend/Feedback:feedback_message.html.twig',
                        array(
                            'feedbackForm' => $feedbackForm
                        )
                    )
                    , 'text/html'
                );
            $this->get('mailer')->send($swift);

            return new Response('', 200);
        }

        return new Response('', 500);
    }

    /**
     * Создание формы контактов
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
