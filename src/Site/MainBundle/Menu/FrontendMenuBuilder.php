<?php

namespace Site\MainBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
include_once(getcwd() . "/../src/Site/MainBundle/Controller/Frontend/Mobile_Detect.php");
use Site\MainBundle\Controller\Frontend\Mobile_Detect;

class FrontendMenuBuilder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $Mobile_Detect = new Mobile_Detect();

        $request = $this->container->get('request');

        $routeName = $request->get('_route');

        $em = $this->container->get('doctrine.orm.entity_manager');

        $repository = $em->getRepository('SiteMainBundle:Page');

        $menus = $repository->findBy(array('parent' => null), array('position' => 'asc'));

        $menu = $factory->createItem('root');

        $menu->setChildrenAttribute('class', 'nav nav-pills black');

        foreach ($menus as $key => $m) {
            if($Mobile_Detect->isTablet() || $Mobile_Detect->isMobile()){
                if($m->getSlug() == 'glavnaia') {
                    $menu->addChild($m->getTitle(), array(
                        'route' => 'frontend_homepage'
                    ));
                } else {
                    $menu->addChild($m->getTitle(), array(
                        'route' => 'frontend_page_index',
                        'routeParameters' => array('slug' => $m->getSlug())
                    ));
                }
            } else {
                if($m->getSlug() == 'glavnaia') {
                    $menu->addChild($m->getTitle(), array(
                        'route' => 'frontend_homepage'
                    ));
                } else {
                    $menu
                        ->addChild($m->getTitle(), array(
                            'uri' => '#' . $m->getSlug()
                        ))
                        ->setLinkAttributes(array(
                            'class' => 'section-scroll'
                        ));
                }
            }

        }

        $menu->setCurrent($this->container->get('request')->getRequestUri());

        return $menu;
    }
}