<?php

/**
 * Класс Images - Управление изображениями
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Images extends Core{

    /**
     * Изображение
     * @var resource
     */
    private $image;

    /**
     * Тип изображения
     * @var string
     */
    private $type;

    /**
     * Получение информации о изображении для дальнейших манипуляций
     * @param string $filename - путь к изображению
     */
    private function load($filename) {
        $imageInfo = getimagesize($filename);
        $this->type = $imageInfo[2];
        if($this->type == IMAGETYPE_JPEG) {
            $this->image = imagecreatefromjpeg($filename);
        } elseif($this->type == IMAGETYPE_GIF) {
            $this->image = imagecreatefromgif($filename);
        } elseif($this->type == IMAGETYPE_PNG) {
            $this->image = imagecreatefrompng($filename);
        }
    }

    /**
     * Сохранение изображения
     * @param string $filename - путь к изображению
     * @param int $type - тип изображения
     * @param int $compression - уровень сжатие изображения
     * @param int $permissions - права доступа для изображения
     */
    private function save($filename, $type = IMAGETYPE_JPEG, $compression = 75, $permissions = null) {
        if($type == IMAGETYPE_JPEG) {
            imagejpeg($this->image, $filename, $compression);
        } elseif($type == IMAGETYPE_GIF) {
            imagegif($this->image, $filename);
        } elseif($type == IMAGETYPE_PNG) {
            imagepng($this->image, $filename);
        }
        if($permissions != null) {
            chmod($filename, $permissions);
        }
    }

    /**
     * Возвращает ширину изображения
     * @return int
     */
    private function getWidth() {
        return imagesx($this->image);
    }

    /**
     * Возвращает высоту изображения
     * @return int
     */
    private function getHeight() {
        return imagesy($this->image);
    }

    /**
     * Изменения разрешения изображения
     * @param int $width - ширина
     * @param int $height - высота
     */
    private function resize($width, $height) {
        $newImage = imagecreatetruecolor($width, $height);
        imagecopyresampled($newImage, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $newImage;
    }

    /**
     * Удаления изображения
     * @param string $name - имя изображения
     */
    public function delete($name) {
        if(file_exists($this->getRootDir() . $this->getSettings()->settings['images-dir']  . '/' . $name)) {
            unlink($this->getRootDir() . $this->getSettings()->settings['images-dir']  . '/' . $name);
        }
        if(file_exists($this->getRootDir() . $this->getSettings()->settings['images-thumb-dir'] . '/' . $name)) {
            unlink($this->getRootDir() . $this->getSettings()->settings['images-thumb-dir'] . '/' . $name);
        }
    }

    /**
     * Множественное удаления изображений
     * @param array $names - имяна изображений
     */
    public function multipleDelete($names) {
        foreach($names as $name) {
            $this->delete($name);
        }
    }

    /**
     * Добавление изоброжения
     * @return array
     */
    public function add() {
        $error = '';
        $images = array();
        foreach($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $fileTmp = $_FILES['images']['tmp_name'][$key];
            $preName = $_FILES['images']['name'][$key];
            $fileExt = explode('.', $preName );
            $fileExt = end($fileExt);
            $fileExt = strtolower($fileExt);
            $newName = $this->getStartTime() . '-' . md5($preName) . '.' . $fileExt;
            if(in_array($fileExt, array('jpeg','jpg','png','gif')) === true) {
                if(move_uploaded_file($fileTmp, $this->getRootDir() . $this->getSettings()->settings['images-dir'] . '/' . $newName)) {
                    $this->load($this->getRootDir() . $this->getSettings()->settings['images-dir'] . '/' . $newName);
                    $this->resize(400, 250);
                    $this->save($this->getRootDir() . $this->getSettings()->settings['images-thumb-dir'] . '/' . $newName);
                    $images[] = $newName;
                } else
                    $error = 'Ошибка загрузке. Некоторые файлы не могут быть загружены.';
            } else {
                $error = 'Ошибка загрузке. Тип файла не допускается.';
            }
        }
        return array(
            'error' => $error,
            'images' => $images
        );
    }

    /**
     * Добавление изоброжения для контента
     * @return array
     */
    public function addByContent() {
        $fileTmp = $_FILES['file']['tmp_name'];
        $preName  = $_FILES['file']['name'];
        $fileExt = explode('.', $preName );
        $fileExt = end($fileExt);
        $fileExt = strtolower($fileExt);
        $newName = $this->getStartTime() . '-' . md5($preName ) . '.' . $fileExt;
        if(move_uploaded_file($fileTmp, $this->getRootDir() . $this->getSettings()->settings['images-dir'] . '/' . $newName)) {
            $this->load($this->getRootDir() . $this->getSettings()->settings['images-dir'] . '/' . $newName);
            $height = $this->getHeight();
            $width = $this->getWidth();
        } else{
            return false;
        }
        $array = array(
            'image' => array(
                'url' => $this->getSettings()->settings['images-dir'] . '/' . $newName,
                'height' => $height,
                'width' => $width
            )
        );
        return json_encode($array);
    }
}