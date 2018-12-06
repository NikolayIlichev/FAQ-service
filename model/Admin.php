<?php

/**
*    Класс уровня модель для управления админами
**/

class Admin
{
    /**
    *    Метод для авторизации администраторов
    **/
    public function auth($login) 
    {
        $db = db();
        $sql = "SELECT id, login, password FROM users WHERE login=:login";
        $stmt = $db->prepare($sql);
        $stmt->execute(['login' => $login]);
        $arUser = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $arUser;
    }

    /**
    *    Метод для добавления администратора
    **/
    public function add($login, $password, $confirm_password) 
    {
        $msg = '';
        $db = db();
        $sql = "SELECT id FROM users WHERE login=:login";
        $stmt = $db->prepare($sql);
        $stmt->execute(['login' => $login]);
        $arUser = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($arUser)) {
            $msg = 'Администратор с таким логином уже существует!';
        }
        else {
            $sql = "INSERT INTO users(login, password) VALUES (:login, :password)";
            $stmt = $db->prepare($sql);
            $stmt->execute(['login' => $login, 'password' => $password]);
            $msg = 'Администратор добавлен!';                
        }
        return $msg;
    }

    /**
    *    Метод для удаления администратора
    **/
    public function remove($admin_id)
    {
        $msg = '';
        $db = db();            
        $sql = "DELETE FROM users WHERE id=:admin_id";
        $stmt = $db->prepare($sql);
        $stmt->execute(['admin_id' => $admin_id]);
        $msg = 'Администратор удален!';
        return $msg;
    }

    /**
    *    Метод для получения списка администраторов
    **/
    public function getAdminList()
    {
        $db = db();
        $sql = 'SELECT * FROM users';
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
    *    Метод для изменения пароля администратора
    **/
    public function passChange($newPassword, $admin_id)
    {
        $db = db();
        $sql = 'UPDATE users SET password=:password WHERE id=:admin_id LIMIT 1';
        $stmt = $db->prepare($sql);
        if($stmt->execute(['password' => $newPassword, 'admin_id' => $admin_id])) {
            return 'Пароль обновлен';
        }
    }

    /**
    *    Метод для выхода из текущей сессии
    **/
    public function logout() 
    {
        session_destroy();
        unset($_SESSION['admin_id']);
        unset($_SESSION['login']);
    }
}


?>