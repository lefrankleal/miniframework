<?php
namespace Core\Helpers;

class Languaje
{
    private $_rs;
    public function __construct()
    {
    }

    public function register()
    {
        if (is_readable(realpath(dirname(__FILE__) . '/../Languajes/' . LANG . '/' . mb_convert_case(PAGE, MB_CASE_TITLE) . '.php'))) {
            include_once realpath(dirname(__FILE__).'/../Languajes/'. LANG . '/'. mb_convert_case(PAGE, MB_CASE_TITLE). '.php');
        } else {
            include_once realpath(dirname(__FILE__).'/../Languajes/'. LANG .'/General'. '.php');
        }
    }

    public function registerCustom($custom_page)
    {
        if (is_readable(realpath(dirname(__FILE__) . '/../Languajes/' . LANG . '/' . mb_convert_case($custom_page, MB_CASE_TITLE) . '.php'))) {
            include_once realpath(dirname(__FILE__).'/../Languajes/'. LANG . '/'. mb_convert_case($custom_page, MB_CASE_TITLE). '.php');
        } else {
            include_once realpath(dirname(__FILE__).'/../Languajes/'. LANG .'/General'. '.php');
        }
    }
}
