<?php

require_once 'Config.php';
require_once 'Client.php';
require_once 'Crud.php';
require_once 'TechTask.php';

$mongoManipulator = new \MongoTest\TechTask();

//echo json_encode($mongoManipulator->getArticles(5));

//echo json_encode($mongoManipulator->getArticleByID(1));

//echo json_encode($mongoManipulator->addCommentToArticle('the finale comentare',1));

echo PHP_EOL;