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
            $category_id = htmlspecialchars(trim($_POST['category_id']));
            $author = htmlspecialchars(trim($_POST['author']));
            $email = htmlspecialchars(trim($_POST['email']));
            
            if($questionModel->addQuestion($question, $category_id, $author, $email)) {
                $msg = 'Вопрос добавлен!';
            }
            else {
                $msg = 'Вопрос НЕ добавлен!';
            }
        }
        elseif(isset($_POST['add_question'])) {
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
        $question_id = htmlspecialchars(trim($_GET['question_change']));
        $questionModel = new Question();
        $categoryModel = new Category();
        $arCategories['categories'] = $categoryModel->getCategoryList();
        if (!empty($_POST['change_question'])) {    
            if(empty($_POST['question'])) {
                $msg = "Поле вопроса не заполнено!";
            }
            else {
                $question_id = htmlspecialchars(trim($_POST['question_id']));
                $question = htmlspecialchars(trim($_POST['question']));
                if (!empty($_POST['active'])) {
                    $active = 'Y';
                }
                else {
                    $active = 'N';
                }
                $answer = htmlspecialchars(trim($_POST['answer']));
                $category_id = htmlspecialchars(trim($_POST['category_id']));
                $author = htmlspecialchars(trim($_POST['author']));
                
                if($questionModel->changeQuestion($question_id, $question, $active, $answer, $category_id, $author)) {
                    $msg = 'Вопрос обновлен!';
                }
                else {
                    $msg = 'Вопрос НЕ обновлен!';
                }
            }
        }
        $arCategories['changeQuestion'] = $questionModel->getQuestion($question_id);
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
            $question_id = htmlspecialchars(trim($_POST['question_id']));
            $new_category_id = htmlspecialchars(trim($_POST['new_category_id']));
            $msg = $questionModel->changeQuestionCategory($question_id, $new_category_id);            
        }
        else {
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
            $question_id = (int) htmlspecialchars(trim($_POST['question_id']));
            $questionModel = new Question();
            $msg = $questionModel->removeQuestion($question_id);
        }
        else {
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
    public function getCategoryQuestions($category_id)
    {
        $msg = '';
        $arData = array();
        $questionModel = new Question();
        $categoryModel = new Category();
        if (isset($_POST['question_remove'])) {
            $msg = $this->removeQuestion();
        }
        elseif (isset($_POST['change_category'])) {
            $msg = $this->changeCategory();
        }
        elseif (isset($_POST['question_active'])) {
            $msg = $this->changeQuestionActive();
        }
        $arData['category_name'] = $categoryModel->getCategoryName($category_id)[0]['category_name'];
        $arData['questions'] = $questionModel->getCategoryQuestions($category_id);
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
            $question_id = htmlspecialchars(trim($_POST['question_id']));
            $questionModel = new Question();
            $msg = $questionModel->changeQuestionActive($question_active, $question_id);            
        }
        else {
            $msg = 'Ошибка';
        }
        return $msg;
    }
}
?>