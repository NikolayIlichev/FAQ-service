<?php
include_once 'model/Category.php';

/**
*   Класс уровня контроллер для работы с Моделью Category (категории)
**/

class CategoryController
{
    /**
    *    Метод передачи запроса в модель для добавления категории
    **/
    public function addCategory()
    {
        $msg = '';
        if (!empty($_POST['category'])) {    
            $categoryModel = new Category();
            $category = htmlspecialchars(trim($_POST['category']));            
            if (!$categoryModel->addCategory($category)) { 
                $msg = 'Категория с таким названием уже существует!';
            } else {
                $msg = 'Категория добавлена!';
                $logData = date('Y-m-d H-i-s').': Администратор '.$_SESSION['login'].' добавил категорию '.$category."\r\n";
                writeLog($logData);
            }                 
        }
        else {
            $msg = 'Пожалуйста, напишите название категории!';
        }
        return $msg;
    }

    /**
    *    Метод передачи запроса в модель для удаления категории
    **/
    public function removeCategory()
    {
        $msg = '';
        if (!empty($_POST['category_id'])) {
            $categoryModel = new Category();
            $category_id = (int) htmlspecialchars(trim($_POST['category_id']));
            $categoryModel->removeCategory($category_id);
            $msg = 'Категория удалена и все вопросы с ней!';            
            $logData = date('Y-m-d H-i-s').': Администратор '.$_SESSION['login'].' удалил категорию с id '.$category_id."\r\n";
            writeLog($logData);  
        }
        else {
            $msg = 'Передан пустой category_id';
        }
        return $msg;
    }

    /**
    *    Метод передачи запроса в модель для получения списка категорий
    **/
    public function getCategoriesList()
    {
        $msg = '';        
        $arCategories = array();
        $categoryModel = new Category();
        if (isset($_POST['add_category'])) {
            $msg = $this->addCategory();
        }
        elseif (isset($_POST['category_remove'])) {
            $msg = $this->removeCategory();
        }
        $arCategories = $categoryModel->getCategoriesList();
        render('categories.php', $arCategories, $msg);
    }
}