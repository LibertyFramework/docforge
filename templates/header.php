<?php
/**
 *
 */

$context = $this->getContext();
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="<?=$context->getAuthor()?>">
        <meta name="description" content="">
        <title><?=$context->getName()?> | <?=$context->getCurrentPage()->getLabel()?></title>
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
