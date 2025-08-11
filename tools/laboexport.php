<?php

require_once 'mainfile.php';
require 'vendor/autoload.php';

use League\HTMLToMarkdown\HtmlConverter;

$converter = new HtmlConverter(array('header_style'=>'atx'));

$handler = Legacy_Utils::getModuleHandler('page', 'labo');
$cri = new CriteriaCompo();
$objects = $handler->getObjects($cri);
$header_format = '---
title: "%s"
category: "%s"
parent: "%s"
order: %s
publishedAt: %s
---

%s
';

$category_list = [
    1 => 'general',
    4 => 'scenariomaking',
    5 => 'system',
];

foreach ($objects as $obj) {
    $id = $obj->getShow('page_id');
    $title = $obj->getShow('title');
    $category = $category_list[$obj->getShow('category_id')];
    $parent = $obj->get('p_id');
    $content = $obj->get('content');
    $posttime = date('Y-m-d', $obj->get('posttime'));

    $header_text = sprintf(
        $header_format,
        $title,
        $category,
        $parent,
        $id,
        $posttime,
        $content = $converter->convert($obj->get('content'))
    ); 

    file_put_contents(XOOPS_UPLOAD_PATH . '/laboexport/' . $id.'.md', $header_text);
}


