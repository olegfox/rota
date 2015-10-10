<?php

namespace Site\MainBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Site\MainBundle\Form\FeedbackType;
use Site\MainBundle\Form\Feedback;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    public function indexAction($slug = null)
    {
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
        $sliders = $repository_sliders->findBy(array('main' => true));

        return $this->render('SiteMainBundle:Frontend/Main:index.html.twig', array(
            'page' => $page,
            'groupCompanies' => $groupCompanies,
            'news' => $news,
            'sliders' => $sliders
        ));
    }

    public function feedbackAction(Request $request){
        $feedback = new Feedback();
        $form = $this->createForm(new FeedbackType(), $feedback);

        $form->handleRequest($request);

        if($form->isValid()){
            $swift = \Swift_Message::newInstance()
                ->setSubject('Рота (Новая заявка)')
                ->setFrom(array('site@dvsablin.ru' => "Новое письмо с сайта"))
                ->setTo(array('mail@dvsablin.ru'))
                ->setBody(
                    $this->renderView(
                        'SiteMainBundle:Frontend/Feedback:message.html.twig',
                        array(
                            'form' => $feedback
                        )
                    )
                    , 'text/html'
                );
            $this->get('mailer')->send($swift);

            return new Response('Сообщение успешно отправлено!', 200);
        }

        return new Response('Ошибка!', 500);
    }

    /**
     * Создание формы обратной связи
     *
     * @param Feedback $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createCreateForm(Feedback $entity)
    {
        $form = $this->createForm(new FeedbackType(), $entity);

        return $form;
    }
}
