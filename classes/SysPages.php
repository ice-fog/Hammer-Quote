<?php

/**
 * Класс SysPages - Все возможные операции c системнами страницами
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class SysPages extends Core{

    /**
     * Возвращает нумерованный массив системных страниц
     * @return array
     */
    public function getAllPages() {
        $array = include $this->getRootDir() . '/data/system-pages.php';
        return array(
            0 => array(
                'page' => 'home',
                'title' => 'Главная страница',
                'content' => $array['home']
            ),
            1 => array(
                'page' => 'not-found',
                'title' => 'Страница не найдена',
                'content' => $array['not-found']
            )
        );
    }

    /**
     * Возвращает массив системных страниц
     * @return array
     */
    public function getPagesArray() {
        return include $this->getRootDir() . '/data/system-pages.php';
    }

    /**
     * Возвращает содержимое главной страницы
     * @return array
     */
    public function getHomePage() {
        $array = include $this->getRootDir() . '/data/system-pages.php';
        return htmlspecialchars_decode($array['home']);
    }

    /**
     * Возвращает содержимое страницы 404
     * @return array
     */
    public function getNotFoundPage() {
        $array = include $this->getRootDir() . '/data/system-pages.php';
        return htmlspecialchars_decode($array['not-found']);
    }

    /**
     * Обновления массива с системнами страницами
     * @param array | string $key - ключ или массив с ключами и значениями
     * @param mixed $value - значения
     * @return array
     */
    public function updatePage($key, $value = null) {
        $pages = $this->getPagesArray();
        if(is_array($key)) {
            foreach($key as $k => $v) {
                $pages[$k] = $v;
            }
        } else {
            if($pages[$key]) {
                $pages[$key] = $value;
            }
        }
        $handler = @fopen($this->getRootDir() . '/data/system-pages.php', 'w');
        fwrite($handler, "<?php\n\nreturn array(\n");
        foreach($pages as $name => $value) {
            fwrite($handler, "    '$name' => \"{$value}\",\n");
        }
        fwrite($handler, ");");
        fclose($handler);
        return true;
    }
} 