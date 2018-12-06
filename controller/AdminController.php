<?php
include_once 'model/Admin.php';

/**
*   Класс для управления администраторами
**/

class AdminController
{
    /**
    *    Метод передачи запроса в модель для авторизации администратора
    **/
    public function getAuth()
    {
        $msg = '';
        if (!empty($_POST['login']) && !empty($_POST['password'])) {            
            $admin = new Admin();
            $login = htmlspecialchars(trim($_POST['login']));
            $password = htmlspecialchars(trim($_POST['password']));
            $arAdmin = $admin->auth($login);    
            if (!empty($arAdmin[0]) && $arAdmin[0]['password'] !== $password) {
                $msg = 'Неверный пароль!';
                render('auth.php', false, $msg);
            }
            elseif (empty($arAdmin[0])) {                
                $msg = 'Пользователь с таким логином не найден!';
                render('auth.php', false, $msg);
            }
            else {
                $_SESSION['admin_id'] = $arAdmin[0]['id'];
                $_SESSION['login'] = $arAdmin[0]['login'];
                header('Location: index.php', TRUE, 301);
            }
        }
        elseif (!empty($_POST['log_in'])) {
            $msg = 'Все поля должны быть заполнены!';
            render('auth.php', false, $msg);
        }    
        elseif(empty($_SESSION['admin_id'])) {
            render('auth.php');
        }
        else {
            render('index.php');
        }
    }

    /**
    *    Метод передачи запроса в модель для получения списка администраторов
    **/
    public function getAdminList()
    {
        $msg = '';
        if (isset($_POST['admin_add'])) {
            $msg = $this->addAdmin();
        }
        elseif (isset($_POST['admin_remove'])) {
            $msg = $this->removeAdmin();
        }
        elseif (isset($_POST['pass_change'])) {
            $msg = $this->passChange();
        }
        $arAdmins = array();
        $adminModel = new Admin();
        $arAdmins = $adminModel->getAdminList();    
        render('adminList.php', $arAdmins, $msg);

    }

    /**
    *    Метод передачи запроса в модель для добавления нового администратора
    **/
    public function addAdmin() 
    {
        $msg = '';
        if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])) {                    
            $login = htmlspecialchars(trim($_POST['login']));
            $password = htmlspecialchars(trim($_POST['password']));
            $confirm_password = htmlspecialchars(trim($_POST['confirm_password']));
            if ($password === $confirm_password ) {        
                $admin = new Admin();
                $msg = $admin->add($login, $password, $confirm_password);
            }
            else {
                $msg = 'Пароли не совпадают!';
            }
        }
        elseif (!empty($_POST['admin_add'])) {
            $msg = 'Все поля должны быть заполнены!';
        }
        return $msg;
    }

    /**
    *    Метод передачи запроса в модель для удаления администратора
    **/
    public function removeAdmin()
    {
        $msg = '';
        if (!empty($_POST['admin_id'])) {
            $admin_id = (int) htmlspecialchars(trim($_POST['admin_id']));
            $admin = new Admin();
            $msg = $admin->remove($admin_id);
        }
        else {
            $msg = 'Передан пустой admin_id';
        }
        return $msg;
    }

    /**
    *    Метод передачи запроса в модель для изменения пароля администратора
    **/
    public function passChange()
    {
        $msg = '';
        if (!empty($_POST['password']) && !empty($_POST['admin_id'])) {
            $password = htmlspecialchars(trim($_POST['password']));
            $admin_id = (int) htmlspecialchars(trim($_POST['admin_id']));
            $admin = new Admin();
            $msg = $admin->passChange($password, $admin_id);
        }
        return $msg;
    }

    /**
    *    Метод для отображения главной страницы по умолчанию
    **/
    public function index() 
    {
        render('index.php');
    }

    /**
    *    Метод для отображения главной страницы панели управления
    **/
    public function getAdminPage()
    {
        render('adminMainPage.php');
    }

    /**
    *    Метод для выхода из текущей сессии
    **/
    public function logout() 
    {
        $admin = new Admin();
        $admin->logout();
        header('Location: /', TRUE, 301);
    }
}
?>