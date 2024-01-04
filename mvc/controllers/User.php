<?php
class User extends Controller{
    public function index() {
        // If user is not logged in, redirect to login page
        if (!isset($_SESSION['isLogin']) || $_SESSION['isLogin'] == false) {
            $this->redirect("Login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['oldPassword'])) { // Change password
                if (!isset($_POST['oldPassword']) || $_POST['oldPassword'] == '') {
                    $this->view("loggedLayout", ["Page" => "user", "Error" => "Password is empty"]);
                    exit();
                }
                if (!isset($_POST['newPassword']) || $_POST['newPassword'] == '') {
                    $this->view("loggedLayout", ["Page" => "user", "Error" => "New password is empty"]);
                    exit();
                }
                $oldPassword = $_POST['oldPassword'];
                $newPassword = $_POST['newPassword'];
                // Check if password is alphanumeric only and length is between 6 and 50
                if (!ctype_alnum($newPassword) || strlen($newPassword) < 6 || strlen($newPassword) > 50) {
                    $this->view("loggedLayout", ["Page" => "user", "Error" => "Password must be alphanumeric only and length is between 6 and 30"]);
                    exit();
                }

                $curUser = $this->model("UserModel");
                $checkPassword = $curUser->login($_SESSION['username'], $oldPassword);
                if ($checkPassword != $_SESSION['userId']) { // Incorrect password
                    $this->view("loggedLayout", ["Page" => "user", "Error" => "Incorrect password"]);
                    exit();
                }
                $changePassword = $curUser->changePassword($_SESSION['userId'], $newPassword);
                if ($changePassword == -1) { // Change password failed
                    $this->view("loggedLayout", ["Page" => "user", "Error" => "Change password failed"]);
                    exit();
                } else { // Change password success
                    $this->redirect("User");
                    exit();
                }
            } else { // Delete account
                if (!isset($_POST['curpassword']) || $_POST['curpassword'] == '') {
                    $this->view("loggedLayout", ["Page" => "user", "Error" => "Password is empty"]);
                    exit();
                }
                if (!isset($_POST['confirmPassword']) || $_POST['confirmPassword'] == '') {
                    $this->view("loggedLayout", ["Page" => "user", "Error" => "Confirm password is empty"]);
                    exit();
                }
                $curPassword = $_POST['curpassword'];
                $confirmPassword = $_POST['confirmPassword'];

                if (!ctype_alnum($curPassword) || strlen($curPassword) < 6 || strlen($curPassword) > 50) {
                    $this->view("loggedLayout", ["Page" => "user", "Error" => "Uncorrect password"]);
                    exit();
                }
                if (!ctype_alnum($confirmPassword) || strlen($confirmPassword) < 6 || strlen($confirmPassword) > 50) {
                    $this->view("loggedLayout", ["Page" => "user", "Error" => "Uncorrect password"]);
                    exit();
                }


                $curUser = $this->model("UserModel");
                $checkPassword = $curUser->login($_SESSION['username'], $curPassword);
                if ($checkPassword != $_SESSION['userId']) { // Incorrect password
                    $this->view("loggedLayout", ["Page" => "user", "Error" => "Incorrect password"]);
                    exit();
                }

                $checkPassword = $curUser->login($_SESSION['username'], $confirmPassword);
                if ($checkPassword != $_SESSION['userId']) { // Incorrect password
                    $this->view("loggedLayout", ["Page" => "user", "Error" => "Incorrect confirm password"]);
                    exit();
                }

                $curTask = $this->model("TaskModel");
                $curTask->deleteAllTaskByUser($_SESSION['userId']);
                $curUser->deleteUser($_SESSION['userId']);
                
                $this->redirect("Login/logout");

            }
           
        } else {
            $this->view("loggedLayout", ["Page" => "user", "Error" => ""]);
        }
       
    }

}
?>