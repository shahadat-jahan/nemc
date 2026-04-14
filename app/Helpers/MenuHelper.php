<?php
use Illuminate\Support\Str;

/**
 * @param string $action
 * @return bool
 */
function hasPermission($action = '')
{
    return array_key_exists($action, session('permissions')) && session('permissions')[$action] == 1;
}

/**
 * Make menu
 *
 * @return string
 */
function makeMenu()
{
    // get menu list
    $menuList = Config::get('menu');

    $checkPanel = explode('/', Route::current()->uri());

    $parent = getParent($checkPanel[0]);

    $menuHtml = '<ul class="m-menu__nav ">';

//    $uri = preg_replace('/\/{+[a-z1-9_]+}/', '', Route::current()->uri());

    if ($checkPanel[0] == 'admin'){
        preg_match('/admin\/+[a-z_]+/', Route::current()->uri(), $uri);
    }else{
        preg_match('/nemc\/+[a-z_]+/', Route::current()->uri(), $uri);
    }


    foreach ($menuList as $key => $val) {
        $active = '';
        $open = '';

        if ($checkPanel[0] == 'admin'){
            if ($uri[0] == 'admin/'.$key || $parent == $key) {
                $active = ' m-menu__item--active';
                $open = ' m-menu__item--open';
            }
        }else if ($uri[0] == 'nemc/'.$key || $parent == $key) {
            $active = ' m-menu__item--active';
            $open = ' m-menu__item--open';
        }



        if (array_key_exists($key, session('permissions')) && session('permissions')[$key] == 1) {

            if (sizeof($val['children']) > 0) {
                $menuHtml .= '<li class="m-menu__item m-menu__item--submenu' . $active.' '.$open . '" aria-haspopup="true" m-menu-submenu-toggle="hover">';
                $menuHtml .= '<a href="javascript:;" class="m-menu__link m-menu__toggle">
                                    <span class="m-menu__item-here"></span>
                                    <i class="m-menu__link-icon ' . $val['icon'] . '"></i>
                                    <span class="m-menu__link-text">' . $val['title'] . '</span>
                                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                                </a>';
                $menuHtml .= getChildren($key, $checkPanel[0]);
            } else {
                $menuHtml .= '<li class="m-menu__item' . $active . '" aria-haspopup="true">';
                $menuHtml .= '<a href="' . url($checkPanel[0].'/'.$key) . '" class="m-menu__link">
                                <span class="m-menu__item-here"></span>
                                <i class="m-menu__link-icon ' . $val['icon'] . '"></i>
		                        <span class="m-menu__link-text">' . $val['title'] . '</span>
                            </a>';
            }
            $menuHtml .= '</li>';
        }
    }
    $menuHtml .= '</ul>';

    return $menuHtml;
}

/**
 * Get child menu
 *
 * @param string $action
 * @return string
 */
function getChildren($action = '', $userPanel)
{
    // get menu list
    $menuList = Config::get('menu');

    $menuHtml = '<div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav">';

    foreach ($menuList[$action]['children'] as $key => $val) {

        $active = (Route::current()->uri() == $userPanel.'/'.$key) ? ' m-menu__item--active' : '';

        if (array_key_exists($key, session('permissions')) AND session('permissions')[$key] == 1) {
            $menuHtml .= '<li class="m-menu__item' . $active . '" aria-haspopup="true">';
            $menuHtml .= '<a href="' . url($userPanel.'/'.$key) . '" class="m-menu__link">
                            <i class="m-menu__link-icon ' . $val['icon'] . '"><span></span></i>
                            <span class="m-menu__link-text">' . $val['title'] . '</span>
                        </a>';
            $menuHtml .= '</li>';
        }

    }
    $menuHtml .= '</ul></div>';

    return $menuHtml;
}

/**
 * Get parent menu
 *
 * @return string
 */
function getParent($userPanel)
{
    // get menu list
    $menuList = Config::get('menu');

    foreach ($menuList as $key => $val) {
        if (sizeof($val['children']) > 0) {
            foreach ($val['children'] as $childKey => $childVal) {
                if ('admin/'.$childKey == Route::current()->uri() OR Str::is($userPanel.'/'.$childKey.'*', Route::current()->uri())) {
                    return $key;
                }
            }
        }
    }
}

/**
 * Make breadcrumb
 *
 * @return array
 */
/*function makeBreadcrumb()
{
    $breadcrumb = [];

    // get menu list
    $this->menus = Config::get('menu');
    $parent = getParent();

    foreach ($this->menus as $key => $val) {

        if (Route::current()->uri() == $key OR $parent == $key) {
            $breadcrumb[] = $val['title'];
        }

        if (sizeof($val['children']) > 0) {

            foreach ($val['children'] as $cKey => $cVal) {

                if (Route::current() == $cKey) {
                    $breadcrumb[] = $cVal['title'];
                }
            }

        }
    }

    return $breadcrumb;
}*/

