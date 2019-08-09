<?php
/**
 *
 */

$scope = $this->getScope();
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="<?=$scope->getAuthor()?>">
        <meta name="description" content="">
        <title><?=$scope->getName()?> | <?=$scope->getCurrentPage()->getLabel()?></title>
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
