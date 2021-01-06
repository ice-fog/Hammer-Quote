<?php

/**
 * Класс Comments - Все возможные операции c комментариями
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Comments extends Core{

    /**
     * Создание древовидного массива
     * @param array $data - исходный массив
     * @return array
     */
    private function tree($data) {
        $new = array();
        foreach($data as $a) {
            $new[$a['parent']][] = $a;
        }
        return createTreeArray($new, $new[0]);
    }

    /**
     * Добавление комментария
     * @param int $content - id записи
     * @param int $parent - id родителя
     * @param int $ip - ip адрес
     * @param string $name - имя
     * @param string $email - email
     * @param string $message - сообщение
     * @param int $status - 1 активный 0 нет
     * @return boolean
     */
    public function add($content, $parent, $ip, $name, $email, $message, $status) {
        if($this->getDb()->query("INSERT INTO comments (content, parent, ip, name, email, message, status) VALUES (?i, ?i, ?s, ?s, ?s, ?s, ?i)", $content, $parent, $ip, $name, $email, $message, $status)) {
            if($this->getSettings()->settings['notifications-enable']) {
                $this->getNotify()->newComment($name, $email, $message);
            }
            return true;
        }
        return false;
    }

    /**
     * Удаление комментария
     * @param int $id - id комментария
     * @return boolean
     */
    public function delete($id) {
        return $this->getDb()->query("DELETE FROM comments WHERE id IN (?a)", $this->getAllSubId($id));
    }

    /**
     * Удаление комментариев для записи
     * @param int | array $content - id записи или массив id
     * @return boolean
     */
    public function deleteByContent($content) {
        if(is_array($content)) {
            return $this->getDb()->query("DELETE FROM comments WHERE content IN (?a)", $content);
        } else {
            return $this->getDb()->query("DELETE FROM comments WHERE content = ?i", $content);
        }
    }

    /**
     * Редактирование комментария
     * @param int $id - id комментария
     * @param string $name - имя
     * @param string $email - email
     * @param string $message - сообщение
     * @param string $status - 1 активный 0 нет
     * @return boolean
     */
    public function edit($id, $name, $email, $message, $status) {
        return $this->getDb()->query("UPDATE comments SET name = ?s, email = ?s, message = ?s, status = ?i WHERE id = ?i", $name, $email, $message, $status, $id);
    }

    /**
     * Возвращает древовидный массив всех комментариев для записи
     * @param int $id - id записи
     * @return array
     */
    public function getAllByContent($id) {
        $data = $this->getDb()->getAll("SELECT * FROM comments WHERE content = ?i ORDER BY id DESC", $id);
        if(count($data) == 0)
            return false;
        return $this->tree($data);
    }

    /**
     * Возвращает древовидный массив активных комментариев для записи
     * @param int $id - id записи
     * @return array
     */
    public function getAllActiveByContent($id) {
        $data = $this->getDb()->getAll("SELECT * FROM comments WHERE content = ?i AND status = 1 ORDER BY id DESC", $id);
        if(count($data) == 0)
            return false;
        return $this->tree($data);
    }

    /**
     * Возвращает древовидный массив всех неактивных комментариев
     * @return array
     */
    public function getAllInactive() {
        $data = $this->getDb()->getAll("SELECT * FROM comments WHERE status = 0 ORDER BY id DESC");
        if(count($data) == 0)
            return false;
        return $this->tree($data);
    }

    /**
     * Возвращает древовидный массив всех активных комментариев
     * @return array
     */
    public function getAllActive() {
        $data = $this->getDb()->getAll("SELECT * FROM comments WHERE status = 1 ORDER BY id DESC");
        if(count($data) == 0)
            return false;
        return $this->tree($data);
    }

    /**
     * Возвращает древовидный массив комментариев
     * @param int $limit - лимит на выборку
     * @param int $page - страница
     * @return array
     */
    public function get($limit, $page) {
        $data = $this->getDb()->getAll("SELECT * FROM comments ORDER BY id DESC LIMIT ?i, ?i", $page * $limit - $limit, $limit);
        if(count($data) == 0)
            return false;
        return $this->tree($data);
    }

    /**
     * Возвращает древовидный массив комментариев для записи
     * @param int $id - id записи
     * @param int $limit - лимит на выборку
     * @param int $page - страница
     * @return array
     */
    public function getByContent($id, $limit, $page) {
        $data = $this->getDb()->getAll("SELECT * FROM comments WHERE content = ?i ORDER BY id DESC LIMIT ?i, ?i", $id, $page * $limit - $limit, $limit);
        if(count($data) == 0)
            return false;
        return $this->tree($data);
    }

    /**
     * Возвращает древовидный массив активных комментариев
     * @param int $limit - лимит на выборку
     * @param int $page - страница
     * @return array
     */
    public function getActive($limit, $page) {
        $data = $this->getDb()->getAll("SELECT * FROM comments WHERE status = 1 ORDER BY id DESC LIMIT ?i, ?i", $page * $limit - $limit, $limit);
        if(count($data) == 0)
            return false;
        return $this->tree($data);
    }

    /**
     * Возвращает древовидный массив неактивных комментариев
     * @param int $limit - лимит на выборку
     * @param int $page - страница
     * @return array
     */
    public function getInactive($limit, $page) {
        $data = $this->getDb()->getAll("SELECT * FROM comments WHERE status = 0 ORDER BY id DESC LIMIT ?i, ?i", $page * $limit - $limit, $limit);
        if(count($data) == 0)
            return false;
        return $this->tree($data);
    }

    /**
     * Возвращает количество неактивных комментариев
     * @return int
     */
    public function getInactiveCount() {
        return $this->getDb()->getOne("SELECT COUNT(id) FROM comments WHERE status = 0");
    }

    /**
     * Возвращает общее количество комментариев
     * @return int
     */
    public function getCount() {
        return $this->getDb()->getOne("SELECT COUNT(id) FROM comments");
    }

    /**
     * Возвращает общее количество комментариев для записи
     * @param int $id - id записи
     * @return int
     */
    public function getCountByContent($id) {
        return $this->getDb()->getOne("SELECT COUNT(id) FROM comments WHERE content = ?i ORDER BY id DESC", $id);
    }

    /**
     * Возвращает количество активных комментариев для записи
     * @param int $id - id записи
     * @return int
     */
    public function getActiveCountByContent($id) {
        return $this->getDb()->getOne("SELECT COUNT(id) FROM comments WHERE content = ?i AND status = 1 ORDER BY id DESC", $id);
    }

    /**
     * Возвращает количество комментариев соответствующих поисковому запросу
     * @param string $search - поисковый запрос
     * @return int
     */
    public function searchCount($search) {
        return $this->getDb()->getOne("SELECT COUNT(*) FROM comments WHERE message  LIKE '%' ?s '%' ORDER BY id", $search);
    }

    /**
     * Возвращает древовидный массив комментариев соответствующих поисковому запросу
     * @param int $limit - лимит на выборку
     * @param int $page - страница
     * @param string $search - поисковый запрос
     * @return array
     */
    public function search($limit, $page, $search) {
        return $data = $this->getDb()->getAll("SELECT * FROM comments WHERE message  LIKE '%' ?s '%' ORDER BY id LIMIT ?i, ?i", $search, $page * $limit - $limit, $limit);
    }

    /**
     * Возвращает массив одного комментария
     * @param int $id - id комментария
     * @return array
     */
    public function getOne($id) {
        return $this->getDb()->getRow("SELECT * FROM comments WHERE id = ?i", $id);
    }

    /**
     * Возвращает id всех дочерних комментариев
     * @param int $id - id родительского комментария
     * @return array
     */
    public function getAllSubId($id) {
        $data = $this->getDb()->getAll("SELECT id, parent FROM comments ORDER BY id");
        $result = explode('|', getAllSubId($data, $id));
        array_pop($result);
        return $result;
    }

    /**
     * Возвращает id родительского комментария
     * @param int $id - id комментария
     * @return int
     */
    public function getParentId($id) {
        return $this->getDb()->getOne("SELECT parent FROM comments WHERE id = ?i", $id);
    }

    /**
     * Возвращает значения статуса родительского комментария
     * @param int $id - id комментария
     * @return int
     */
    public function getParentStatus($id) {
        $parentId = $this->getParentId($id);
        if($parentId == 0) {
            return 1;
        } else {
            return $this->getDb()->getOne("SELECT status FROM comments WHERE id = ?i", $parentId);
        }
    }

    /**
     * Возвращает значения статуса комментария
     * @param int $id - id комментария
     * @return int
     */
    public function getStatus($id) {
        return $this->getDb()->getOne("SELECT status FROM comments WHERE id = ?i", $id);
    }

    /**
     * Изменение статуса комментария
     * @param int $id - id комментария
     * @param int $status - 1 активный 0 нет
     * @return boolean
     */
    public function updateStatus($id, $status) {
        if($this->getParentStatus($id) > 0) {
            return $this->getDb()->query("UPDATE comments SET status = ?i WHERE id IN (?a)", $status, $this->getAllSubId($id));
        } else {
            return false;
        }
    }

    /**
     * Изменение статуса нескольких комментариев
     * @param array $id - массив id комментариев
     * @param int $status - новый статус 1 активный 0 не активный
     * @return boolean
     */
    public function multipleUpdateStatus($id, $status) {
        $data = $this->getDb()->getAll("SELECT * FROM comments ORDER BY id");
        $updateId = array();
        foreach($id as $t) {
            $updateId[] = $t;
        }
        foreach($id as $t) {
            $array = explode('|', getAllSubId($data, $t));
            array_pop($array);
            foreach($array as $u) {
                $updateId[] = $u;
            }
        }
        $updateId = array_unique($updateId);
        return $this->getDb()->query("UPDATE comments SET status = ?i WHERE id IN (?a)", $status, $updateId);
    }

    /**
     * Удаление нескольких комментариев
     * @param array $id - массив id комментариев
     * @return boolean
     */
    public function multipleDelete($id) {
        $data = $this->getDb()->getAll("SELECT * FROM comments ORDER BY id");
        $deleteId = array();
        foreach($id as $t) {
            $deleteId[] = $t;
        }
        foreach($id as $t) {
            $array = explode('|', getAllSubId($data, $t));
            array_pop($array);
            foreach($array as $u) {
                $deleteId[] = $u;
            }
        }
        $deleteId = array_unique($deleteId);
        return $this->getDb()->query("DELETE  FROM comments WHERE id IN (?a)", $deleteId);
    }
}