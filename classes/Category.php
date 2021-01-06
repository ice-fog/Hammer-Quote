<?php

/**
 * Класс Category - Все возможные операции с категориями
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Category extends Core{

    /**
     * Создание древовидного массива
     * @param array $data - исходный массив
     * @return array
     */
    private function tree($data) {
        $new = array();
        foreach($data as $a) {
            $a['count'] = getRecordsCount($data, $a['id'], $a['count']);
            $new[$a['parent']][] = $a;
        }
        return createTreeArray($new, $new[0]);
    }

    /**
     * Возвращает древовидный массив всех категорий
     * @return array
     */
    public function getAll() {
        $data = $this->getDb()->getAll("SELECT (SELECT COUNT(*) FROM content WHERE category = category.id) as count, category.* FROM category ORDER BY id");
        if(count($data) == 0)
            return false;
        return $this->tree($data);
    }

    /**
     * Возвращает json с данными всех категорий
     * @return string
     */
    public function getAllJSON() {
        $data = $this->getDb()->getAll("SELECT id, name, parent, status FROM category ORDER BY id");
        arrayRenameKey($data, 'name', 'text');
        $json =  json_encode($data);
        $json = str_replace('"parent":"0"', '"parent":"#"', $json);
        $json = str_replace('"status":"0"', '"type":"disabled"', $json);
        $json = str_replace('"status":"1"', '"type":"default"', $json);
        return $json;
    }

    /**
     * Возвращает древовидный массив активных категорий
     * @return array
     */
    public function getAllPublic() {
        $data = $this->getDb()->getAll("SELECT (SELECT COUNT(*) FROM content WHERE category = category.id AND status = 1) as count, category.* FROM category WHERE status = 1 ORDER BY id");
        if(count($data) == 0)
            return false;
        return $this->tree($data);
    }

    /**
     * Возвращает массив активных категорий
     * @return array
     */
    public function getAllPublicNotTree() {
        return  $this->getDb()->getAll("SELECT (SELECT COUNT(*) FROM content WHERE category = category.id AND status = 1) as count, category.* FROM category WHERE status = 1 ORDER BY id");
    }

    /**
     * Возвращает массив id всех категорий
     * @return array
     */
    public function getAllId() {
        $data = $this->getDb()->getAll("SELECT id FROM category ORDER BY id");
        $result = array();
        foreach($data as $t) {
            $result[] = $t['id'];
        }
        return $result;
    }

    /**
     * Проверяет есть ли такой url если есть возвращает его id
     * @param $url
     * @return bool|int
     */
    public function checkFreeURL($url){
        return $this->getDb()->getOne("SELECT id FROM category WHERE url = ?s", $url);
    }

    /**
     * Возвращает массив одной категории
     * @param int $id - id категории
     * @return array
     */
    public function getOne($id) {
        return $this->getDb()->getRow("SELECT * FROM category WHERE id = ?i", $id);
    }

    /**
     * Возвращает id всех вложеных категорий
     * @param int $id - id категории
     * @return array
     */
    public function getAllSubId($id) {
        $data = $this->getDb()->getAll("SELECT id, parent FROM category ORDER BY id");
        $result = explode('|', getAllSubId($data, $id));
        array_pop($result);
        return $result;
    }

    /**
     * Возвращает id родительской категории
     * @param int $id - id категории
     * @return int
     */
    public function getParentId($id) {
        return $this->getDb()->getOne("SELECT parent FROM category WHERE id = ?i", $id);
    }

    /**
     * Возвращает id только активный категории по ее url
     * @param string $url - url категории
     * @return int
     */
    public function getPublicIdByUrl($url) {
        return $this->getDb()->getOne("SELECT id FROM category WHERE url = ?s AND status = 1", $url);
    }

    /**
     * Возвращает описание категории
     * @param int $id - id категории
     * @return string
     */
    public function getDescription($id) {
        return $this->getDb()->getOne("SELECT description FROM category WHERE id = ?i", $id);
    }

    /**
     * Возвращает имя категории
     * @param int $id - id категории
     * @return string
     */
    public function getName($id) {
        return $this->getDb()->getOne("SELECT name FROM category WHERE id = ?i", $id);
    }

    /**
     * Возвращает имя и описание категории
     * @param int $id - id категории
     * @return array
     */
    public function getMeta($id) {
        return $this->getDb()->getRow("SELECT name, description  FROM category WHERE id = ?i", $id);
    }

    /**
     * Возвращает id категории по ее url
     * @param string $url - url категории
     * @return int
     */
    public function getId($url) {
        return $this->getDb()->getOne("SELECT url FROM category WHERE url = ?s", $url);
    }

    /**
     * Возвращает значения статуса категории
     * @param int $id id категории
     * @return int
     */
    public function getStatus($id) {
        if($id == 0){
            return 1;
        }else{
            return $this->getDb()->getOne("SELECT status FROM category WHERE id = ?i", $id);
        }

    }

    /**
     * Возвращает url родительской категории
     * @param $id - id категории
     * @return string
     */
    public function getParentUrl($id) {
        return $this->getDb()->getOne("SELECT url FROM category WHERE id = ?i", $id);
    }

    /**
     * Возвращает значения статуса родительской категории
     * @param int $id - id категории
     * @return int
     */
    public function getParentStatus($id) {
        $parentId = $this->getParentId($id);
        if($parentId == 0) {
            return 1;
        } else {
            return $this->getDb()->getOne("SELECT status FROM category WHERE id = ?i", $parentId);
        }
    }

    /**
     * Возвращает массив id дочерних категорий первого уровня
     * @param int $id - id категории
     * @return array
     */
    public function getSubId($id) {
        $result = array();
        $data = $this->getDb()->getAll("SELECT id FROM category WHERE parent = ?i", $id);
        foreach($data as $t) {
            $result[] = $t['id'];
        }
        return $result;
    }

    /**
     * Изменение статуса нескольких категорий
     * @param array $id - id категорий
     * @param int $status - статус 1 активна 0 не активна
     * @return bool
     */
    public function multipleUpdateStatus($id, $status) {
        $data = $this->getDb()->getAll("SELECT id, parent FROM category ORDER BY id");
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
        return $this->getDb()->query("UPDATE category SET status = ?i WHERE id IN (?a)", $status, $updateId);
    }

    /**
     * Удаления нескольких категорий
     * @param array $id - id категорий
     * @return bool
     */
    public function multipleDelete($id) {
        foreach($id as $t) {
            if($this->updateParent($this->getParentId($t), $this->getSubId($t))) {
                if(!$this->getDb()->query("DELETE FROM category WHERE id = ?i", $t)) {
                    return false;
                }
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * Изменение статуса категории
     * @param int $id - id категории
     * @param int $status - статус 1 активна 0 не активна
     * @return bool
     */
    public function updateStatus($id, $status) {
        if($this->getParentStatus($id) > 0) {
            return $this->getDb()->query("UPDATE category SET status = ?i WHERE id IN (?a)", $status, $this->getAllSubId($id));
        } else {
            return false;
        }
    }

    /**
     * Изменение родительской категории
     * @param int $parent - id новый радительской категории
     * @param array $id - id категории
     * @return bool
     */
    public function updateParent($parent, $id) {
        return $this->getDb()->query("UPDATE category SET parent = ?i WHERE id IN (?a)", $parent, $id);
    }

    /**
     * Удаления катигории
     * @param int $id - id категории
     * @return bool
     */
    public function delete($id) {
        if($this->updateParent($this->getParentId($id), $this->getSubId($id))) {
            return $this->getDb()->query("DELETE  FROM category WHERE id = ?i", $id);
        } else {
            return false;
        }
    }

    /**
     * Добавление категории
     * @param int $parent - id родительской категории
     * @param string $name - название категории
     * @param string $url - адрес категории
     * @param int $status - статус 1 активна 0 не активна
     * @param string $description - описание категории
     * @return bool
     */
    public function add($parent, $name, $url, $status, $description) {
        if($parent == 0) {
            $status = 1;
        } elseif($this->getStatus($parent) == 0) {
            $status = 0;
        }
        return $this->getDb()->query("INSERT INTO category (name, parent, url, status, description) VALUES (?s, ?i, ?s, ?i, ?s)", $name, $parent, $url, $status, $description);
    }

    /**
     * Изменение категории
     * @param int $id - id категории
     * @param int $parent - id родительской категории
     * @param string $name - название категории
     * @param string $url - адрес категории
     * @param int $status - статус 1 активна 0 не активна
     * @param string $description - описание категории
     * @param int $oldParent - id текущий родительской категории
     * @return bool
     */
    public function edit($id, $parent, $name, $url, $status, $description, $oldParent) {
        if($parent == 0) {
            $status = 1;
        } elseif($this->getStatus($parent) == 0) {
            $status = 0;
        }
        if($parent !== $oldParent){
            $this->updateParent($this->getParentId($id), $this->getSubId($id));
        }
        return $this->getDb()->query("UPDATE category SET name = ?s, url = ?s, status = ?i, parent = ?i, description = ?s WHERE id = ?i", $name, $url, $status, $parent, $description, $id);
    }
}
