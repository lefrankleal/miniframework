<?php
function principalMenu($data)
{
    $menu = '<ul>';
    foreach ($data as $key) {
        if ($key->sub !== null) {
            $sub_menu = principalMenu($key->sub);
        }
        $link = strlen($key->link) > 0 && $key->link !== "#" ? '/' . LANG . '/p/' . $key->link : '#';
        $menu .= '
        <li>
            <a href="' . $link . '">
                <span class="menu_icon"><i class="material-icons">' . $key->icon . '</i></span>
                <span class="menu_title">' . constant("{$key->name}") . '</span>
            </a>
            '.$sub_menu.'
        </li>';
        $sub_menu = '';
    }
    $menu .= '</ul>';
    return $menu;
}
//$request = new \stdClass;
$request->parent = '0';
$request->token = $_SESSION['token'];
$request->type = 'user';
$menu = new Controller\MenuController();
$menu = $menu->buildMenu($request);
echo principalMenu($menu);
