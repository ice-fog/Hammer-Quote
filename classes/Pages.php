<?php

/**
 * Класс Pages - Все возможные операции со страницами
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Pages extends Core{

    /**
     * Возвращает массив со всеми страницами
     * @return array
     */
    public function getAllPage() {
        return $this->getDb()->getAll("SELECT * FROM pages ORDER BY title");
    }

    /**
     * Возвращает массив для формирования ссылок активных страниц
     * @return array
     */
    public function getPublicLinks() {
        return $this->getDb()->getAll("SELECT title, url FROM pages ORDER BY title");
    }

    /**
     * Возвращает массив одной страницы по id
     * @param int $id - id страницы
     * @return array
     */
    public function getOnePageById($id) {
        return $this->getDb()->getRow("SELECT * FROM pages WHERE id = ?i", $id);
    }

    /**
     * Возвращает массив одной страницы по URL
     * @param string $url - url страницы
     * @return array
     */
    public function getOnePageByUrl($url) {
        return $this->getDb()->getRow("SELECT * FROM pages WHERE url = ?s", $url);
    }

    /**
     * Проверяет есть ли такой url если есть возвращает его id
     * @param $url
     * @return bool|int
     */
    public function checkFreeURL($url){
        return $this->getDb()->getOne("SELECT id FROM pages WHERE url = ?s", $url);
    }

    /**
     * Добавления страницы
     * @param string $url - URL страницы
     * @param int $status - статус страницы 1 активна 0 нет
     * @param string $title - заголовок страницы
     * @param string $description - мета описание страницы
     * @param string $content - содержание страницы
     * @return boolean
     */
    public function addPage($url, $status, $title, $description, $content) {
        return $this->getDb()->query("INSERT INTO pages (url, status, title, description, content) VALUES (?s, ?s, ?s, ?s, ?s)", $url, $status, $title, $description, htmlspecialchars($content));
    }

    /**
     * Редактирование страницы
     * @param int $id - id страницы
     * @param string $url - URL страницы
     * @param int $status - статус страницы 1 активна 0 нет
     * @param string $title - заголовок страницы
     * @param string $description - мета описание страницы
     * @param string $content - содержание страницы
     * @return boolean
     */
    public function editPage($id, $url, $status, $title, $description, $content) {
        return $this->getDb()->query("UPDATE pages SET url = ?s, status = ?s, title = ?s, description = ?s, content = ?s WHERE id = ?i", $url, $status, $title, $description, htmlspecialchars($content), $id);
    }

    /**
     * Изменение статуса нескольких страниц
     * @param array $id - массив id страниц
     * @param int $status - статус 1 активны 0 нет
     * @return boolean
     */
    public function multipleUpdateStatus($id, $status) {
        return $this->getDb()->query("UPDATE pages SET status = ?i WHERE id IN (?a)", $status, $id);
    }

    /**
     * Изменение статуса страницы
     * @param int $id - id страницы
     * @param int $status - статус 1 активна 0 нет
     * @return boolean
     */
    public function updateStatus($id, $status) {
        return $this->getDb()->query("UPDATE pages SET status = ?i WHERE id = ?i", $status, $id);

    }

    /**
     * Удаление нескольких страниц
     * @param array $id - массив id страниц
     * @return boolean
     */
    public function multipleDeletePage($id) {
        return $this->getDb()->query("DELETE  FROM pages WHERE id IN (?a)", $id);
    }

    /**
     * Удаление страницы
     * @param int $id - id страниц
     * @return boolean
     */
    public function deletePage($id) {
        return $this->getDb()->query("DELETE  FROM pages WHERE id = ?i", $id);
    }
} 