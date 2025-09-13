<?php

require_once 'mainfile.php';
require 'vendor/autoload.php';

use League\HTMLToMarkdown\HtmlConverter;

$converter = new HtmlConverter(array('header_style'=>'atx'));

$handler = Legacy_Utils::getModuleHandler('page', 'review');
$cri = new CriteriaCompo();
$objects = $handler->getObjects($cri);
$header_format = '---
title: "%s"
category: "%s"
isbn: "%s"
rating: %s
publishedAt: %s
---

%s
';

foreach ($objects as $obj) {
    $id = $obj->getShow('page_id');
    $title = $obj->getShow('title');
    $category = "book";
    $isbn = $obj->get('isbn');
    $content = $obj->get('review');
    $rating = $obj->get('rating');
    $posttime = date('Y-m-d', $obj->get('posttime'));

    $header_text = sprintf(
        $header_format,
        $title,
        $category,
        $isbn,
        $rating,
        $posttime,
        $content = $converter->convert($obj->get('review'))
    ); 

    file_put_contents(XOOPS_UPLOAD_PATH . '/reviewexport/' . $id.'.md', $header_text);
}


