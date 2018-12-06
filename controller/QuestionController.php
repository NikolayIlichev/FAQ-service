<?php
include_once 'model/Question.php';
include_once 'model/Category.php';

/**
*    Класс уровня контроллер для работы с Моделью Question (вопросы и ответы)
**/

class QuestionController
{
    /**
    *    Метод передачи данных в модель для добавления вопроса
    **/
    public function addQuestion() 
    {
        $arCategories = array();
        $msg = '';
        $questionModel = new Question();
        $categoryModel = new Category();
        $arCategories = $categoryModel->getCategoryList();
        if (!empty($_POST['question'])) {    
            $question = htmlspecialchars(trim($_POST['question']));
            $categoryId = htmlspecialchars(trim($_POST['category_id']));
            $author = htmlspecialchars(trim($_POST['author']));
            $email = htmlspecialchars(trim($_POST['email']));
            
            if($questionModel->addQuestion($question, $categoryId, $author, $email)) {
                $logData = date('Y-m-d H-i-s').': Добавлен новый вопрос в категорию с id '.$categoryId."\r\n";
                writeLog($logData);
                $msg = 'Вопрос добавлен!';
            } else {
                $msg = 'Вопрос НЕ добавлен!';
            }
        } elseif(isset($_POST['add_question'])) {
            $msg = 'Пожалуйста, напишите свой вопрос!';
        }
        render('addQuestion.php', $arCategories, $msg);
    }

    /**
    *    Метод передачи данных в модель для изменения вопроса
    **/
    public function changeQuestion()
    {
        $msg = '';
        $arCategories = array();
        $questionId = htmlspecialchars(trim($_GET['question_change']));
        $questionModel = new Question();
        $categoryModel = new Category();
        $arCategories['categories'] = $categoryModel->getCategoryList();
        if (!empty($_POST['change_question'])) {    
            if(empty($_POST['question'])) {
                $msg = "Поле вопроса не заполнено!";
            } else {
                $questionId = htmlspecialchars(trim($_POST['question_id']));
                $question = htmlspecialchars(trim($_POST['question']));
                if (!empty($_POST['active'])) {
                    $active = 'Y';
                } else {
                    $active = 'N';
                }
                $answer = htmlspecialchars(trim($_POST['answer']));
                $categoryId = htmlspecialchars(trim($_POST['category_id']));
                $author = htmlspecialchars(trim($_POST['author']));
                
                if($questionModel->changeQuestion($questionId, $question, $active, $answer, $categoryId, $author)) {                    
                    $logData = date('Y-m-d H-i-s').': Администратор '.$_SESSION['login'].' обновил вопрос с id '.$questionId."\r\n";
                    writeLog($logData);
                    $msg = 'Вопрос обновлен!';
                } else {
                    $msg = 'Вопрос НЕ обновлен!';
                }
            }
        }
        $arCategories['changeQuestion'] = $questionModel->getQuestion($questionId);
        render('changeQuestion.php', $arCategories, $msg);
    }

    /**
    *    Метод передачи данных в модель для изменения категории вопроса
    **/
    public function changeCategory()
    {
        $msg = '';
        if (!empty($_POST['new_category_id']) && !empty($_POST['question_id'])) {    
            $questionModel = new Question();
            $questionId = htmlspecialchars(trim($_POST['question_id']));
            $newCategoryId = htmlspecialchars(trim($_POST['new_category_id']));
            $questionModel->changeQuestionCategory($questionId, $newCategoryId);
            $msg = 'Категория изменена!';    
            $logData = date('Y-m-d H-i-s').': Администратор '.$_SESSION['login'].' изменил категорию у вопроса с id '.$questionId."\r\n";
            writeLog($logData);        
        } else {
            $msg = 'Ошибка';
        }
        return $msg;
    }

    /**
    *    Метод передачи данных в модель для удаления вопроса
    **/
    public function removeQuestion()
    {
        $msg = '';
        if (!empty($_POST['question_id'])) {
            $questionId = (int) htmlspecialchars(trim($_POST['question_id']));
            $questionModel = new Question();
            $questionModel->removeQuestion($questionId);
            $msg = 'Вопрос удален!';
            $logData = date('Y-m-d H-i-s').': Администратор '.$_SESSION['login'].' удалил вопрос с id '.$questionId."\r\n";
            writeLog($logData); 
        } else {
            $msg = 'Передан пустой question_id';
        }
        return $msg;
    }

    /**
    *    Метод передачи запроса в модель для получения списка вопросов
    **/
    public function getQuestionsList()
    {
        $arQuestions = array();
        $questionModel = new Question();
        $arQuestions = $questionModel->getQuestionsList();        
        if (!empty($arQuestions)) {
            foreach ($arQuestions as $key => $question) {
                $arTemp[$question['category_id']][] = $question;
            }
            $arQuestions = $arTemp;
        }
        render('questionList.php', $arQuestions);
    }

    /**
    *    Метод передачи запроса в модель для получения списка вопросов конкретной категории
    **/
    public function getCategoryQuestions($categoryId)
    {
        $msg = '';
        $arData = array();
        $questionModel = new Question();
        $categoryModel = new Category();
        if (isset($_POST['question_remove'])) {
            $msg = $this->removeQuestion();
        } elseif (isset($_POST['change_category'])) {
            $msg = $this->changeCategory();
        } elseif (isset($_POST['question_active'])) {
            $msg = $this->changeQuestionActive();
        }
        $arData['category_name'] = $categoryModel->getCategoryName($categoryId)[0]['category_name'];
        $arData['questions'] = $questionModel->getCategoryQuestions($categoryId);
        $arData['categories'] = $categoryModel->getCategoryList();
        render('questionAdminPage.php', $arData, $msg);
    }

    /**
    *    Метод передачи запроса в модель для изменения статуса вопроса
    **/
    public function changeQuestionActive()
    {
        $msg = '';
        if (!empty($_POST['active']) && !empty($_POST['question_id'])) {    
            $question_active = htmlspecialchars(trim($_POST['active']));
            $questionId = htmlspecialchars(trim($_POST['question_id']));
            $questionModel = new Question();
            $questionModel->changeQuestionActive($question_active, $questionId); 
            $msg = 'Статус обновлен!';
            $logData = date('Y-m-d H-i-s').': Администратор '.$_SESSION['login'].' изменил статус вопроса с id '.$questionId."\r\n";
            writeLog($logData);           
        } else {
            $msg = 'Ошибка';
        }
        return $msg;
    }
}
?>