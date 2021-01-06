<?php

/**
 * Класс Core - Основной класс
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

include $_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php';

class Core {

    /**
     * Экземпляр класса SysPages
     * @var SysPages
     */
    private $sysPages;

    /**
     * Экземпляр класса Settings
     * @var Settings
     */
    private $settings;

    /**
     * Экземпляр класса Category
     * @var Category
     */
    private $category;

    /**
     * Экземпляр класса Feedback
     * @var Feedback
     */
    private $feedback;

    /**
     * Экземпляр класса Comments
     * @var Comments
     */
    private $comments;

    /**
     * Экземпляр класса Content
     * @var Content
     */
    private $content;

    /**
     * Экземпляр класса Images
     * @var Images
     */
    private $images;

    /**
     * Экземпляр класса Notify
     * @var Notify
     */
    private $notify;

    /**
     * Экземпляр класса Gallery
     * @var Gallery
     */
    private $gallery;

    /**
     * Экземпляр класса FileEditor
     * @var FileEditor
     */
    private $fileEditor;

    /**
     * Экземпляр класса EmailDelivery
     * @var EmailDelivery
     */
    private $emailDelivery;

    /**
     * Экземпляр класса Pages
     * @var Pages
     */
    private $pages;

    /**
     * Экземпляр класса Template
     * @var Template
     */
    private $template;

    /**
     * Экземпляр класса DataBase
     * @var DataBase
     */
    private $db;

    /**
     * Путь до корня скрипта
     * @var string
     */
    private $rootDir;

    /**
     * HTTP хост.
     * @var string
     */
    private $HTTPHost;

    /**
     * Время старта скрипта
     * @var int
     */
    private $startTime;

    /**
     * Экземпляр класса
     * @var Core
     */
    private static $instance;

    /**
     * Конструктор
     */
    function __construct() {
        header("X-PoweredBy: Hammer");
        $this->startTime = time();
        $this->rootDir = $_SERVER['DOCUMENT_ROOT'];
        $this->HTTPHost = $_SERVER['HTTP_HOST'];

        if(self::$instance) {
            $this->db = &self::$instance->db;
            $this->template = &self::$instance->template;
            $this->images = &self::$instance->images;
            $this->settings = &self::$instance->settings;
            $this->category = &self::$instance->category;
            $this->feedback = &self::$instance->feedback;
            $this->comments = &self::$instance->comments;
            $this->pages = &self::$instance->pages;
            $this->content = &self::$instance->content;
            $this->sysPages = &self::$instance->sysPages;
            $this->notify = &self::$instance->notify;
            $this->fileEditor = &self::$instance->fileEditor;
            $this->emailDelivery = &self::$instance->emailDelivery;
            $this->gallery = &self::$instance->gallery;
        } else {

            self::$instance = $this;

            $this->db = new DataBase(include $this->rootDir . '/config/db-config.php');
            $this->template = new Template($this->rootDir . '/admin/public/templates/', '.tpl');
            $this->images = new Images();
            $this->settings = new Settings();
            $this->category = new Category();
            $this->feedback = new Feedback();
            $this->comments = new Comments();
            $this->pages = new Pages();
            $this->content = new Content();
            $this->sysPages = new SysPages();
            $this->notify = new Notify();
            $this->fileEditor = new FileEditor();
            $this->emailDelivery = new EmailDelivery();
            $this->gallery = new Gallery();
        }
    }


    /**
     * Возвращает путь до корня скрипта
     * @return string
     */
    public function getRootDir() {
        return $this->rootDir;
    }

    /**
     * Возвращает HTTP хост
     * @return string
     */
    public function getHTTPHost() {
        return $this->HTTPHost;
    }

    /**
     * Возвращает время старта в UNIX Timestamp
     * @return int
     */
    public function getStartTime() {
        return $this->startTime;
    }

    /**
     * Возвращает массив с разбитой адресной строкой по "/"
     * @param int $route - номер
     * @return int | array
     */
    public function getRoute($route = 0) {
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        if($route == 0) {
            return $routes;
        } else {
            return $routes[$route];
        }

    }

    /**
     * Возвращает текущий URL адрес
     * @return string
     */
    public function getURL() {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Возвращает экземпляр класса DataBase
     * @return DataBase
     */
    public function getDb() {
        return $this->db;
    }

    /**
     * Возвращает экземпляр класса Template
     * @return Template
     */
    public function getTemplate() {
        return $this->template;
    }

    /**
     * Возвращает экземпляр класса SysPages
     * @return SysPages
     */
    public function getSysPages() {
        return $this->sysPages;
    }

    /**
     * Возвращает экземпляр класса Gallery
     * @return Gallery
     */
    public function getGallery() {
        return $this->gallery;
    }

    /**
     * Возвращает экземпляр класса Images
     * @return Images
     */
    public function getImages() {
        return $this->images;
    }

    /**
     * Возвращает экземпляр класса Notify
     * @return Notify
     */
    public function getNotify() {
        return $this->notify;
    }

    /**
     * Возвращает экземпляр класса Category
     * @return Category
     */
    public function getCategory() {
        return $this->category;
    }

    /**
     * Возвращает экземпляр класса Feedback
     * @return Feedback
     */
    public function getFeedback() {
        return $this->feedback;
    }

    /**
     * Возвращает экземпляр класса Content
     * @return Content
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Возвращает экземпляр класса Comments
     * @return Comments
     */
    public function getComments() {
        return $this->comments;
    }

    /**
     * Возвращает экземпляр класса FileEditor
     * @return FileEditor
     */
    public function getFileEditor() {
        return $this->fileEditor;
    }

    /**
     * Возвращает экземпляр класса EmailDelivery
     * @return EmailDelivery()
     */
    public function getEmailDelivery() {
        return $this->emailDelivery;
    }

    /**
     * Возвращает экземпляр класса Pages
     * @return Pages
     */
    public function getPages() {
        return $this->pages;
    }

    /**
     * Возвращает экземпляр класса Settings
     * @return Settings
     */
    public function getSettings() {
        return $this->settings;
    }


    /**
     * Возвращает ip адрес пользователя
     * @return string
     */
    public function getUserIP() {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * Обновление статистики посещений и лога запросов
     */
    public function updateStat() {
        $id = $this->db->getOne("SELECT id FROM statistics WHERE period = ?s", date("d.m.y"));
        if($id) {
            if($_COOKIE[md5('visit')] == 'yes') {
                $this->db->query("UPDATE statistics SET total = total + 1 WHERE id = ?i", $id);
            } else {
                $this->db->query("UPDATE statistics SET total = total + 1, uniques = uniques + 1 WHERE id = ?i", $id);
            }
        } else {
            $this->db->query("INSERT INTO statistics (period,  uniques, total) VALUES (?s, ?i, ?i)", date("d.m.y"), 1, 1);
        }

        if(strstr($_SERVER['HTTP_USER_AGENT'], 'YandexBot')) {
            $bot = 'YandexBot';
        } elseif(strstr($_SERVER['HTTP_USER_AGENT'], 'Googlebot')) {
            $bot = 'Googlebot';
        } else {
            $bot = $_SERVER['HTTP_USER_AGENT'];
        }
        $file = $_SERVER['DOCUMENT_ROOT'] . '/data/log';
        $lines = file($file);
        while(count($lines) > 1000)
            array_shift($lines);
        $lines[] = date("H:i:s d.m.Y") . "|" . $bot . "|" . $this->getUserIP() . "|" . $this->getURL() . "\r\n";
        file_put_contents($file, $lines);

    }

    /**
     * Возвращает статистику посещений в виде массива
     * @param $limit - лимит на выборку.
     * @return array
     */
    public function getStat($limit) {
        return $this->db->getAll("SELECT * FROM statistics ORDER BY id DESC LIMIT ?i", $limit);
    }

    /**
     * Проверить куки и возвращает данные пользователя
     * @return array|bool
     */
    public function getUser() {
        if(isset($_COOKIE[md5('user-hash')], $_COOKIE[md5('user-id')])) {
            $user = $this->getDb()->getRow("SELECT * FROM users WHERE id = ?i", $_COOKIE[md5('user-id')]);
            if(($user['hash'] !== $_COOKIE[md5('user-hash')]) || ($user['id'] !== $_COOKIE[md5('user-id')])) {
                $this->logout();
                return false;
            } else {
                return $user;
            }
        } else {
            return false;
        }
    }

    /**
     * Проверяет данные пользователя и устанавливает куки
     * @param string $login - логин.
     * @param string $password - пароль.
     * @return bool
     */
    public function login($login, $password) {
        $user = $this->getDb()->getRow("SELECT * FROM users WHERE login = ?s", $login);
        if($user) {
            if($user['password'] === md5(md5($password))) {
                $hash = md5(rand(0, 9999));
                $this->getDb()->query("UPDATE users SET hash = ?s WHERE id = ?i", $hash, $user['id']);
                $this->setCookie('user-id', $user['id'], time() + 60 * 60 * 24 * 30);
                $this->setCookie('user-hash', $hash, time() + 60 * 60 * 24 * 30);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     *  Обнуляет куки
     */
    public function logout() {
        $this->setCookie('user-id', "", time() - 3600 * 24 * 30 * 12);
        $this->setCookie('user-hash', "", time() - 3600 * 24 * 30 * 12);
    }

    /**
     * Инициализирует данные сессии
     */
    public function sessionStart() {
        session_start();
    }

    /**
     * Освобождает все переменные сессии
     */
    public function sessionUnset() {
        session_unset();
    }

    /**
     * Разрушает все данные, зарегистрированные в сессии
     */
    public function sessionDestroy() {
        session_destroy();
    }

    /**
     * Задает cookie и хешерует ключ в md5
     * @param string $key - ключ
     * @param string $value - значение
     * @param int $time - метка времени Unix, когда срок действия cookie истекает
     * @param string $path - путь к директории на сервере, из которой будут доступны cookie
     * @param string $domain - домен, которому доступны cookie
     * @param bool $secure - указывает на то, что значение cookie должно передаваться от клиента по защищенному HTTPS соединению
     * @param bool $httponly - если задано TRUE, cookie будут доступны только через HTTP протокол
     */
    public function setCookie($key, $value, $time = 0, $path = null, $domain = null, $secure = false, $httponly = false) {
        setcookie(md5($key), $value, $time, $path, $domain, $secure, $httponly);
    }

    /**
     * Возвращает значение cookie
     * @param $key - ключ
     * @return mixed
     */
    public function getCookie($key) {
        return $_COOKIE[md5($key)];
    }
}