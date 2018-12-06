<?php 
session_start();

include_once 'controller/QuestionController.php';
include_once 'controller/AdminController.php';
include_once 'controller/CategoryController.php';

$questionController = new QuestionController();
$categoryController = new CategoryController();
$adminController = new AdminController();

if (!empty($_SESSION['admin_id'])) {
    if (!empty($_GET['admin']) && $_GET['admin'] == 'list') {
        $adminController->getAdminList();
    }    
    elseif (!empty($_GET['admin']) && $_GET['admin'] == 'main') {
        $adminController->getAdminPage();
    }
    elseif (!empty($_GET['admin']) && $_GET['admin'] == 'categories') {
        $categoryController->getCategoriesList();
    }
    elseif (!empty($_GET['category'])) {
        $questionController->getCategoryQuestions($_GET['category']);
    }
    elseif (!empty($_GET['question']) && $_GET['question'] == 'list') {
        $questionController->getQuestionsList();
    }
    elseif (!empty($_GET['question_change'])) {
        $questionController->changeQuestion();
    }
    elseif (!empty($_GET['logout']) && $_GET['logout'] == 'yes') {
        $adminController->logout();
    }
    else {
        $adminController->index();
    }
}
elseif (!empty($_GET['question']) && $_GET['question'] == 'list') {
    $questionController->getQuestionsList();
}
elseif (!empty($_GET['question']) && $_GET['question'] == 'add') {
    $questionController->addQuestion();
}
elseif (!empty($_GET['auth']) && $_GET['auth'] == 'yes') {
    $adminController->getAuth();
}
else {
    $adminController->index();
}
