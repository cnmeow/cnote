<?php

class Login extends Controller{
    public function index() {
        if (isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == true) {
            $this->redirect("Tasks");
            exit();
        }
        $_SESSION['isLogin'] = false;
 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Login
            $username = (isset($_POST['username'])) ? $_POST['username'] : '';
            $password = (isset($_POST['password'])) ? $_POST['password'] : '';

            // Check if username is empty
            if ($username == '') {
                $this->view("layout", ["Page" => "login", "Error" => "Username is empty", "Username" => $username, "Password" => $password]);
                exit();
            }
            // Check if password is empty
            if ($password == '') {
                $this->view("layout", ["Page" => "login", "Error" => "Password is empty", "Username" => $username, "Password" => $password]);
                exit();
            }
            // Check if username and password are correct
            $curUser = $this->model("UserModel");
            $login = $curUser->login($username, $password);
            if ($login == -1) { // User not exists
                $this->view("layout", ["Page" => "login", "Error" => "User not exists, please sign up", "Username" => $username, "Password" => $password]);
                exit();
            } else if ($login == -2) { // Password incorrect
                $this->view("layout", ["Page" => "login", "Error" => "Password incorrect", "Username" => $username, "Password" => $password]);
                exit();
            } else { // Login success
                $_SESSION['userId'] = $login;
                $_SESSION['username'] = $username;
                $_SESSION['isLogin'] = true;
                $this->redirect("Tasks");
                exit();
            } 
        } else {
            $this->view("layout", ["Page" => "login", "Error" => "", "Username" => "", "Password" => ""]);
        }
    }

    public function logout() {
        unset($_SESSION['isLogin']);
        unset($_SESSION['username']);
        unset($_SESSION['userId']);

        $this->redirect("Login");
    }
}
?>