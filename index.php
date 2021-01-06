<?php

define('APP', TRUE);

$start = microtime(true);

include $_SERVER['DOCUMENT_ROOT'] . '/modules/Site.php';

function __autoload($class) {
    require $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class . '.php';
}

$site = new Site();
$site->sessionStart();
$site->setCookie('visit', 'yes');

$route = $site->getRoute();

switch($route[1]) {
    case '':
        $out = $site->viewHome();
        break;
    case 'captcha':
        getCaptcha();
        break;
    case 'feedback':
        $out = $site->viewFeedback();
        break;
    case 'category':
        $page = is_numeric($route[3]) ? $route[3] : 1;
        $out = $site->viewContent($page, $route[2]);
        break;
    case 'best':
        $page = is_numeric($route[2]) ? $route[2] : 1;
        $out = $site->viewRating($page);
        break;
    case 'new':
        $page = is_numeric($route[2]) ? $route[2] : 1;
        $out = $site->viewTime($page);
        break;
    case 'random':
        $out = $site->viewRandom();
        break;
    case 'search':
        $page = is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $out = $site->viewContent($page, null, $_GET['search']);
        break;
    case 'add':
        $out = $site->viewAdd();
        break;
    case 'unsubscribe':
        header("refresh: 5; url=/");
        $site->unsubscribe($route[2]);
        break;
    case $site->getSettings()->settings['gallery-url']:
        if($site->getSettings()->settings['gallery-enable']) {
            $page = is_numeric($route[2]) ? $route[2] : 1;
            $out = $site->viewGallery($page);
        } else {
            $out = $site->viewNotFound();
        }
        break;
    case 'rss':
        if($site->getSettings()->settings['rss-enable']) {
            header("Content-Type: text/xml; charset=utf-8", true);;
            $content = $site->getContent()->getPublicSortedByTime(30, 1);
            $xml = new DomDocument('1.0', 'utf-8');
            $rss = $xml->appendChild($xml->createElement('rss'));
            $rss->setAttribute('version', '2.0');
            $channel = $rss->appendChild($xml->createElement('channel'));
            $channel->appendChild($xml->createElement("title", $site->getSettings()->settings['site-title']));
            $channel->appendChild($xml->createElement("link", 'http://' . $site->getHTTPHost()));
            $channel->appendChild($xml->createElement("description", $site->getSettings()->settings['site-description']));

            foreach($content as $t) {
                for($i = intval(($t['count'] - 1) / $site->getSettings()->settings['records-page']) + 1; $i > 0; $i--) {
                    $item = $channel->appendChild($xml->createElement('item'));
                    $item->appendChild($xml->createElement('title', $t['cname']));
                    $item->appendChild($xml->createElement('link', 'http://' . $site->getHTTPHost() . '/new'));
                    $item->appendChild($xml->createElement('description', $t['content']));
                }
            }
            $xml->formatOutput = true;
            echo $xml->saveXML();
        } else {
            $out = $site->viewNotFound();
        }
        break;
    case 'sitemap.xml':
        if($site->getSettings()->settings['sitemap-enable']) {
            header("Content-Type: text/xml; charset=utf-8", true);;
            $category = $site->getCategory()->getAllPublicNotTree();
            $xml = new DomDocument('1.0', 'utf-8');
            $urlset = $xml->appendChild($xml->createElement('urlset'));
            $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
            foreach($category as $t) {
                for($i = intval(($t['count'] - 1) / $site->getSettings()->settings['records-page']) + 1; $i > 0; $i--) {
                    $url = $urlset->appendChild($xml->createElement('url'));
                    $url->appendChild($xml->createElement('loc', 'http://' . $site->getHTTPHost() . '/category/' . $t['url'] . '/' . $i));
                    $url->appendChild($xml->createElement('changefreq', 'daily'));
                    $url->appendChild($xml->createElement('priority', 0.5));
                }
            }
            $xml->formatOutput = true;
            echo $xml->saveXML();
        } else {
            $out = $site->viewNotFound();
        }
        break;
    case 'api':
        if($site->getSettings()->settings['api-enable']) {
            switch($route[2]) {
                case 'random':
                    header("Content-type: text/xml");
                    $temp = $site->getDb()->getRow("SELECT * FROM content ORDER BY RAND() LIMIT 1");
                    $xml = new DomDocument('1.0', 'utf-8');
                    $root = $xml->appendChild($xml->createElement('root'));
                    $data = $root->appendChild($xml->createElement('data'));
                    $data->appendChild($xml->createElement('id', $temp['id']));
                    $data->appendChild($xml->createElement('content', $temp['content']));
                    $data->appendChild($xml->createElement('rating', $temp['rating']));
                    $xml->formatOutput = true;
                    echo $xml->saveXML();
                    break;
                case 'content':
                    header("Content-type: text/xml");
                    $routes[3] = is_numeric($route[3]) ? $route[3] : 1;
                    $routes[4] = is_numeric($routes[4]) ? $routes[4] : 1;
                    $temp = $site->getDb()->getAll("SELECT (SELECT name FROM category WHERE id = content.category) as categoryname, content.* FROM content WHERE category = ?i ORDER BY id LIMIT ?i, 10", $routes[3], $routes[4] * 5 - 5);
                    $xml = new DomDocument('1.0', 'utf-8');
                    $root = $xml->appendChild($xml->createElement('root'));
                    foreach($temp as $t) {
                        $data = $root->appendChild($xml->createElement('data'));
                        $data->appendChild($xml->createElement('id', $t['id']));
                        $data->appendChild($xml->createElement('rating', $t['rating']));
                        $data->appendChild($xml->createElement('content', $t['content']));
                        $data->appendChild($xml->createElement('category', $t['category']));
                    }
                    $xml->formatOutput = true;
                    echo $xml->saveXML();
                    break;
                case 'category':
                    header("Content-type: text/xml");
                    $temp = $site->getDb()->getAll("SELECT (SELECT COUNT(*) FROM content WHERE category = category.id) as count, category.* FROM category ORDER BY id");
                    $xml = new DomDocument('1.0', 'utf-8');
                    $root = $xml->appendChild($xml->createElement('root'));
                    foreach($temp as $t) {
                        $data = $root->appendChild($xml->createElement('data'));
                        $data->appendChild($xml->createElement('id', $t['id']));
                        $data->appendChild($xml->createElement('count', $t['count']));
                        $data->appendChild($xml->createElement('parent', $t['parent']));
                        $data->appendChild($xml->createElement('name', $t['name']));
                    }
                    $xml->formatOutput = true;
                    echo $xml->saveXML();
                    break;
                default :
                    $out = $site->viewNotFound();
            }
        } else {
            $out = $site->viewNotFound();
        }
        break;
    case 'robots.txt':
        if($site->getSettings()->settings['robots-enable']) {
            header("Content-Type:text/plain");
            echo $site->getSettings()->settings['robots-content'];
        } else {
            $out = $site->viewNotFound();
        }
        break;
    case 'ajax':
        if($_SERVER['REQUEST_METHOD'] == 'POST' && is_string($_POST['action'])) {
            switch($_POST['action']) {
                case 'add-comment':
                    if(md5($_POST['captcha']) != $_SESSION['captcha']) {
                        echo 'wrong captcha';
                    } else {
                        if(isset($_POST['content'], $_POST['parent'], $_POST['name'], $_POST['email'], $_POST['message'])) {
                            if($site->getComments()->add($_POST['content'], $_POST['parent'], $_SERVER['REMOTE_ADDR'], $_POST['name'], $_POST['email'], $_POST['message'], 0)) {
                                echo 'ok';
                            }
                        }
                    }
                    break;
                case 'add-content':
                    if(md5($_POST['captcha']) != $_SESSION['captcha']) {
                        echo 'wrong captcha';
                    } else {
                        if(isset($_POST['category'], $_POST['content'])) {
                            if($site->addContent($_POST['category'], $_POST['content'])) {
                                echo 'ok';
                            }
                        }
                    }
                    break;
                case 'add-delivery-email':
                    if(is_string($_POST['semail'])) {
                        if($site->getEmailDelivery()->checkEmail($_POST['semail'])) {
                            echo 'already signed';
                        } else {
                            if($site->getEmailDelivery()->add($_POST['semail'])) {
                                echo 'ok';
                            }
                        }
                    }
                    break;
                case 'send-feedback':
                    if(md5($_POST['captcha']) != $_SESSION['captcha']) {
                        echo 'wrong captcha';
                    } else {
                        if(isset($_POST['name'], $_POST['email'], $_POST['message'])) {
                            if($site->addFeedback($_POST['name'], $_POST['email'], $_POST['message'])) {
                                echo 'ok';
                            }
                        }
                    }
                    break;
                case 'update-rating':
                    if(is_numeric($_POST['id'])) {
                        $site->getContent()->updateRating($_POST['id']);
                        setcookie(md5('rating-' . $_POST['id']), 1);
                        echo $site->getContent()->getRating($_POST['id']);
                    }
                    break;
                case 'get-single':
                    if(is_numeric($_POST['id'])) {
                        $template = new Template($_SERVER['DOCUMENT_ROOT'] . '/public/', '.tpl');
                        $temp = $site->viewSingle($_POST['id']);
                        $site->getContent()->updateViewCount($_POST['id']);
                        echo $template->compileBloc('single', $temp['data']);
                    }
                    break;
            }
        }
        break;
    default:
        $out = $site->viewPage($route[1]);
}

if(is_array($out)) {
    $template = new Template($_SERVER['DOCUMENT_ROOT'] . '/public/', '.tpl');
    $template->main('main');
    $template->set('{title}', $out['title']);
    $template->set('{runtime}', $time = microtime(true) - $start);
    $template->set('{http-host}', $site->getHTTPHost());
    $template->set('{description}', $out['description']);
    $template->set('{site-title}', $site->getSettings()->settings['site-title']);
    $template->set('{site-description}', $site->getSettings()->settings['site-description']);
    $template->bloc('{header}', 'header', $out['header']);
    $template->bloc('{gallery-link}', 'glink', $site->getSettings()->settings);
    $template->bloc('{pages-links}', 'plinks', $site->getPagesLinks());
    $template->bloc('{sidebar}', 'sidebar', $out['side']);
    $template->bloc('{content}', $out['template'], $out['data']);
    $template->out();
}

$site->updateStat();