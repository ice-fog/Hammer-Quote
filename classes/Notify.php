<?php

/**
 * Класс Comments - Отправка email уведомлений
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Notify extends Core {

    /**
     * Отправка email сообщения
     * @param string $to - email получателя
     * @param string $subject - тема отправляемого сообщения
     * @param string $message - отправляемое сообщение
     */
    public function email($to, $subject, $message) {
        $headers = "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=utf-8; \r\n";
        mail($to, $subject, $message, $headers);
    }

    /**
     * Уведомления о новый записи
     * @param string $content - запись
     */
    public function newContent($content) {
        $data = array(
            'header' => 'Новая запись на сайте ' . $this->getHTTPHost(),
            'user-info' => false,
            'message' => $content,
            'link' => array(
                'url' => $this->getHTTPHost() . '/admin/content',
                'name' => 'Просмотреть в админ панели'
            )
        );
        $message = $this->getTemplate()->compileBloc('email/email', $data);
        $this->email($this->getSettings()->settings['email'], 'Новая запись на сайте ' . $this->getHTTPHost(), $message);
    }

    /**
     * Уведомления о новым коминтарии
     * @param string $name - имя
     * @param string $email - email
     * @param string $message - сообщение
     */
    public function newComment($name, $email, $message) {
        $data = array(
            'header' => 'Новый комментарий на сайте ' . $this->getHTTPHost(),
            'user-info' => true,
            'name' => $name,
            'email' => $email,
            'action' => 'оставил комментарий',
            'message' => $message,
            'link' => array(
                'url' => $this->getHTTPHost(). '/admin/comments',
                'name' => 'Просмотреть в админ панели'
            )
        );
        $message = $this->getTemplate()->compileBloc('email/email', $data);
        $this->email($this->getSettings()->settings['email'], 'Новый комментарий на сайте ' . $this->getHTTPHost(), $message);
    }

    /**
     * Уведомления о новым сообщении через обратную связь
     * @param string $name - имя
     * @param string $email - email
     * @param string $message - сообщение
     */
    public function newFeedback($name, $email, $message) {
        $data = array(
            'header' => 'Новое сообщение от пользователя сайта ' . $this->getHTTPHost(),
            'user-info' => true,
            'name' => $name,
            'email' => $email,
            'action' => 'оставил сообщения',
            'message' => $message,
            'link' => array(
                'url' => $this->getHTTPHost() . '/admin/feedback',
                'name' => 'Просмотреть сообщения в админ панели'
            )
        );
        $message = $this->getTemplate()->compileBloc('/email/email', $data);
        $this->email($this->getSettings()->settings['email'], 'Новое сообщение от пользователя сайта ' . $this->getHTTPHost(), $message);
    }

} 