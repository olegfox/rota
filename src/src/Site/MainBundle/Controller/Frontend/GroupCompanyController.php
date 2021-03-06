<?php

namespace Site\MainBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Site\MainBundle\Form\FeedbackFormType;
use Site\MainBundle\Form\Feedback;

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
        $feedbackForm = $this->createCreateFeedbackForm(new Feedback());

        return $this->render('SiteMainBundle:Frontend/Main:index.html.twig', array(
            'groupCompany' => $groupCompany,
            'pages' => $pages,
            'groupCompanies' => $groupCompanies,
            'news' => $news,
            'sliders' => $sliders,
            'feedbackForm' => $feedbackForm->createView()
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
