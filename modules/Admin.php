<?php

/**
 * Класс Admin - Админ панель
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Admin extends Core {

    public function managementMainSettings() {
        return array(
            'template' => 'settings',
            'title' => 'Настройки скрипта',
            'data' => array('data' => include $this->getRootDir() . '/data/settings.php',),
            'side' => array(
                'title' => 'Опции',
                'data' => array(
                    array(
                        'name' => 'Редактирование профиля',
                        'class' => 'profile-edit',
                        'url' => '#'
                    )
                )
            )
        );
    }

    public function managementContent($limit, $page, $filter = NULL, $searchString = NULL) {
        if(isset($searchString) && mb_strlen($searchString) > 0 && mb_strlen($searchString) < 60) {
            $count = $this->getContent()->searchCount($searchString);
            if($count > 0) {
                $data = $this->getContent()->search($limit, $page, $searchString);
                $pageCount = intval(($count - 1) / $limit) + 1;
                $searchResult = TRUE;
                $url = '/admin/content/search/?search=' . $searchString . '&page=';
            } else {
                $count = $this->getContent()->getCount();
                $data = $this->getContent()->get($limit, 1);
                $pageCount = intval(($count - 1) / $limit) + 1;
                $searchResult = FALSE;
                $url = '/admin/content/';
            }
            $active = 0;
        } else {
            if(isset($filter)) {
                if($filter == 'without-category') {
                    $count = $this->getContent()->getCountWithoutCategory();
                    $data = $this->getContent()->getWithoutCategory($limit, $page);
                    $url = '/admin/content/category/without/';
                    $active = -1;
                } elseif($filter == 'inactive') {
                    $count = $this->getContent()->getInactiveCount();
                    $data = $this->getContent()->getInactive($limit, $page);
                    $url = '/admin/content/inactive/';
                    $active = $filter;
                } elseif($filter == 'one') {
                    $count = 1;
                    $data = $this->getContent()->getOne($this->getRoute(4));
                    $url = '';
                    $active = $filter;
                } else {
                    $count = $this->getContent()->getCountByCategory($filter);
                    $data = $this->getContent()->getByCategory($limit, $page, $filter);
                    $url = '/admin/content/category/' . $filter . '/';
                    $active = $filter;
                }
            } else {
                $count = $this->getContent()->getCount();
                $data = $this->getContent()->get($limit, $page);
                $url = '/admin/content/';
                $active = 0;
            }
            if($count > 0) {
                $pageCount = intval(($count - 1) / $limit) + 1;
            } else {
                $pageCount = 0;
            }
            $searchResult = FALSE;
        }
        return array(
            'template' => 'content',
            'title' => 'Управление контентом',
            'data' => array(
                'data' => $data,
                'count' => $count,
                'limit' => $limit,
                'url' => $url,
                'search-string' => $searchString,
                'search-result' => $searchResult,
                'page-count' => $pageCount,
                'page' => $page,
            ),
            'side' => array(
                'title' => 'Навигация',
                'data' => array(
                    array(
                        'name' => 'Добавить',
                        'class' => 'content-add',
                        'url' => '#',
                    ),
                    array(
                        'name' => 'Неактивные',
                        'url' => '/admin/content/inactive',
                    )
                ),
                'without-count' => $this->getContent()->getCountWithoutCategory(),
                'inactive-count' => $this->getContent()->getInactiveCount(),
                'category' => $this->getCategory()->getAll(),
                'active' => $active,
                'count' => $this->getContent()->getCount()
            ),
        );
    }

    public function managementGallery($limit, $page, $filter = NULL) {
        if(isset($filter)) {
            if($filter == 'inactive') {
                $count = $this->getGallery()->getInactiveCount();
                $data = $this->getGallery()->getInactive($limit, $page);
                $url = '/admin/gallery/inactive/';
            }
        } else {
            $count = $this->getGallery()->getCount();
            $data = $this->getGallery()->get($limit, $page);
            $url = '/admin/gallery/';
        }
        if($count > 0) {
            $pageCount = intval(($count - 1) / $limit) + 1;
        } else {
            $pageCount = 0;
        }
        return array(
            'template' => 'gallery',
            'title' => 'Управление галереей',
            'data' => array(
                'data' => $data,
                'count' => $count,
                'limit' => $limit,
                'url' => $url,
                'page-count' => $pageCount,
                'page' => $page,
            ),
            'side' => array(
                'title' => 'Навигация',
                'data' => array(
                    array(
                        'name' => 'Добавить изображения',
                        'class' => 'gallery-add',
                        'url' => '#',
                    ),
                    array(
                        'name' => 'Все изображения',
                        'url' => '/admin/gallery',
                    ),
                    array(
                        'name' => 'Неактивные',
                        'url' => '/admin/gallery/inactive',
                    )
                )
            ),
        );
    }

    public function managementDelivery($limit, $page, $filter = NULL) {
        if(isset($filter)) {
            if($filter == 'inactive') {
                $count = $this->getEmailDelivery()->getInactiveCount();
                $data = $this->getEmailDelivery()->getInactive($limit, $page);
                $url = '/admin/delivery/inactive/';
            }
        } else {
            $count = $this->getEmailDelivery()->getCount();
            $data = $this->getEmailDelivery()->get($limit, $page);
            $url = '/admin/delivery/';
        }
        if($count > 0) {
            $pageCount = intval(($count - 1) / $limit) + 1;
        } else {
            $pageCount = 0;
        }
        return array(
            'template' => 'delivery',
            'title' => 'Управление email рассылками',
            'data' => array(
                'data' => $data,
                'count' => $count,
                'limit' => $limit,
                'url' => $url,
                'page-count' => $pageCount,
                'page' => $page,
            ),
            'side' => array(
                'title' => 'Навигация',
                'data' => array(
                    array(
                        'name' => 'Новая рассылка',
                        'class' => 'new-delivery',
                        'url' => '#',
                    ),
                    array(
                        'name' => 'Все подписчики',
                        'url' => '/admin/delivery',
                    ),
                    array(
                        'name' => 'Неактивные',
                        'url' => '/admin/delivery/inactive',
                    )
                )
            ),
        );
    }

    public function managementComments($limit, $page, $filter = NULL, $searchString = NULL) {
        if(isset($searchString) && mb_strlen($searchString) > 0 && mb_strlen($searchString) < 60) {
            $count = $this->getComments()->searchCount($searchString);
            if($count > 0) {
                $data = $this->getComments()->search($limit, $page, $searchString);
                $pageCount = intval(($count - 1) / $limit) + 1;
                $searchResult = TRUE;
                $url = '/admin/comments/search/?search=' . $searchString . '&page=';
            } else {
                $count = $this->getComments()->getCount();
                $data = $this->getComments()->get($limit, 1);
                $pageCount = intval(($count - 1) / $limit) + 1;
                $searchResult = FALSE;
                $url = '/admin/comments/';
            }
        } else {
            if(isset($filter)) {
                if($filter == 'inactive') {
                    $count = $this->getComments()->getInactiveCount();
                    $data = $this->getComments()->getInactive($limit, $page);
                    $url = '/admin/comments/inactive/';
                } elseif($filter == 'content') {
                    $count = $this->getComments()->getCountByContent($this->getRoute(4));
                    $data = $this->getComments()->getByContent($this->getRoute(4), $limit, $page);
                    $url = '/admin/comments/content/' . $this->getRoute(4) . '/';
                }
            } else {
                $count = $this->getComments()->getCount();
                $data = $this->getComments()->get($limit, $page);
                $url = '/admin/comments/';
            }
            if($count > 0) {
                $pageCount = intval(($count - 1) / $limit) + 1;
            } else {
                $pageCount = 0;
            }
            $searchResult = FALSE;
        }

        return array(
            'template' => 'comments',
            'title' => 'Комментарии',
            'data' => array(
                'data' => $data,
                'count' => $count,
                'limit' => $limit,
                'url' => $url,
                'search-string' => $searchString,
                'search-result' => $searchResult,
                'page-count' => $pageCount,
                'page' => $page,
            ),
            'side' => array(
                'title' => 'Навигация',
                'data' => array(
                    array(
                        'name' => 'Все комментарии',
                        'url' => '/admin/comments',
                    ),
                    array(
                        'name' => 'Неактивные',
                        'url' => '/admin/comments/inactive',
                    )
                )
            ),
        );
    }

    public function managementCategory() {
        return array(
            'template' => 'category',
            'title' => 'Категории',
            'data' => array('data' => $this->getCategory()->getAll()),
            'side' => array(
                'title' => 'Опции',
                'data' => array(
                    array(
                        'name' => 'Добавить',
                        'class' => 'category-add',
                        'url' => '#',
                    )
                ),
            )
        );
    }

    public function managementFeedback($archive = FALSE) {
        if($archive) {
            $title = 'Обратная связь (Архив)';
            $count = $this->getFeedback()->getAllArchiveCount();
            $data = $this->getFeedback()->getAllArchive();
        } else {
            $title = 'Обратная связь';
            $count = $this->getFeedback()->getAllNotArchiveCount();
            $data = $this->getFeedback()->getAllNotArchive();
        }
        return array(
            'template' => 'feedback',
            'title' => $title,
            'data' => array(
                'archive' => $archive,
                'count' => $count,
                'data' => $data
            ),
            'side' => array(
                'title' => 'Навигация',
                'data' => array(
                    array(
                        'name' => 'Сообщения',
                        'url' => '/admin/feedback',
                    ),
                    array(
                        'name' => 'Архив',
                        'url' => '/admin/feedback/archive',
                    )
                ),
            )
        );
    }

    public function managementSysPages() {
        return array(
            'template' => 'sys-pages',
            'title' => 'Системные страницы',
            'data' => array('data' => $this->getSysPages()->getAllPages()),
            'side' => array(
                'title' => 'Навигация',
                'data' => array(
                    array(
                        'name' => 'Управление страницами',
                        'url' => '/admin/pages',
                    )
                ),
            )
        );
    }

    public function managementPages() {
        return array(
            'template' => 'pages',
            'title' => 'Страницы',
            'data' => array('data' => $this->getPages()->getAllPage()),
            'side' => array(
                'title' => 'Опции',
                'data' => array(
                    array(
                        'name' => 'Добавить',
                        'class' => 'page-add',
                        'url' => '#',
                    )
                ),
            )
        );
    }

    public function managementEditor() {
        return array(
            'template' => 'editor',
            'title' => 'Редактирование шаблонов',
            'data' => array('data' => NULL),
            'side' => array(
                'title' => 'Файлы',
                'design-edit' => TRUE,
            )
        );
    }

    public function managementStatistics() {
        return array(
            'template' => 'statistics',
            'title' => 'Статистика посещений',
            'data' => $this->getStat(10),
            'side' => array(
                'title' => 'Навигация',
                'data' => array(
                    array(
                        'name' => 'Журнал запросов',
                        'class' => 'view-log',
                        'url' => '#',
                    )
                )
            ),
        );
    }

    public function getCategoryEditData($id) {
        return array(
            'category' => $this->getCategory()->getAll(),
            'data' => $this->getCategory()->getOne($id)
        );
    }

    public function getContentEditData($id) {
        return array(
            'category' => $this->getCategory()->getAll(),
            'data' => $this->getContent()->getOneRow($id),
        );
    }

    public function getChangeCategoryData() {
        return array('category' => $this->getCategory()->getAll(),);
    }

    public function getContentAddData() {
        return array('category' => $this->getCategory()->getAll(),);
    }

    public function getSysPageEditData($page) {
        if($page == 'home') {
            return array(
                'page' => 'home',
                'content' => $this->getSysPages()->getHomePage()
            );
        } elseif($page == 'not-found') {
            return array(
                'page' => 'not-found',
                'content' => $this->getSysPages()->getNotFoundPage()
            );
        } else {
            return NULL;
        }
    }

    public function getPageEditData($id) {
        return array('data' => $this->getPages()->getOnePageById($id));
    }

    public function getCommentEditData($id) {
        return array('data' => $this->getComments()->getOne($id));
    }

    public function getUserEditData($id) {
        return array('data' => $this->getDb()->getRow("SELECT * FROM users WHERE id = ?i", $id));
    }

    public function getCategoryAddData($parent) {
        return array('category' => $this->getCategory()->getAll(), 'parent' => $parent);
    }

}