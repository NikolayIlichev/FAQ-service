<?php

/**
*    Класс уровня Модель для работы с вопросами и ответами
**/

class Question
{
    /**
    *    Метод добавления нового вопроса
    **/
    public function addQuestion($question, $category_id, $author, $email)
    {
        $db = db();
        $sql = 'INSERT INTO questions(category_id, question, author, email, date_create) VALUES (:category_id, :question, :author, :email, now())';
        $stmt = $db->prepare($sql);
        return $stmt->execute(['category_id' => $category_id, 'question' => $question, 'author' => $author, 'email' => $email]);
    }

    /**
    *    Метод удаления вопроса
    **/
    public function removeQuestion($question_id)
    {
        $msg = '';
        $db = db();            
        $sql = "DELETE FROM questions WHERE id=:question_id";
        $stmt = $db->prepare($sql);
        $stmt->execute(['question_id' => $question_id]);
        $msg = 'Вопрос удален!';
        return $msg;
    }

    /**
    *    Метод для публикации/скрытия вопроса
    **/
    public function changeQuestionActive($question_active, $question_id)
    {
        $msg = '';
        $db = db();
        $sql = 'UPDATE questions SET active=:question_active WHERE id=:question_id LIMIT 1';
        $stmt = $db->prepare($sql);
        $stmt->execute(['question_active' => $question_active, 'question_id' => $question_id]);
        $msg = 'Статус обновлен!';
        return $msg;
    }

    /**
    *    Метод для изменения категории у конкретного вопроса
    **/
    public function changeQuestionCategory($question_id, $new_category_id)
    {
        $msg = '';
        $db = db();
        $sql = 'UPDATE questions SET category_id=:new_category_id WHERE id=:question_id LIMIT 1';
        $stmt = $db->prepare($sql);
        $stmt->execute(['question_id' => $question_id, 'new_category_id' => $new_category_id]);
        $msg = 'Категория изменена!';
        return $msg;
    }

    /**
    *    Метод для получения списка опубликованных вопросов
    **/
    public function getQuestionsList()
    {
        $db = db();
        $sql = 'SELECT questions.category_id, questions.question, questions.answer, categories.category_name FROM questions LEFT JOIN categories ON questions.category_id=categories.id WHERE active="Y" ORDER BY category_id';
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
    *    Метод для получения конкретного вопроса
    **/
    public function getQuestion($question_id)
    {
        $db = db();
        $sql = 'SELECT questions.id as question_id, questions.question, questions.answer, questions.author, questions.active, categories.id as category_id 
                FROM questions LEFT JOIN categories ON questions.category_id=categories.id WHERE questions.id=:question_id';
        $stmt = $db->prepare($sql);
        $stmt->execute(['question_id' => $question_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
    *    Метод для изменения конкретного вопроса
    **/
    public function changeQuestion($question_id, $question, $active, $answer, $category_id, $author)
    {
        $db = db();
        $sql = 'UPDATE questions SET question=:question, answer=:answer, category_id=:category_id, author=:author, active=:active WHERE id=:question_id LIMIT 1';
        $stmt = $db->prepare($sql);
        return $stmt->execute(['question_id' => $question_id, 'question' => $question, 'answer' => $answer, 'category_id' => $category_id, 'author' => $author, 'active' => $active]);;
    }

    /**
    *    Метод для получения вопросов из конкретной категории
    **/    
    public function getCategoryQuestions($category_id)
    {
        $db = db();
        $sql = 'SELECT questions.id as question_id, questions.date_create, questions.question, questions.answer, questions.author, questions.active, categories.id as category_id, categories.category_name 
                FROM questions LEFT JOIN categories ON questions.category_id=categories.id WHERE category_id=:category_id ORDER BY date_create';
        $stmt = $db->prepare($sql);
        $stmt->execute(['category_id' => $category_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    
}