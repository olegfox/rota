<?php

namespace Site\MainBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class BackendMenuBuilder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->setCurrent($this->container->get('request')->getRequestUri());

        $menu->addChild('Слайдер', array('route' => 'backend_background_index'));
        $menu->addChild('Страницы', array('route' => 'backend_page_index'));
        $menu->addChild('Группы компаний', array('route' => 'backend_group_company_index'));
        $menu->addChild('Компании', array('route' => 'backend_company_index'));
        $menu->addChild('Новости', array('route' => 'backend_news_index'));
        $menu->addChild('Руководство', array('route' => 'backend_director_index'));

        return $menu;
    }

    public function userMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Выход', array('route' => 'fos_user_security_logout'));

        $menu->setCurrent($this->container->get('request')->getRequestUri());

        return $menu;
    }
}