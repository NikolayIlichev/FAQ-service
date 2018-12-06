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
            } elseif (empty($arAdmin[0])) {                
                $msg = 'Пользователь с таким логином не найден!';
                render('auth.php', false, $msg);
            } else {
                $logData = date('Y-m-d H-i-s').': Выполнена авторизация пользователя '.$arAdmin[0]['login'].' ('.$arAdmin[0]['id'].')'."\r\n";
                writeLog($logData);
                $_SESSION['admin_id'] = $arAdmin[0]['id'];
                $_SESSION['login'] = $arAdmin[0]['login'];
                header('Location: index.php', TRUE, 301);
            }
        } elseif (!empty($_POST['log_in'])) {
            $msg = 'Все поля должны быть заполнены!';
            render('auth.php', false, $msg);
        } elseif(empty($_SESSION['admin_id'])) {
            render('auth.php');
        } else {
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
        } elseif (isset($_POST['admin_remove'])) {
            $msg = $this->removeAdmin();
        } elseif (isset($_POST['pass_change'])) {
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
                if (!$admin->add($login, $password, $confirm_password)) {
                    $msg = 'Администратор с таким логином уже существует!';
                } else {
                    $msg = 'Администратор добавлен!'; 
                    $logData = date('Y-m-d H-i-s').': Администратор '.$_SESSION['login'].' создал нового администратора '.$login."\r\n";
                    writeLog($logData);
                }
                
            } else {
                $msg = 'Пароли не совпадают!';
            }
        } elseif (!empty($_POST['admin_add'])) {
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
            $adminId = (int) htmlspecialchars(trim($_POST['admin_id']));
            $admin = new Admin();
            $admin->remove($adminId);
            $msg = 'Администратор удален!';
            $logData = date('Y-m-d H-i-s').': Администратор '.$_SESSION['login'].' удалил администратора  с id '.$adminId."\r\n";
            writeLog($logData);
        } else {
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
            $adminId = (int) htmlspecialchars(trim($_POST['admin_id']));
            $admin = new Admin();
            if ($admin->passChange($password, $adminId)) {
                $msg = 'Пароль обновлен';                
                $logData = date('Y-m-d H-i-s').': Администратор '.$_SESSION['login'].' изменил пароль у администратора с id '.$adminId."\r\n";
                writeLog($logData);
            }
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
        $logData = date('Y-m-d H-i-s').': Администратор '.$_SESSION['login'].' завершил сессию'."\r\n";
        writeLog($logData);
        $admin->logout();
        header('Location: /', TRUE, 301);
    }
}
?>