<?php

define('APP', true);

include $_SERVER['DOCUMENT_ROOT'] . '/modules/Admin.php';

function __autoload($class) {
    require $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class . '.php';
}

$admin = new Admin();
$routes = $admin->getRoute();
$user = $admin->getUser();
$limit = 30;

if(!$user) {
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'], $_POST['password'])) {
        if($admin->login($_POST['login'], $_POST['password'])) {
            header("Location: /admin");
            exit();
        } else {
            header("Location: /admin?fail=yes");
            exit();
        }
    } else {
        $out = new Template($_SERVER['DOCUMENT_ROOT'] . '/admin/public/templates/', '.tpl');
        echo $out->compileBloc('login', null);
    }
    return;
}

switch($routes[2]) {
    case '':
        $out = $admin->managementContent($limit, 1);
        break;
    case 'content':
        if($routes[3] == 'ajax' && $_SERVER['REQUEST_METHOD'] == 'POST' && is_string($_POST['action'])) {
            switch($_POST['action']) {
                case 'checkbox-handler':
                    if(isset($_POST['id'], $_POST['select-action'])) {
                        switch($_POST['select-action']) {
                            case 'change-category':
                                if(isset($_POST['category'])) {
                                    if($admin->getContent()->multipleChangeCategory($_POST['category'], $_POST['id'])) {
                                        echo 'ok';
                                    }
                                }
                                break;
                            case 'enable':
                                if($admin->getContent()->multipleUpdateStatus($_POST['id'], 1)) {
                                    echo 'ok';
                                }
                                break;
                            case 'disable':
                                if($admin->getContent()->multipleUpdateStatus($_POST['id'], 0)) {
                                    echo 'ok';
                                }
                                break;
                            case 'delete':
                                if($admin->getContent()->multipleDelete($_POST['id'])) {
                                    $admin->getComments()->deleteByContent($_POST['id']);
                                    echo 'ok';
                                }
                                break;
                        }
                    }
                    break;
                case 'update-status':
                    if(is_numeric($_POST['id']) && is_numeric($_POST['status'])) {
                        if($admin->getContent()->updateStatus($_POST['id'], $_POST['status'])) {
                            echo 'ok';
                        }
                    }
                    break;
                case 'get-form-edit':
                    if(is_numeric($_POST['id'])) {
                        $out = new Template($_SERVER['DOCUMENT_ROOT'] . '/admin/public/templates/', '.tpl');
                        echo $out->compileBloc('forms/edit/content', $admin->getContentEditData($_POST['id']));
                    }
                    break;
                case 'get-form-add':
                    $out = new Template($_SERVER['DOCUMENT_ROOT'] . '/admin/public/templates/', '.tpl');
                    echo $out->compileBloc('forms/add/content', $admin->getContentAddData());
                    break;
                case 'get-form-category-change':
                    $out = new Template($_SERVER['DOCUMENT_ROOT'] . '/admin/public/templates/', '.tpl');
                    echo $out->compileBloc('forms/change/category', $admin->getChangeCategoryData());
                    break;
                case 'add':
                    if(isset($_POST['category'], $_POST['status'], $_POST['content']) && mb_strlen($_POST['content']) > 0) {
                        if($admin->getContent()->add($_POST['category'], $_POST['content'], $_POST['status'])) {
                            echo 'ok';
                        }
                    }
                    break;
                case 'edit':
                    if(isset($_POST['id'], $_POST['category'], $_POST['status'], $_POST['content'])) {
                        if($admin->getContent()->edit($_POST['id'], $_POST['category'], $_POST['content'], $_POST['status'])) {
                            echo 'ok';
                        }
                    }
                    break;
                case 'delete':
                    if(is_numeric($_POST['id'])) {
                        if($admin->getContent()->delete($_POST['id'])) {
                            $admin->getComments()->deleteByContent($_POST['id']);
                            echo 'ok';
                        }
                    }
                    break;
            }
        } else {
            if($routes[3] == 'search' && isset($_GET['search'])) {
                $page = is_numeric($_GET['page']) ? $_GET['page'] : 1;
                $out = $admin->managementContent($limit, $page, null, $_GET['search']);
            } elseif($routes[3] == 'category' && $routes[4] == 'without') {
                $page = is_numeric($routes[5]) ? $routes[5] : 1;
                $out = $admin->managementContent($limit, $page, 'without-category');
            } elseif($routes[3] == 'inactive') {
                $page = is_numeric($routes[4]) ? $routes[4] : 1;
                $out = $admin->managementContent($limit, $page, 'inactive');
            } elseif($routes[3] == 'category' && is_numeric($routes[4])) {
                $page = is_numeric($routes[5]) ? $routes[5] : 1;
                $out = $admin->managementContent($limit, $page, $routes[4]);
            } elseif($routes[3] == 'one' && is_numeric($routes[4])) {
                $out = $admin->managementContent($limit, $page, 'one');
            } else {
                $page = is_numeric($routes[3]) ? $routes[3] : 1;
                $out = $admin->managementContent($limit, $page);
            }
        }
        break;
    case 'gallery':
        if($routes[3] == 'ajax' && $_SERVER['REQUEST_METHOD'] == 'POST' && is_string($_POST['action'])) {
            switch($_POST['action']) {
                case 'checkbox-handler':
                    if(isset($_POST['images'], $_POST['select-action'])) {
                        switch($_POST['select-action']) {
                            case 'enable':
                                if($admin->getGallery()->multipleUpdateStatus($_POST['id'], 1)) {
                                    echo 'ok';
                                }
                                break;
                            case 'disable':
                                if($admin->getGallery()->multipleUpdateStatus($_POST['id'], 0)) {
                                    echo 'ok';
                                }
                                break;
                            case 'delete':
                                if($admin->getGallery()->multipleDelete($_POST['id'])) {
                                    $admin->getImages()->multipleDelete($_POST['images']);
                                    echo 'ok';
                                }
                                break;
                        }
                    }
                    break;
                case 'update-status':
                    if(is_numeric($_POST['id']) && is_numeric($_POST['status'])) {
                        if($admin->getGallery()->updateStatus($_POST['id'], $_POST['status'])) {
                            echo 'ok';
                        }
                    }
                    break;
                case 'add':
                    echo $admin->getGallery()->add();
                    break;
                case 'get-form-add':
                    $out = new Template($_SERVER['DOCUMENT_ROOT'] . '/admin/public/templates/', '.tpl');
                    echo $out->compileBloc('forms/add/gallery', null);
                    break;
                case 'delete':
                    if(is_string($_POST['image'])) {
                        if($admin->getGallery()->delete($_POST['id'])) {
                            $admin->getImages()->delete($_POST['image']);
                            echo 'ok';
                        }
                    }
                    break;
            }
        } else {
            if($routes[3] == 'inactive') {
                $page = is_numeric($routes[4]) ? $routes[4] : 1;
                $out = $admin->managementGallery($limit, $page, 'inactive');
            } else {
                $page = is_numeric($routes[3]) ? $routes[3] : 1;
                $out = $admin->managementGallery($limit, $page, null);
            }
        }
        break;
    case 'image':
        if($routes[3] == 'ajax' && $_SERVER['REQUEST_METHOD'] == 'POST') {
            echo $admin->getImages()->addByContent();
        }
        break;
    case 'category':
        if($routes[3] == 'ajax' && $_SERVER['REQUEST_METHOD'] == 'POST' && is_string($_POST['action'])) {
            switch($_POST['action']) {
                case 'delete':
                    if(is_numeric($_POST['id'])) {
                        if($admin->getCategory()->delete($_POST['id'])) {
                            $admin->getContent()->deleteCategory($_POST['id']);
                            echo 'ok';
                        }
                    }
                    break;
                case 'checkbox-handler':
                    if(isset($_POST['id'], $_POST['select-action'])) {
                        switch($_POST['select-action']) {
                            case 'enable':
                                if($admin->getCategory()->multipleUpdateStatus($_POST['id'], 1)) {
                                    echo 'ok';
                                }
                                break;
                            case 'disable':
                                if($admin->getCategory()->multipleUpdateStatus($_POST['id'], 0)) {
                                    echo 'ok';
                                }
                                break;
                            case 'delete':
                                if($admin->getCategory()->multipleDelete($_POST['id'])) {
                                    $admin->getContent()->multipleDeleteCategory($_POST['id']);
                                    echo 'ok';
                                }
                                break;
                        }
                    }
                    break;
                case 'update-parent':
                    if(is_numeric($_POST['id']) && is_numeric($_POST['parent'])) {
                        if($admin->getCategory()->updateParent($_POST['parent'], array($_POST['id']))) {
                            if($admin->getCategory()->getStatus($_POST['parent']) == 0) {
                                $admin->getCategory()->multipleUpdateStatus($admin->getCategory()->getAllSubId($_POST['id']), 0);
                            }
                            echo 'ok';
                        }
                    }
                    break;
                case 'update-status':
                    if(is_numeric($_POST['id']) && is_numeric($_POST['status'])) {
                        if($admin->getCategory()->updateStatus($_POST['id'], $_POST['status'])) {
                            echo 'ok';
                        } else {
                            echo 'parent-disable';
                        }
                    }
                    break;
                case 'get-form-edit':
                    if(is_numeric($_POST['id'])) {
                        $out = new Template($_SERVER['DOCUMENT_ROOT'] . '/admin/public/templates/', '.tpl');
                        echo $out->compileBloc('forms/edit/category', $admin->getCategoryEditData($_POST['id']));
                    }
                    break;
                case 'get-form-add':
                    $out = new Template($_SERVER['DOCUMENT_ROOT'] . '/admin/public/templates/', '.tpl');
                    echo $out->compileBloc('forms/add/category', $admin->getCategoryAddData($_POST['parent']));
                    break;
                case 'add':
                    if(isset($_POST['url'], $_POST['name'], $_POST['status'], $_POST['parent'], $_POST['description']) && mb_strlen($_POST['name']) > 0 && mb_strlen($_POST['url']) > 0) {
                        if($admin->getCategory()->add($_POST['parent'], $_POST['name'], $_POST['url'], $_POST['status'], $_POST['description'])) {
                            echo 'ok';
                        }
                    }
                    break;
                case 'check-free-url':
                    $id = $admin->getCategory()->checkFreeURL($_POST['url']);
                    echo !$id ? "ok" : $id;
                    break;
                case 'edit':
                    if(isset($_POST['id'], $_POST['url'], $_POST['name'], $_POST['status'], $_POST['parent'], $_POST['description'], $_POST['old-parent'])) {
                        if($admin->getCategory()->edit($_POST['id'], $_POST['parent'], $_POST['name'], $_POST['url'], $_POST['status'], $_POST['description'], $_POST['old-parent'])) {
                            echo 'ok';
                        }
                    }
                    break;
            }
        } else {
            if($routes[3] == 'get-json') {
                echo $admin->getCategory()->getAllJSON();
            } else {
                $out = $admin->managementCategory();
            }
        }
        break;
    case 'pages':
        if($routes[3] == 'ajax' && $_SERVER['REQUEST_METHOD'] == 'POST' && is_string($_POST['action'])) {
            switch($_POST['action']) {
                case 'checkbox-handler':
                    if(isset($_POST['id'], $_POST['select-action'])) {
                        switch($_POST['select-action']) {
                            case 'enable':
                                if($admin->getPages()->multipleUpdateStatus($_POST['id'], 1)) {
                                    echo 'ok';
                                }
                                break;
                            case 'disable':
                                if($admin->getPages()->multipleUpdateStatus($_POST['id'], 0)) {
                                    echo 'ok';
                                }
                                break;
                            case 'delete':
                                if($admin->getPages()->multipleDeletePage($_POST['id'])) {
                                    echo 'ok';
                                }
                                break;
                        }
                    }
                    break;
                case 'get-form-add':
                    $out = new Template($_SERVER['DOCUMENT_ROOT'] . '/admin/public/templates/', '.tpl');
                    echo $out->compileBloc('forms/add/page', null);
                    break;
                case 'get-form-edit':
                    if(is_numeric($_POST['id'])) {
                        $out = new Template($_SERVER['DOCUMENT_ROOT'] . '/admin/public/templates/', '.tpl');
                        echo $out->compileBloc('forms/edit/page', $admin->getPageEditData($_POST['id']));
                    }
                    break;
                case 'get-form-sys-edit':
                    if(is_string($_POST['page'])) {
                        $out = new Template($_SERVER['DOCUMENT_ROOT'] . '/admin/public/templates/', '.tpl');
                        echo $out->compileBloc('forms/edit/sys-page', $admin->getSysPageEditData($_POST['page']));
                    }
                    break;
                case 'update-status':
                    if(is_numeric($_POST['id']) && is_numeric($_POST['status'])) {
                        if($admin->getPages()->updateStatus($_POST['id'], $_POST['status'])) {
                            echo 'ok';
                        }
                    }
                    break;
                case 'sys-edit':
                    if(isset($_POST['page'], $_POST['content'])) {
                        if($admin->getSysPages()->updatePage($_POST['page'], htmlspecialchars($_POST['content']))) {
                            echo 'ok';
                        }
                    }
                    break;
                case 'check-free-url':
                    $id = $admin->getPages()->checkFreeURL($_POST['url']);
                    echo !$id ? "ok" : $id;
                    break;
                case 'edit':
                    if(isset($_POST['id'], $_POST['url'], $_POST['title'], $_POST['status'], $_POST['content'], $_POST['description'])) {
                        if($admin->getPages()->editPage($_POST['id'], $_POST['url'], $_POST['status'], $_POST['title'], $_POST['description'], $_POST['content'])) {
                            echo 'ok';
                        }
                    }
                    break;
                case 'add':
                    if(isset($_POST['url'], $_POST['title'], $_POST['status'], $_POST['content'], $_POST['description'])) {
                        if($admin->getPages()->addPage($_POST['url'], $_POST['status'], $_POST['title'], $_POST['description'], $_POST['content'])) {
                            echo 'ok';
                        }
                    }
                    break;
                case 'delete':
                    if(is_numeric($_POST['id'])) {
                        if($admin->getPages()->deletePage($_POST['id'])) {
                            echo 'ok';
                        }
                    }
                    break;
            }
        } else {
            if($routes[3] == 'system') {
                $out = $admin->managementSysPages();
            } else {
                $out = $admin->managementPages();
            }

        }
        break;
    case 'feedback':
        if($routes[3] == 'ajax' && $_SERVER['REQUEST_METHOD'] == 'POST' && is_string($_POST['action'])) {
            switch($_POST['action']) {
                case 'checkbox-handler':
                    if(isset($_POST['id'], $_POST['select-action'])) {
                        switch($_POST['select-action']) {
                            case 'archive':
                                if($admin->getFeedback()->multipleArchive($_POST['id'])) {
                                    echo 'ok';
                                }
                                break;
                            case 'delete':
                                if($admin->getFeedback()->multipleDelete($_POST['id'])) {
                                    echo 'ok';
                                }
                                break;
                        }
                    }
                    break;
                case 'delete':
                    if(is_numeric($_POST['id'])) {
                        if($admin->getFeedback()->delete($_POST['id'])) {
                            echo 'ok';
                        }
                    }
                    break;
                case 'archive':
                    if(is_numeric($_POST['id'])) {
                        if($admin->getFeedback()->archive($_POST['id'])) {
                            echo 'ok';
                        }
                    }
                    break;
            }
        } elseif($routes['3'] == 'archive') {
            $out = $admin->managementFeedback(true);
        } else {
            $out = $admin->managementFeedback();
        }
        break;
    case 'delivery':
        if($routes[3] == 'ajax' && $_SERVER['REQUEST_METHOD'] == 'POST' && is_string($_POST['action'])) {
            switch($_POST['action']) {
                case 'checkbox-handler':
                    if(isset($_POST['id'], $_POST['select-action'])) {
                        switch($_POST['select-action']) {
                            case 'enable':
                                if($admin->getEmailDelivery()->multipleUpdateStatus($_POST['id'], 1)) {
                                    echo 'ok';
                                }
                                break;
                            case 'disable':
                                if($admin->getEmailDelivery()->multipleUpdateStatus($_POST['id'], 0)) {
                                    echo 'ok';
                                }
                                break;
                            case 'delete':
                                if($admin->getEmailDelivery()->multipleDelete($_POST['id'])) {
                                    echo 'ok';
                                }
                                break;
                        }
                    }
                    break;
                case 'update-status':
                    if(is_numeric($_POST['id']) && is_numeric($_POST['status'])) {
                        if($admin->getEmailDelivery()->updateStatus($_POST['id'], $_POST['status'])) {
                            echo 'ok';
                        }
                    }
                    break;
                case 'get-form-new':
                    $out = new Template($_SERVER['DOCUMENT_ROOT'] . '/admin/public/templates/', '.tpl');
                    echo $out->compileBloc('forms/add/delivery', $admin->getContentAddData());
                    break;
                case 'new':
                    if(isset($_POST['name'], $_POST['content'])) {
                        if($admin->getEmailDelivery()->newDelivery($_POST['name'], $_POST['content'])) {
                            echo 'ok';
                        }
                    }
                    break;
                case 'delete':
                    if(is_numeric($_POST['id'])) {
                        if($admin->getEmailDelivery()->delete($_POST['id'])) {
                            echo 'ok';
                        }
                    }
                    break;
            }
        } else {
            if($routes[3] == 'inactive') {
                $page = is_numeric($routes[4]) ? $routes[4] : 1;
                $out = $admin->managementDelivery($limit, $page, 'inactive');
            } else {
                $page = is_numeric($routes[3]) ? $routes[3] : 1;
                $out = $admin->managementDelivery($limit, $page);
            }
        }
        break;
    case 'comments':
        if($routes[3] == 'ajax' && $_SERVER['REQUEST_METHOD'] == 'POST' && is_string($_POST['action'])) {
            switch($_POST['action']) {
                case 'checkbox-handler':
                    if(isset($_POST['id'], $_POST['select-action'])) {
                        switch($_POST['select-action']) {
                            case 'enable':
                                if($admin->getComments()->multipleUpdateStatus($_POST['id'], 1)) {
                                    echo 'ok';
                                }
                                break;
                            case 'disable':
                                if($admin->getComments()->multipleUpdateStatus($_POST['id'], 0)) {
                                    echo 'ok';
                                }
                                break;
                            case 'delete':
                                if($admin->getComments()->multipleDelete($_POST['id'])) {
                                    echo 'ok';
                                }
                                break;
                        }
                    }
                    break;
                case 'get-form-edit':
                    if(is_numeric($_POST['id'])) {
                        $out = new Template($_SERVER['DOCUMENT_ROOT'] . '/admin/public/templates/', '.tpl');
                        echo $out->compileBloc('forms/edit/comment', $admin->getCommentEditData($_POST['id']));
                    }
                    break;
                case 'update-status':
                    if(is_numeric($_POST['id']) && is_numeric($_POST['status'])) {
                        if($admin->getComments()->updateStatus($_POST['id'], $_POST['status'])) {
                            echo 'ok';
                        }
                    }
                    break;
                case 'edit':
                    if(isset($_POST['id'], $_POST['name'], $_POST['email'], $_POST['message'], $_POST['status'])) {
                        if($admin->getComments()->edit($_POST['id'], $_POST['name'], $_POST['email'], $_POST['message'], $_POST['status'])) {
                            echo 'ok';
                        }
                    }
                    break;
                case 'delete':
                    if(is_numeric($_POST['id'])) {
                        if($admin->getComments()->delete($_POST['id'])) {
                            echo 'ok';
                        }
                    }
                    break;

            }
        } elseif($routes[3] == 'search' && isset($_GET['search'])) {
            $page = is_numeric($_GET['page']) ? $_GET['page'] : 1;
            $out = $admin->managementComments($limit, $page, null, $_GET['search']);
        } elseif($routes[3] == 'inactive') {
            $page = is_numeric($routes[5]) ? $routes[5] : 1;
            $out = $admin->managementComments($limit, $page, 'inactive');
        } elseif($routes[3] == 'content' && is_numeric($routes[4])) {
            $page = is_numeric($routes[5]) ? $routes[5] : 1;
            $out = $admin->managementComments($limit, $page, 'content');
        } else {
            $page = is_numeric($routes[3]) ? $routes[3] : 1;
            $out = $admin->managementComments($limit, $page);
        }
        break;
    case 'statistics':
        if($routes[3] == 'ajax' && $_SERVER['REQUEST_METHOD'] == 'POST' && is_string($_POST['action'])) {
            switch($_POST['action']) {
                case 'get-stat':
                    echo json_encode(array_reverse($admin->getStat(10)));
                    break;
                case 'get-log':
                    echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/data/log');
                    break;
            }
        } else {
            $out = $admin->managementStatistics();
        }
        break;
    case 'editor':
        if($routes[3] == 'get') {
            if(isset($_POST['dir'])) {
                echo $admin->getFileEditor()->getFileList($_POST['dir']);
            }
        } elseif($routes[3] == 'load') {
            echo $admin->getFileEditor()->getFileContent($_POST['file']);
        } elseif($routes[3] == 'save') {
            if(isset($_POST['file'], $_POST['content'])) {
                if($admin->getFileEditor()->saveFile($_POST['file'], $_POST['content'])) {
                    echo 'ok';
                }
            }
        } else {
            $out = $admin->managementEditor();
        }
        break;

    case 'settings':
        if($routes[3] == 'ajax' && $_SERVER['REQUEST_METHOD'] == 'POST' && is_string($_POST['action'])) {
            switch($_POST['action']) {
                case 'update':
                    if(isset($_POST['email'], $_POST['site-title'], $_POST['home-content'], $_POST['records-page'], $_POST['site-description'])) {
                        $settings = array();
                        $settings['email'] = $_POST['email'];
                        $settings['site-title'] = $_POST['site-title'];
                        $settings['rss-enable'] = intval($_POST['rss-enable']);
                        $settings['sitemap-enable'] = intval($_POST['sitemap-enable']);
                        $settings['api-enable'] = intval($_POST['api-enable']);
                        $settings['gallery-enable'] = intval($_POST['gallery-enable']);
                        $settings['comments-enable'] = intval($_POST['comments-enable']);
                        $settings['notifications-enable'] = $_POST['notifications-enable'];
                        $settings['home-content'] = $_POST['home-content'];
                        $settings['records-page'] = intval($_POST['records-page']);
                        $settings['site-description'] = $_POST['site-description'];
                        $settings['gallery-title'] = $_POST['gallery-title'];
                        $settings['gallery-url'] = $_POST['gallery-url'];
                        $settings['gallery-description'] = $_POST['gallery-description'];
                        $settings['robots-enable'] = intval($_POST['robots-enable']);
                        $settings['robots-content'] = $_POST['robots-content'];
                        if($admin->getSettings()->updateSettings($settings)) {
                            echo 'ok';
                        }
                    }
                    break;
            }
        } else {
            $out = $admin->managementMainSettings();
        }

        break;
    case 'users':
        if($routes[3] == 'ajax' && $_SERVER['REQUEST_METHOD'] == 'POST' && is_string($_POST['action'])) {
            switch($_POST['action']) {
                case 'get-form-edit':
                    if(isset($_POST['id'])) {
                        $out = new Template($_SERVER['DOCUMENT_ROOT'] . '/admin/public/templates/', '.tpl');
                        echo $out->compileBloc('forms/edit/user', $admin->getUserEditData($_POST['id']));
                    }
                    break;
                case 'edit':
                    if(isset($_POST['id'], $_POST['login'], $_POST['old-password'])) {
                        if($user['password'] !== md5(md5($_POST['old-password']))) {
                            echo 'wrong-password';
                        } else {
                            if(strlen($_POST['new-password']) > 0) {
                                $admin->getDb()->query("UPDATE users SET login = ?s, password = ?s WHERE id = ?i", $_POST['login'], md5(md5($_POST['new-password'])), 1);
                                echo 'ok';
                            } else {
                                $admin->getDb()->query("UPDATE users SET login = ?s WHERE id = ?i", $_POST['login'], 1);
                                echo 'ok';
                            }
                        }
                    }
                    break;
            }
        }
        break;
    case 'logout':
        $admin->logout();
        header("Location: /");
        exit();
        break;
    default:
        header("Location: /admin");
        exit();
}

if(is_array($out)) {
    $template = new Template($_SERVER['DOCUMENT_ROOT'] . '/admin/public/templates/', '.tpl');
    $template->main('main');
    $template->set('{title}', $out['title']);
    $template->bloc('{sidebar}', 'sidebar', $out['side']);
    $template->bloc('{content}', $out['template'], $out['data']);
    $template->out();
}