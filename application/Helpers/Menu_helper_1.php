<?php

/**
 * 
 * Helper de Menu 
 * @author Jones <jones.pereira@gmail.com>
 *   
 */
//function getMenu()
//{
//    helper('url');
//
//    $menu   = array();
//    $menu[] = array(
//        'menu'     => '1 - SubMenu',
//        'link'     => '#',
//        'hint'     => '0',
//        'level'    => 0,
//        'icon'     => 'fa fa-files-o fa-fw',
//        'children' => array(
//            array('menu'     => '2 - Sub Menu',
//                'link'     => '#',
//                'hint'     => '0',
//                'icon'     => 'fa fa-files-o fa-fw',
//                'level'    => 2,
//                'children' => array(
//                    array('menu'  => '3 - Sub Menu',
//                        'link'  => '#',
//                        'hint'  => '0',
//                        'level' => 3,
//                        'icon'  => 'fa fa-files-o fa-fw'
//                    )
//                )
//            )
//        )
//    );
//    return $menu;
//}
//
//function createMenu($menu_array)
//{
//    foreach ($menu_array as $menu) {
//        print '<li>';
//        print '<a href="' . $menu['link'] . '">'
//                . '<i class="fa fa-sitemap fa-fw"></i>'
//                . $menu['menu']
//                . '<span class="fa arrow"></span>'
//                . '</a>';
//        if (array_key_exists('children', $menu)) {
//            print '<ul class="nav ' . getLevel($menu['level']) . '">';
//            createMenu($menu['children']);
//            print '</ul>';
//        }
//        print '</li>';
//    }
//}
//
//function showMenu()
//{
//    print '<ul class="nav" id="side-menu">';
//    createMenu(getMenu());
//    print'</ul>';
//}
//
//function getLevel($level)
//{
//    switch ($level) {
//        case 1:return '';
//            break;
//        case 2: return 'nav-second-level';
//            break;
//        case 3: return 'nav-third-level';
//            break;
//        default: return '';
//            break;
//    }
//}
