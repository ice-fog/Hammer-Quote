<?php

/**
 * Класс Content - Все возможные операции c контентом
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Content extends Core{

    /**
     * Возвращает общее количество записей
     * @return int
     */
    public function getCount() {
        return $this->getDb()->getOne("SELECT COUNT(id) FROM content");
    }

    /**
     * Возвращает количество активных записей
     * @return int
     */
    public function getActiveCount() {
        return $this->getDb()->getOne("SELECT COUNT(id) FROM content WHERE status = 1");
    }

    /**
     * Возвращает количество неактивных записей
     * @return int
     */
    public function getInactiveCount() {
        return $this->getDb()->getOne("SELECT COUNT(id) FROM content WHERE status = 0");
    }

    /**
     * Возвращает массив id всех дочерних категорий
     * @param int $id - id категории
     * @return array
     */
    public function getAllSubCategoryId($id) {
        $data = $this->getDb()->getAll("SELECT (SELECT COUNT(*) FROM content WHERE category = category.id) as count, category.* FROM category ORDER BY id");
        $result = explode('|', getAllSubId($data, $id));
        array_pop($result);
        return $result;
    }

    /**
     * Возвращает количество записей в категории
     * @param int $id - id категории
     * @return int
     */
    public function getCountByCategory($id) {
        return $this->getDb()->getOne("SELECT COUNT(id) FROM content WHERE category IN (?a)", $this->getAllSubCategoryId($id));
    }

    /**
     * Возвращает количество активных записей в категории
     * @param int $id - id категории
     * @return int
     */
    public function getPublicCountByCategory($id) {
        return $this->getDb()->getOne("SELECT COUNT(id) FROM content WHERE category IN (?a) AND status = 1", $this->getAllSubCategoryId($id));
    }

    /**
     * Возвращает количество записей без категории
     * @return int
     */
    public function getCountWithoutCategory() {
        return $this->getDb()->getOne("SELECT COUNT(*) FROM content WHERE category = 0");
    }

    /**
     * Возвращает массив записей
     * @param int $limit - лимит на выборку
     * @param int $page - страница
     * @return array
     */
    public function get($limit, $page) {
        return $this->getDb()->getAll("SELECT (SELECT name FROM category WHERE id = content.category) as cname, (SELECT COUNT(*) FROM comments WHERE content = content.id) as comments, content.* FROM content ORDER BY id DESC LIMIT ?i, ?i", $page * $limit - $limit, $limit);
    }

    /**
     * Возвращает массив активных записей
     * @param int $limit - лимит на выборку
     * @param int $page - страница
     * @return array
     */
    public function getPublic($limit, $page) {
        return $this->getDb()->getAll("SELECT (SELECT name FROM category WHERE id = content.category) as cname, (SELECT COUNT(*) FROM comments WHERE content = content.id AND status = 1) as comments, content.* FROM content WHERE status = 1 ORDER BY id DESC LIMIT ?i, ?i", $page * $limit - $limit, $limit);
    }

    /**
     * Возвращает массив активных записей отсортированных по рейтингу
     * @param int $limit - лимит на выборку
     * @param int $page - страница
     * @return array
     */
    public function getPublicSortedByRating($limit, $page) {
        return $this->getDb()->getAll("SELECT (SELECT name FROM category WHERE id = content.category) as cname, (SELECT COUNT(*) FROM comments WHERE content = content.id AND status = 1) as comments, content.* FROM content WHERE status = 1 ORDER BY rating DESC LIMIT ?i, ?i", $page * $limit - $limit, $limit);
    }

    /**
     * Возвращает массив активных записей отсортированных по дате добавления
     * @param int $limit - лимит на выборку
     * @param int $page - страница
     * @return array
     */
    public function getPublicSortedByTime($limit, $page) {
        return $this->getDb()->getAll("SELECT (SELECT name FROM category WHERE id = content.category) as cname, (SELECT COUNT(*) FROM comments WHERE content = content.id AND status = 1) as comments, content.* FROM content WHERE status = 1 ORDER BY time DESC LIMIT ?i, ?i", $page * $limit - $limit, $limit);
    }

    /**
     * Возвращает массив неактивных записей
     * @param int $limit - лимит на выборку
     * @param int $page - страница
     * @return array
     */
    public function getInactive($limit, $page) {
        return $this->getDb()->getAll("SELECT (SELECT name FROM category WHERE id = content.category) as cname, (SELECT COUNT(*) FROM comments WHERE content = content.id AND status = 1) as comments, content.* FROM content WHERE status = 0 ORDER BY id DESC LIMIT ?i, ?i", $page * $limit - $limit, $limit);
    }

    /**
     * Возвращает массив записей для категории
     * @param int $limit - лимит на выборку
     * @param int $page - страница
     * @param int $id - id категории
     * @return array
     */
    public function getByCategory($limit, $page, $id) {
        return $this->getDb()->getAll("SELECT (SELECT name FROM category WHERE id = content.category) as cname, (SELECT COUNT(*) FROM comments WHERE content = content.id) as comments, content.* FROM content WHERE category IN (?a) ORDER BY id DESC LIMIT ?i, ?i", $this->getAllSubCategoryId($id), $page * $limit - $limit, $limit);
    }

    /**
     * Возвращает массив активных записей для категории
     * @param int $limit - лимит на выборку
     * @param int $page - страница
     * @param int $id - id категории
     * @return array
     */
    public function getPublicByCategory($limit, $page, $id) {
        return $this->getDb()->getAll("SELECT (SELECT name FROM category WHERE id = content.category) as cname, (SELECT COUNT(*) FROM comments WHERE content = content.id AND status = 1) as comments, content.* FROM content WHERE category IN (?a) AND status = 1 ORDER BY id DESC LIMIT ?i, ?i", $this->getAllSubCategoryId($id), $page * $limit - $limit, $limit);
    }

    /**
     * Возвращает массив случайных записей
     * @param int $limit - лимит на выборку
     * @return array
     */
    public function getRandom($limit) {
        return $this->getDb()->getAll("SELECT (SELECT name FROM category WHERE id = content.category) as cname, (SELECT COUNT(*) FROM comments WHERE content = content.id) as comments, content.* FROM content ORDER BY rand() LIMIT 0, ?i", $limit);
    }

    /**
     * Возвращает массив только активных случайных записей
     * @param int $limit - лимит на выборку
     * @return array
     */
    public function getPublicRandom($limit) {
        return $this->getDb()->getAll("SELECT (SELECT name FROM category WHERE id = content.category) as cname, (SELECT COUNT(*) FROM comments WHERE content = content.id AND status = 1) as comments, content.* FROM content WHERE status = 1 ORDER BY rand() LIMIT 0, ?i", $limit);
    }

    /**
     * Возвращает массив записей без категории
     * @param int $limit - лимит на выборку
     * @param int $page - страница
     * @return array
     */
    public function getWithoutCategory($limit, $page) {
        return $this->getDb()->getAll("SELECT * FROM content WHERE category = 0 ORDER BY id DESC LIMIT ?i, ?i", $page * $limit - $limit, $limit);
    }

    /**
     * Возвращает массив записей соответствующих поисковому запросу
     * @param int $limit - лимит на выборку
     * @param int $page - страница
     * @param string $search - поисковый запрос
     * @return array
     */
    public function search($limit, $page, $search) {
        return $this->getDb()->getAll("SELECT (SELECT name FROM category WHERE id = content.category) as cname, (SELECT COUNT(*) FROM comments WHERE content = content.id) as comments, content.* FROM content WHERE content  LIKE '%' ?s '%' ORDER BY id LIMIT ?i, ?i", $search, $page * $limit - $limit, $limit);
    }

    /**
     * Возвращает массив только активных записей соответствующих поисковому запросу
     * @param int $limit - лимит на выборку
     * @param int $page - страница
     * @param string $search - поисковый запрос
     * @return array
     */
    public function searchPublic($limit, $page, $search) {
        return $this->getDb()->getAll("SELECT (SELECT name FROM category WHERE id = content.category) as cname, (SELECT COUNT(*) FROM comments WHERE content = content.id) as comments, content.* FROM content WHERE content  LIKE '%' ?s '%' AND status = 1 ORDER BY id LIMIT ?i, ?i", $search, $page * $limit - $limit, $limit);
    }

    /**
     * Возвращает количество записей соответствующих поисковому запросу
     * @param string $search - поисковый запрос
     * @return int
     */
    public function searchCount($search) {
        return $this->getDb()->getOne("SELECT COUNT(*) FROM content WHERE content  LIKE '%' ?s '%' ORDER BY id", $search);
    }

    /**
     * Возвращает количество только активных записей соответствующих поисковому запросу
     * @param string $search - поисковый запрос
     * @return int
     */
    public function searchPublicCount($search) {
        return $this->getDb()->getOne("SELECT COUNT(*) FROM content WHERE content  LIKE '%' ?s '%' AND status = 1 ORDER BY id", $search);
    }

    /**
     * Возвращает значение рейтинга записи
     * @param int $id - id записи
     * @return int
     */
    public function getRating($id) {
        return $this->getDb()->getOne("SELECT rating FROM content WHERE id = ?i", $id);
    }

    /**
     * Удаление записи
     * @param int $id - id записи
     * @return bool
     */
    public function delete($id) {
        return $this->getDb()->query("DELETE  FROM content WHERE id = ?i", $id);
    }

    /**
     * Изменение статуса записи
     * @param int $id - id записи
     * @param int $status - новый статус 1 активна 0 не активна
     * @return bool
     */
    public function updateStatus($id, $status) {
        return $this->getDb()->query("UPDATE content SET status = ?s WHERE id = ?i", $status, $id);
    }

    /**
     * Удаление категории из записи
     * @param int $id - id записи
     * @return bool
     */
    public function deleteCategory($id) {
        return $this->getDb()->query("UPDATE content SET category = 0 WHERE category = ?i", $id);
    }

    /**
     * Удаление категории из записей
     * @param array $id - массив id записей
     * @return bool
     */
    public function multipleDeleteCategory($id) {
        return $this->getDb()->query("UPDATE content SET category = 0 WHERE category IN (?a)", $id);
    }

    /**
     * Смена категории нескольких записей
     * @param array $category - id новый категории
     * @param array $id - массив id записей
     * @return bool
     */
    public function multipleChangeCategory($category, $id) {
        return $this->getDb()->query("UPDATE content SET category = ?i WHERE id IN (?a)", $category, $id);
    }

    /**
     * Изменение статуса нескольких записей
     * @param array $id - массив id записей
     * @param int $status - новый статус 1 активна 0 не активна
     * @return bool
     */
    public function multipleUpdateStatus($id, $status) {
        return $this->getDb()->query("UPDATE content SET status = ?s WHERE id IN (?a)", $status, $id);
    }

    /**
     * Удаление нескольких записей
     * @param array $id - массив id записей
     * @return bool
     */
    public function multipleDelete($id) {
        return $this->getDb()->query("DELETE  FROM content WHERE id IN (?a)", $id);
    }

    /**
     * Изменение рейтинга записи
     * @param int $id - id записи
     * @return bool
     */
    public function updateRating($id) {
        return $this->getDb()->query("UPDATE content SET rating = rating + 1 WHERE id = ?i", $id);
    }

    /**
     * Обновление количество просмотров
     * @param int $id - id записи
     * @return bool
     */
    public function updateViewCount($id) {
        return $this->getDb()->query("UPDATE content SET views = views + 1 WHERE id = ?i", $id);
    }

    /**
     * Добавление новый записи
     * @param int $category - id категории
     * @param string $content - содержание
     * @param int $status - статус 1 активна 0 не активна
     * @return bool
     */
    public function add($category, $content, $status) {
        return $this->getDb()->query("INSERT INTO content (category, content, status) VALUES (?s, ?s, ?s)", $category, $content, $status);
    }

    /**
     * Возвращает массив одной записи
     * @param int $id - id записи
     * @return array
     */
    public function getOneRow($id) {
        return $this->getDb()->getRow("SELECT (SELECT name FROM category WHERE id = content.category) as cname, (SELECT COUNT(*) FROM comments WHERE content = content.id) as comments, content.* FROM content WHERE id = ?i", $id);
    }

    /**
     * Возвращает массив одной записи
     * @param int $id - id записи
     * @return array
     */
    public function getOne($id) {
        return $this->getDb()->getAll("SELECT (SELECT name FROM category WHERE id = content.category) as cname, (SELECT COUNT(*) FROM comments WHERE content = content.id) as comments, content.* FROM content WHERE id = ?i", $id);
    }

    /**
     * Редактирование записи
     * @param int $id - id записи
     * @param int $category - id категории
     * @param string $content - содержание
     * @param int $status - статус 1 активна 0 не активна
     * @return bool
     */
    public function edit($id, $category, $content, $status) {
        return $this->getDb()->query("UPDATE content SET category = ?s, content = ?s, status = ?s WHERE id = ?i", $category, $content, $status, $id);
    }

    /**
     * Возвращает массив всех записей
     * @return array
     */
    public function getAll() {
        return $this->getDb()->getAll("SELECT (SELECT name FROM category WHERE id = content.category) as cname, content.* FROM content ORDER BY id");
    }

} 