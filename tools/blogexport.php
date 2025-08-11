<?php

require_once 'mainfile.php';
require 'vendor/autoload.php';

use League\HTMLToMarkdown\HtmlConverter;

$converter = new HtmlConverter(array('header_style'=>'atx'));

$tHandler = Legacy_Utils::getModuleHandler('tag', 'tag');
$handler = Legacy_Utils::getModuleHandler('page', 'blog');
$cri = new CriteriaCompo();
$objects = $handler->getObjects($cri);
$header_format = '---
title: "%s"
category: "%s"
tags: [%s]
publishedAt: %s
---

%s
';

$category_list = [
    1 => 'general',
    2 => 'game',
    3 => 'dev',
    4 => 'travel',
    5 => 'item',
];

foreach ($objects as $obj) {
    $id = $obj->getShow('page_id');
    $title = $obj->getShow('title');
    $category = $category_list[$obj->getShow('category_id')];
    $content = $obj->get('content');
    $posttime = date('Y-m-d', $obj->get('posttime'));

    // tags
    $tags = [];
    $tcri = new CriteriaCompo();
    $tcri->add(new Criteria('dirname', 'blog'));
    $tcri->add(new Criteria('data_id', $obj->get('page_id')));
    $tagObjects = $tHandler->getObjects($tcri);
    foreach ($tagObjects as $tagObj) {
        $tags[] = '"' . $tagObj->getShow('tag') . '"';
        // タグが「お出かけ」の場合は「カテゴリ」に「旅行」をセットする
        if ($tagObj->getShow('tag') == 'お出かけ' || $tagObj->getShow('tag') == 'お出かけ') {
            $category = 'travel';
        }
        if ($tagObj->getShow('tag') == 'ガジェット' || $tagObj->getShow('tag') == '作品') {
            $category = 'item';
        }
    }

    $header_text = sprintf(
        $header_format,
        $title,
        $category,
        implode(',', $tags),
        $posttime,
        $content = $converter->convert($obj->get('content'))
    ); 

    file_put_contents(XOOPS_UPLOAD_PATH . '/blogexport/' . $id.'.md', $header_text);
}


