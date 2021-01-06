<?php

/**
 * Класс Site
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Site extends Core {

    public function viewHome() {
        $header = $this->getSettings()->settings['site-title'];
        if($this->getSettings()->settings['home-content'] == 'random') {
            $template = 'content';
            $data = $this->getContent()->getPublicRandom($this->getSettings()->settings['records-page']);
        } elseif($this->getSettings()->settings['home-content'] == 'new') {
            $template = 'content';
            $data = $this->getContent()->getPublicSortedByTime($this->getSettings()->settings['records-page'], 1);
        } else {
            $template = 'page';
            $data = $this->getSysPages()->getHomePage();
        }
        return array(
            'template' => $template,
            'title' => $header,
            'description' => $this->getSettings()->settings['site-description'],
            'header' => array(
                'header' => $header
            ),
            'data' => array(
                'header' => $header,
                'content' => $data
            ),
            'side' => array('category' => $this->getCategory()->getAllPublic())
        );
    }

    public function viewTime($page) {
        $template = 'content';
        $header = 'Записи по дате добавления';
        $count = $this->getContent()->getActiveCount();
        $data = $this->getContent()->getPublicSortedByTime($this->getSettings()->settings['records-page'], $page);
        $pageCount = $count > 0 ? (intval(($count - 1) / $this->getSettings()->settings['records-page']) + 1) : 0;
        $url = '/new/';
        return array(
            'template' => $template,
            'title' => $header,
            'description' => 'Записи отсортированные по дате добавления',
            'header' => array(
                'header' => $header
            ),
            'data' => array(
                'content' => $data,
                'count' => $count,
                'limit' => $this->getSettings()->settings['records-page'],
                'page-count' => $pageCount,
                'page' => $page,
                'url' => $url,
            ),
            'side' => array('category' => $this->getCategory()->getAllPublic())
        );
    }

    public function viewRating($page) {
        $template = 'content';
        $header = 'Записи по рейтингу';
        $count = $this->getContent()->getActiveCount();
        $data = $this->getContent()->getPublicSortedByRating($this->getSettings()->settings['records-page'], $page);
        $pageCount = $count > 0 ? (intval(($count - 1) / $this->getSettings()->settings['records-page']) + 1) : 0;
        $url = '/best/';
        return array(
            'template' => $template,
            'title' => $header,
            'description' => 'Записи отсортированные по рейтингу',
            'header' => array(
                'header' => $header
            ),
            'data' => array(
                'content' => $data,
                'count' => $count,
                'limit' => $this->getSettings()->settings['records-page'],
                'page-count' => $pageCount,
                'page' => $page,
                'url' => $url,
            ),
            'side' => array('category' => $this->getCategory()->getAllPublic())
        );
    }

    public function viewRandom() {
        $template = 'content';
        $header = 'Случайные записи';
        $data = $this->getContent()->getPublicRandom(30);
        return array(
            'template' => $template,
            'title' => $header,
            'description' => 'Записи в случайном порядке',
            'header' => array(
                'header' => $header
            ),
            'data' => array(
                'content' => $data
            ),
            'side' => array('category' => $this->getCategory()->getAllPublic())
        );
    }

    public function viewGallery($page) {
        $title = $this->getSettings()->settings['gallery-title'];
        $count = $this->getGallery()->getPublicCount();
        $header = $this->getSettings()->settings['gallery-title'];
        $content = $this->getGallery()->getPublic($this->getSettings()->settings['records-page'], $page);
        $url = '/' . $this->getSettings()->settings['gallery-url'] . '/';
        $pageCount = $count > 0 ? (intval(($count - 1) / $this->getSettings()->settings['records-page']) + 1) : 0;

        return array(
            'template' => 'gallery',
            'title' => $title,
            'description' => $this->getSettings()->settings['gallery-description'],
            'header' => array(
                'header' => $header
            ),
            'data' => array(
                'content' => $content,
                'count' => $count,
                'limit' => $this->getSettings()->settings['records-page'],
                'page-count' => $pageCount,
                'page' => $page,
                'url' => $url,
            ),
            'side' => array(
                'category' => $this->getCategory()->getAllPublic(),
                'count' => $count
            )
        );
    }

    public function viewContent($page, $categoryUrl = null, $searchString = null) {
        if(isset($searchString)) {
            $title = 'Результаты поиска';
            $header = 'Результаты поиска';
            $count = $this->getContent()->searchPublicCount($searchString);
            if($count > 0) {
                $content = $this->getContent()->searchPublic($this->getSettings()->settings['records-page'], $page, $searchString);
                $searchResult = TRUE;
                $url = '/search/?search=' . $searchString . '&page=';
            } else {
                $content = false;
                $searchResult = FALSE;
            }
        } else {
            $id = $this->getCategory()->getPublicIdByUrl($categoryUrl);
            if(is_numeric($id)) {
                $meta = $this->getCategory()->getMeta($id);
                $title = $meta['name'];
                $description = $meta['description'];
                $count = $this->getContent()->getPublicCountByCategory($id);
                $header = $meta['name'];
                $content = $this->getContent()->getPublicByCategory($this->getSettings()->settings['records-page'], $page, $id);
                $url = '/category/' . $categoryUrl . '/';
            } else {
                return $this->viewNotFound();
            }
        }

        $pageCount = $count > 0 ? (intval(($count - 1) / $this->getSettings()->settings['records-page']) + 1) : 0;

        return array(
            'template' => 'content',
            'title' => $title,
            'description' => $description,
            'header' => array(
                'header' => $header
            ),
            'data' => array(
                'content' => $content,
                'count' => $count,
                'limit' => $this->getSettings()->settings['records-page'],
                'search-string' => $searchString,
                'search-result' => $searchResult,
                'page-count' => $pageCount,
                'page' => $page,
                'url' => $url,
            ),
            'side' => array(
                'category' => $this->getCategory()->getAllPublic(),
                'active' => $id,
                'count' => $count
            )
        );
    }

    public function viewSingle($id) {
        if(is_numeric($id)) {
            $content = $this->getContent()->getOneRow($id);
            if($content) {
                return array(
                    'template' => 'single',
                    'title' => 'Контент',
                    'data' => array(
                        'header' => 'Запись номер ' . $id,
                        'content' => $content,
                        'comments' => $this->getComments()->getAllActiveByContent($id),
                        'comments-count' => $this->getComments()->getActiveCountByContent($id)
                    ),
                    'side' => array(
                        'category' => $this->getCategory()->getAllPublic(),
                        'active' => 0,
                    ),
                );
            } else {
                return $this->viewNotFound();
            }
        } else {
            return $this->viewNotFound();
        }
    }

    public function viewAdd() {
        $category = $this->getCategory()->getAllPublic();
        return array(
            'template' => 'add',
            'title' => 'Прислать свой материал',
            'header' => array(
                'header' => 'Прислать свой материал'
            ),
            'data' => array(
                'category' => $category
            ),
            'side' => array('category' => $category)
        );
    }

    public function viewFeedback() {
        return array(
            'template' => 'feedback',
            'title' => 'Обратная связь',
            'header' => array('header' => 'Обратная связь'),
            'data' => array('header' => 'Обратная связь'),
            'side' => array('category' => $this->getCategory()->getAllPublic())
        );
    }

    public function viewPage($url) {
        $page = $this->getPages()->getOnePageByUrl($url);
        if(is_array($page)) {
            return array(
                'template' => 'page',
                'title' => $page['title'],
                'description' => $page['description'],
                'header' => array(
                    'header' => $page['title']
                ),
                'data' => array(
                    'content' => $page['content']
                ),
                'side' => array('category' => $this->getCategory()->getAllPublic())
            );
        } else {
            return $this->viewNotFound();
        }
    }

    public function viewNotFound() {
        header("HTTP/1.0 404 Not Found");
        return array(
            'template' => 'page',
            'title' => 'Страница не найдена',
            'header' => array('header' => 'Страница не найдена'),
            'data' => array(
                'content' => $this->getSysPages()->getNotFoundPage()
            ),
            'side' => array(
                'category' => $this->getCategory()->getAllPublic()
            )
        );
    }

    public function addContent($category, $content) {
        if($this->getContent()->add($category, $content, 0)) {
            if($this->getSettings()->settings['notifications-enable']) {
                $this->getNotify()->newContent($content);
            }
            return true;
        }
        return false;
    }

    public function addComment($content, $parent, $name, $email, $message) {
        if($this->getComments()->add($content, $parent, $_SERVER['REMOTE_ADDR'], $name, $email, $message, 0)) {
            if($this->getSettings()->settings['enable-notifications'] == 1) {
                $this->getNotify()->newComment($name, $email, $message);
            }
            return true;
        }
        return false;
    }

    public function addFeedback($name, $email, $message) {
        if($this->getFeedback()->add($name, $email, $message, $_SERVER['REMOTE_ADDR'])) {
            if($this->getSettings()->settings['notifications-enable']) {
                $this->getNotify()->newFeedback($name, $email, $message);
            }
            return true;
        }
        return false;
    }

    public function getPagesLinks() {
        return $this->getPages()->getPublicLinks();
    }

    public  function unsubscribe($base64Emai){
        $email = base64_decode($base64Emai);
        if($this->getEmailDelivery()->checkEmail($email)){
            $this->getEmailDelivery()->deleteByEmail($email);
            echo 'Вы отписались от рассылки!';
        } else {
            echo 'Произошла ошибка!';
        }
    }

}
