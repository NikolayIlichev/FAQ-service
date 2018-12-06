<?php

/**
*	Класс уровня Модель для работы с категориями
**/

class Category
{
	/**
    *    Метод для добавления новой категории
    **/
	public function addCategory($category)
	{
		$db = db();
		$sql = "SELECT id FROM categories WHERE category_name=:category";
		$stmt = $db->prepare($sql);
		$stmt->execute(['category' => $category]);
		$arCategories = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if (!empty($arCategories)) {
			$result = false;
		}
		else {
			$sql = 'INSERT INTO categories(category_name) VALUES (:category)';
			$stmt = $db->prepare($sql);
			$stmt->execute(['category' => $category]);	
			$result = true;		
		}
		return $result;
	}

	/**
    *    Метод для удаления категории и всех вопросов в ней
    **/
	public function removeCategory($category_id)
	{
		$db = db();			
		$sql = "DELETE FROM questions WHERE category_id=:category_id";
		$stmt = $db->prepare($sql);
		$stmt->execute(['category_id' => $category_id]);

		$sql = "DELETE FROM categories WHERE id=:category_id";
		$stmt = $db->prepare($sql);
		$stmt->execute(['category_id' => $category_id]);		
	}

	/**
    *    Метод для получения названия категории по ее ID
    **/
	public function getCategoryName($category_id)
	{
		$db = db();
		$sql = 'SELECT category_name FROM categories WHERE id=:category_id';
		$stmt = $db->prepare($sql);
		$stmt->execute(['category_id' => $category_id]);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
    *    Метод для получения списка категорий с подробной информацией о количестве вопросов в них
    **/
	public function getCategoriesList()
	{
		$db = db();
		$sql = "SELECT categories.id, category_name, count(questions.id)  as count_questions, SUM(IF(active='Y', 1, 0)) as active_question, SUM(IF(active='N', 1, 0)) as unactive_question, 
				SUM(IF((answer IS NULL OR answer='') AND NOT questions.id IS NULL, 1, 0)) as unanswered_question
				FROM categories
				LEFT JOIN questions ON categories.id=questions.category_id 
				GROUP BY categories.id";
		$stmt = $db->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
    *    Метод для получения списка категорий для использования в выпадающих списках
    **/
	public function getCategoryList()
	{
		$db = db();
		$sql = 'SELECT id, category_name FROM categories ORDER BY category_name';
		$stmt = $db->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}