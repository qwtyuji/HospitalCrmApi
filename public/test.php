<?php
/**
 * Created by PhpStorm.
 * User: hupo
 * Date: 2017/7/5
 * Time: 下午5:42
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: content-type,authorization");
$arr = ['1', '2'];
echo json_encode($arr);