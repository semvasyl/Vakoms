<?php

require_once 'Config.php';
require_once 'Client.php';
require_once 'Crud.php';
require_once 'TechTask.php';

$mongoManipulator = new \MongoTest\TechTask();

/**
 * HTTP actions
 */

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'view':
            echo json_encode($mongoManipulator->getArticles($_GET['user'] ?? null));
            break;
        case 'viewArticle':
            echo json_encode($mongoManipulator->getArticleByID($_GET['id'] ?? 0));
            break;
        case 'addComment':
            postFormShow();
            break;
    }

}

if (isset($_POST['text'], $_POST['articleID'])) {
    if (is_int((int)$_POST['articleID'])) {
        echo json_encode($mongoManipulator->addCommentToArticle(htmlspecialchars($_POST['text']), $_POST['articleID']));
    } else {
        echo json_encode(['error' => 'incorect param: articleID']);
    }
}


function postFormShow()
{
    echo '
<!DOCTYPE html>
<html>
<head>
	<title>add comment</title>
    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4">
		</div>
		<div class="col-md-4">
			<h3>
				Comment::add
			</h3>
			<form role="form" action="index.php" method="post">
				<div class="form-group">
					 
					<label for="InputText">
						Comment
					</label>
					<input type="text" class="form-control" id="InputText" name="text" required="true" />
				</div>
				<div class="form-group">
					 
					<label for="InputID">
						Article id:
					</label>
					<input type="number" class="form-control" id="InputID" name="articleID" required="true" />
				</div>
				<button type="submit" class="btn btn-primary">
					Sent
				</button>
			</form>
		</div>
		<div class="col-md-4">
		</div>
	</div>
</div>
<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>
</html>';
}


/**
 * CLI actions
 */

$shortopts='';
$longopts  = array(
    "viewAll",
    "view",
    "addComment",
    "id:",
    "text::",
);
$options = getopt($shortopts, $longopts);

if (in_array('viewAll',array_keys($options))){
    echo json_encode($mongoManipulator->getArticles($options['id'] ?? null));
    die(PHP_EOL);
}

if (in_array('view',array_keys($options))){
    echo json_encode($mongoManipulator->getArticleByID($options['id'] ?? 0));
    die(PHP_EOL);
}

if (in_array('addComment',array_keys($options))){
    echo json_encode($mongoManipulator->addCommentToArticle(
        $options['text'] ?? '',
        $options['id'] ?? 0
    ));
    die(PHP_EOL);
}