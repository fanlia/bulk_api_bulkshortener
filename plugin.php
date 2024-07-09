<?php
/*
Plugin Name: Bulk URL shortener
Plugin URI: https://github.com/tdakanalis/bulk_api_bulkshortener
Description: Shorten URLs in bulk (a single request with many URLs to shorten).
Version: 1.0
Author: Stelios Mavromichalis
Author URI: http://www.cytech.gr
*/

yourls_add_action('api', 'bulk_api_bulkshortener');

function bulk_api_bulkshortener($action) {
    if ($action[0] != 'bulkshortener') {
        return;
    }

    $urls = $_REQUEST['urls'];
    /*echo json_encode($urls);*/
    /*die();*/

    if (!is_array($urls)) {
        $return = array(
            'errorCode' => 400,
            'message' => 'bulkshortener: missing URLS parameter',
            'simple' => 'bulkshortener: missing URLS parameter',
        );
        echo $return['errorCode'] . ": " . $return['simple'];
        die();
    }

    $urlArray = array();
    foreach ($urls as $key => $value) {
      $url = $value['url'];
      $keyword = $value['keyword'];
      $title = $value['title'] ? $value['title'] : $url;

      $urlArray[$key] = yourls_add_new_link($url, $keyword, $title);
    }
    header('Content-Type:text/json;charset=utf-8');
    echo json_encode($urlArray);

    die();
}
