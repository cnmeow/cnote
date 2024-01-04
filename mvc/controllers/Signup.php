<?php

class Signup extends Controller{
    public function index() {
        if (isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == true) {
            $this->redirect("Tasks");
            exit();
        }
        $_SESSION['isLogin'] = false;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Signup
            $username = (isset($_POST['username'])) ? $_POST['username'] : '';
            $password = (isset($_POST['password'])) ? $_POST['password'] : '';

            // Check if username is empty
            if ($username == '') {
                $this->view("layout", ["Page" => "signup", "Error" => "Username is empty", "Username" => $username, "Password" => $password]);
                exit();
            }
            // Check if username is alphanumeric only and length is between 1 and 30
            if (!ctype_alnum($username) || strlen($username) < 1 || strlen($username) > 30) {
                $this->view("layout", ["Page" => "signup", "Error" => "Username must be alphanumeric only and length is between 1 and 30", "Username" => $username, "Password" => $password]);
                exit();
            }
            // Check if password is empty
            if ($password == '') {
                $this->view("layout", ["Page" => "signup", "Error" => "Password is empty", "Username" => $username, "Password" => $password]);
                exit();
            }
            // Check if password is alphanumeric only and length is between 6 and 50
            if (!ctype_alnum($password) || strlen($password) < 6 || strlen($password) > 50) {
                $this->view("layout", ["Page" => "signup", "Error" => "Password must be alphanumeric only and length is between 6 and 30", "Username" => $username, "Password" => $password]);
                exit();
            }
            // Check if username and password are correct
            $curUser = $this->model("UserModel");
            $signup = $curUser->addUser($username, $password);
            if ($signup == -1) { // Username already exists
                $this->view("layout", ["Page" => "signup", "Error" => "Username already exists", "Username" => $username, "Password" => $password]);
                exit();
            } else { // Signup success
                $_SESSION['userId'] = $signup;
                $_SESSION['username'] = $username;
                $_SESSION['isLogin'] = true;
                $this->redirect("Tasks");
                exit();
            } 
        } else {
            $this->view("layout", ["Page" => "signup", "Error" => "", "Username" => "", "Password" => ""]);
        }
    }
}
?>