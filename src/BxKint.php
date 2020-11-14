<?php
namespace App;

use Bitrix\Main\Application;
use Bitrix\Main\EventManager;

class BxKint {

    const GET_PARAM = 'app_bx_kint';
    const SESSION_KEY = 'APP_BX_KINT';

    public static function init() {

        if(class_exists('Kint\Kint')) {
            EventManager::getInstance()->addEventHandler('main', 'OnBeforeProlog', ['\App\BxKint', 'addButton']);
            EventManager::getInstance()->addEventHandler('main', 'OnEpilog', ['\App\BxKint', 'showInfo']);
        }
    }

    public function showInfo() {

        global $BX_KINT_INFO;
        if($_SESSION[self::SESSION_KEY]) d($BX_KINT_INFO);
    }

    public static function info($var) {

        global $BX_KINT_INFO;

        if(is_array($var)) {
            if(!is_array($BX_KINT_INFO)) {
                $BX_KINT_INFO = [];
            }
            $BX_KINT_INFO = array_merge($BX_KINT_INFO, $var);
        } else {
            $BX_KINT_INFO[] = $var;
        }
    }

    public static function addButton() {

        /** @global Application */
        global $APPLICATION;

        if(self::checkAcces()) {

            self::checkIcons();

            $query = $_GET[self::GET_PARAM];
            if($query == 'Y') {
                $_SESSION[self::SESSION_KEY] = true;
            } else if($query == 'N') {
                $_SESSION[self::SESSION_KEY] = false;
            }
            $enabled = (bool) $_SESSION[self::SESSION_KEY];

            $queryList = (array) $_GET;
            $queryList[self::GET_PARAM] = ($enabled ? 'N' : 'Y');

            $button = [
                'HREF'      => '?' . http_build_query($queryList),
                'SRC'       => '/bitrix/themes/.default/icons/bxkint/debug_' . ($enabled ? 'enable' : 'disable') . '.png',
                'TYPE'      => 'SMALL',
                'HINT'      => ['TEXT' => 'BxKint debug switch'],
                'MAIN_SORT' => 10000,
                'SORT'      => 100,
            ];

            $APPLICATION->AddPanelButton($button);
        }
    }

    protected static function checkAcces() {

        /** @global \CUser */
        global $USER;
        return (is_object($USER) && $USER->IsAdmin());
    }

    protected static function checkIcons() {

        if(!file_exists($_SERVER['DOCUMENT_ROOT'] . '/bitrix/themes/.default/icons/bxkint/debug_enable.png')) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . '/bitrix/themes/.default/icons/bxkint', BX_DIR_PERMISSIONS);
            copy(__DIR__ . '/resources/icons/bxkint/debug_enable.png',
                $_SERVER['DOCUMENT_ROOT'] . '/bitrix/themes/.default/icons/bxkint/debug_disable.png');
            copy(__DIR__ . '/resources/icons/bxkint/debug_enable.png',
                $_SERVER['DOCUMENT_ROOT'] . '/bitrix/themes/.default/icons/bxkint/debug_disable.png');
        }
    }
}
