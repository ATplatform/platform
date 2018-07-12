<?php
/**
 * 二维数组按照指定键值去重
 * @param $arr 需要去重的二维数组
 * @param $key 需要去重所根据的索引
 * @return mixed
 */
function arr_uniq($arr,$key)
{
    $key_arr = [];
    foreach ($arr as $k => $v) {
        if (in_array($v[$key],$key_arr)) {
            unset($arr[$k]);
        } else {
            $key_arr[] = $v[$key];
        }
    }
    sort($arr);
    return $arr;
}


?>