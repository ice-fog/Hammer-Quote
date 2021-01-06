<?php

/**
 * Класс Feedback - Все возможные операции с сообщениями обратной связи
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Feedback extends Core{

    /**
     * Добавление сообщения
     * @param string $name - имя пользователя
     * @param string $email - email пользователя
     * @param string $message - сообщение пользователя
     * @param string $ip - ip адрес пользователя
     * @return boolean
     */
    public function add($name, $email, $message, $ip) {
        return $this->getDb()->query("INSERT INTO feedback (name, email, message, ip, archive) VALUES (?s, ?s, ?s, ?s, ?i)", $name, $email, $message, $ip, 0);
    }

    /**
     * Возвращает массив всех не архивных сообщений
     * @return array
     */
    public function getAllNotArchive() {
        return $this->getDb()->getAll("SELECT * FROM feedback WHERE archive = 0 ORDER BY id");
    }

    /**
     * Возвращает массив всех архивных сообщений
     * @return array
     */
    public function getAllArchive() {
        return $this->getDb()->getAll("SELECT * FROM feedback WHERE archive = 1 ORDER BY id");
    }

    /**
     * Возвращает количество всех сообщений
     * @return int
     */
    public function getAllCount() {
        return $this->getDb()->getOne("SELECT COUNT(*) FROM feedback");
    }

    /**
     * Возвращает количество всех не архивных сообщений
     * @return int
     */
    public function getAllNotArchiveCount() {
        return $this->getDb()->getOne("SELECT COUNT(*) FROM feedback WHERE archive = 0");
    }

    /**
     * Возвращает количество всех архивных сообщений
     * @return int
     */
    public function getAllArchiveCount() {
        return $this->getDb()->getOne("SELECT COUNT(*) FROM feedback WHERE archive = 1");
    }

    /**
     * Перемещение нескольких сообщений в архив
     * @param array $id - массив id сообщений
     * @return boolean
     */
    public function multipleArchive($id) {
        return $this->getDb()->query("UPDATE feedback SET archive = 1 WHERE id IN (?a)", $id);
    }

    /**
     * Удаление нескольких сообщений
     * @param array $id - массив id сообщений
     * @return boolean
     */
    public function multipleDelete($id) {
        return $this->getDb()->query("DELETE  FROM feedback WHERE id IN (?a)", $id);
    }

    /**
     * Перемещение сообщения в архив
     * @param int $id id сообщения
     * @return array
     */
    public function archive($id) {
        return $this->getDb()->query("UPDATE feedback SET archive = 1 WHERE id = ?i", $id);
    }

    /**
     * Удаление сообщения
     * @param array $id - id сообщения
     * @return boolean
     */
    public function delete($id) {
        return $this->getDb()->query("DELETE  FROM feedback WHERE id = ?i", $id);
    }
} 