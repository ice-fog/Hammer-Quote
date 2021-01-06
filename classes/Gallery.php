<?php

/**
 * Класс Gallery - Управление галереей
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Gallery extends Core{

    /**
     * Возвращает количество изображений
     * @return bool|int
     */
    public function getCount() {
        return $this->getDb()->getOne("SELECT COUNT(id) FROM gallery");
    }

    /**
     * Возвращает количество активных изображений
     * @return int
     */
    public function getActiveCount() {
        return $this->getDb()->getOne("SELECT COUNT(id) FROM gallery WHERE status = 1");
    }

    /**
     * Возвращает количество неактивных изображений
     * @return int
     */
    public function getInactiveCount() {
        return $this->getDb()->getOne("SELECT COUNT(id) FROM gallery WHERE status = 0");
    }

    /**
     * Возвращает количество активнах изображений
     * @return bool|int
     */
    public function getPublicCount() {
        return $this->getDb()->getOne("SELECT COUNT(id) FROM gallery WHERE status = 1");
    }


    /**
     * Возвращает массив с изображениями
     * @param int $limit - лимит на выборку
     * @param int $page - страница
     * @return array
     */
    public function get($limit, $page) {
        return $this->getDb()->getAll("SELECT * FROM gallery ORDER BY id DESC LIMIT ?i, ?i", $page * $limit - $limit, $limit);
    }

    /**
     * Возвращает массив неактивных изображений
     * @param int $limit - лимит на выборку
     * @param int $page - страница
     * @return array
     */
    public function getInactive($limit, $page) {
        return $this->getDb()->getAll("SELECT * FROM gallery WHERE status = 0 ORDER BY id DESC LIMIT ?i, ?i", $page * $limit - $limit, $limit);
    }

    /**
     * Возвращает массив с активнами изображениями
     * @param int $limit - лимит на выборку
     * @param int $page - страница
     * @return array
     */
    public function getPublic($limit, $page) {
        return $this->getDb()->getAll("SELECT * FROM gallery WHERE status = 1 ORDER BY id DESC LIMIT ?i, ?i", $page * $limit - $limit, $limit);
    }

    /**
     * Добавления изображения
     * @return string
     */
    public function add() {
        error_reporting(0);
        $temp = $this->getImages()->add();
        if(count($temp['images']) > 0) {
            foreach($temp['images'] as $t) {
                $this->getDb()->query("INSERT INTO gallery (status, image) VALUES (?i, ?s)", 1, $t);
            }

        }
        return (json_encode(array(
            'error' => $temp['error'],
            'img' => $temp['images']
        )));
    }

    /**
     * Изменение статуса изображения
     * @param int $id - идентификатор изображения
     * @param int $status - новый статус 1 активное 0 неактивное
     * @return bool
     */
    public function updateStatus($id, $status) {
        return $this->getDb()->query("UPDATE gallery SET status = ?i WHERE id = ?i", $status, $id);
    }

    /**
     * Изменение статуса нескольких изображений
     * @param array $id - массив с идентификаторами изображений
     * @param int $status - новый статус 1 активное 0 неактивное
     * @return bool
     */
    public function multipleUpdateStatus($id, $status) {
        return $this->getDb()->query("UPDATE gallery SET status = ?i WHERE id IN (?a)", $status, $id);
    }

    /**
     * Удаление изображения
     * @param int $id - идентификатор изображения
     * @return bool
     */
    public function delete($id) {
        return $this->getDb()->query("DELETE FROM gallery WHERE id = ?i", $id);
    }

    /**
     * Удаление нескольких изображений
     * @param array $id - массив с идентификаторами изображений
     * @return bool
     */
    public function multipleDelete($id) {
        return $this->getDb()->query("DELETE  FROM gallery WHERE id IN (?a)", $id);
    }

}