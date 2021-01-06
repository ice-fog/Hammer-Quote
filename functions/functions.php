<?php

function getAllSubId($array, $id) {
    if(!isset($id))
        return null;
    $result = '';
    foreach($array as $t) {
        if($t['parent'] == $id) {
            $result .= $t['id'] . '|';
            $result .= getAllSubId($array, $t['id']);
        }
    }
    $result .= $id . '|';
    return $result;
}

function getRecordsCount($array, $id, $count) {
    if(!$id)
        return null;
    $result = $count;
    foreach($array as $t) {
        if($t['parent'] == $id) {
            $result += $t['count'];
            $result += getRecordsCount($array, $t['id'], 0);
        }
    }
    return $result;
}

function createTreeArray(&$list, $parent) {
    $tree = array();
    foreach($parent as $k => $l) {
        if(isset($list[$l['id']])) {
            $l['children'] = createTreeArray($list, $list[$l['id']]);
        }
        $tree[] = $l;
    }
    return $tree;
}

function arrayRenameKey(&$array, $old, $new) {
    if(!is_array($array)) {
        ($array == "") ? $array = array() : false;
        return $array;
    }
    foreach($array as &$arr) {
        if(is_array($old)) {
            foreach($new as $k => $new) {
                (isset($old[$k])) ? true : $old[$k] = NULL;
                $arr[$new] = (isset($arr[$old[$k]]) ? $arr[$old[$k]] : null);
                unset($arr[$old[$k]]);
            }
        } else {
            $arr[$new] = (isset($arr[$old]) ? $arr[$old] : null);
            unset($arr[$old]);
        }
    }
    return $array;
}

function getCaptcha() {
    $rand = rand(10000, 99999);
    $_SESSION['captcha'] = md5($rand);
    $picture = imagecreatetruecolor(60, 30);

    imagecolortransparent($picture, 000);
    imagefilledrectangle($picture, 4, 4, 50, 25, 000);
    imagestring($picture, 5, 5, 7, substr($rand, 0, 1), imagecolorallocate($picture, rand(100, 200), rand(100, 200), rand(100, 200)));
    imagestring($picture, 5, 15, 7, substr($rand, 1, 1), imagecolorallocate($picture, rand(100, 200), rand(100, 200), rand(100, 200)));
    imagestring($picture, 5, 25, 7, substr($rand, 2, 1), imagecolorallocate($picture, rand(100, 200), rand(100, 200), rand(100, 200)));
    imagestring($picture, 5, 35, 7, substr($rand, 3, 1), imagecolorallocate($picture, rand(100, 200), rand(100, 200), rand(100, 200)));
    imagestring($picture, 5, 45, 7, substr($rand, 4, 1), imagecolorallocate($picture, rand(100, 200), rand(100, 200), rand(100, 200)));

    header("Content-type: image/png");
    imagepng($picture);
    imagedestroy($picture);
}