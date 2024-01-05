<?php

class Tasks extends Controller
{

//---Public function

    public function index($Error = "")
    {
        // If user is not logged in, redirect to login page
        if (!isset($_SESSION['isLogin']) || $_SESSION['isLogin'] == false) {
            $this->redirect("Login");
            exit();
        }

        // If user search for tasks
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['findTitle']) && $_POST['findTitle'] != '' && isset($_POST['findDate']) && $_POST['findDate'] != '') { // Find task by title and date
                $search = $_POST['findTitle'];
                $date = $_POST['findDate'];
                $curTask = $this->model("TaskModel");
                $tasks = $curTask->findUndoneByTitleAndDate($_SESSION['userId'], $search, $date);
                $this->view("loggedLayout", ["Page" => "tasks", "Tasks" => $tasks, "Error" => $Error, "findTitle" => $search, "findDate" => $date]);
                if (isset($_POST['findTitle']))
                    unset($_POST['findTitle']);
                if (isset($_POST['findDate']))
                    unset($_POST['findDate']);

                exit();
            }
            if (isset($_POST['findTitle']) && $_POST['findTitle'] != '') { // Find task by title
                $search = $_POST['findTitle'];
                $curTask = $this->model("TaskModel");
                $tasks = $curTask->findUndoneByTitle($_SESSION['userId'], $search);
                $this->view("loggedLayout", ["Page" => "tasks", "Tasks" => $tasks, "Error" => $Error, "findTitle" => $search]);
                if (isset($_POST['findTitle']))
                    unset($_POST['findTitle']);

                exit();
            }
            if (isset($_POST['findDate']) && $_POST['findDate'] != '') { // Find task by date
                $search = $_POST['findDate'];
                $curTask = $this->model("TaskModel");
                $tasks = $curTask->findUndoneByDate($_SESSION['userId'], $search);
                $this->view("loggedLayout", ["Page" => "tasks", "Tasks" => $tasks, "Error" => $Error, "findDate" => $search]);
                if (isset($_POST['findDate']))
                    unset($_POST['findDate']);

                exit();
            }
        }

        // If user is logged in, show undone tasks
        $curUser = $this->model("TaskModel");
        $tasks = $curUser->getUndoneTasksByUser($_SESSION['userId']);
        $this->view("loggedLayout", ["Page" => "tasks", "Tasks" => $tasks, "Error" => $Error]);
    }

    // Add new task
    public function addTask()
    {
        // If user is not logged in, redirect to login page
        if (!isset($_SESSION['isLogin']) || $_SESSION['isLogin'] == false) {
            $this->redirect("Login");
            exit();
        }

        // If user submit new task
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = isset($_POST['title']) ? $_POST['title'] : '';
            $content = isset($_POST['content']) ? $_POST['content'] : '';
            $duedate = isset($_POST['duedate']) ? ($_POST['duedate'] == '' ? null : $_POST['duedate']) : null;
            $status = isset($_POST['status']) ? $_POST['status'] : '';

            // Unset task infomation in $_POST
            if (isset($_POST['title']))
                unset($_POST['title']);
            if (isset($_POST['content']))
                unset($_POST['content']);
            if (isset($_POST['duedate']))
                unset($_POST['duedate']);
            if (isset($_POST['status']))
                unset($_POST['status']);

            // Check valid task
            $error = $this->checkVaildTask($title, $content, $duedate, $status);
            if ($error != '') {
                $this->view("loggedLayout", ["Page" => "addTask", "Error" => $error, "Task" => ['title' => $title, 'content' => $content, 'duedate' => $duedate, 'status' => $status]]);
                exit();
            }

            // Change status to number
            $status = $status == 'Done' ? 1 : 0;

            // Add task to database
            $curTask = $this->model("TaskModel");
            $result = $curTask->addTask($_SESSION['userId'], $title, $content, $duedate, $status);

            $this->redirect("Tasks");
            exit();
        } else {
            $this->view("loggedLayout", ["Page" => "addTask", "Error" => "", "Task" => ['title' => '', 'content' => '', 'duedate' => '', 'status' => '']]);
            exit();
        }
    }

    // Edit task information, $id is task id
    public function editTask($id)
    {
        // If user is not logged in, redirect to login page
        if (!isset($_SESSION['isLogin']) || $_SESSION['isLogin'] == false) {
            $this->redirect("Login");
            exit();
        }

        // Check if the task is of the user or not
        if (($this->checkTaskOfUser($id)) == false) {
            $this->redirect("Tasks");
            exit();
        }

        // If user submit edit task
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = isset($_POST['title']) ? $_POST['title'] : '';
            $content = isset($_POST['content']) ? $_POST['content'] : '';
            $duedate = isset($_POST['duedate']) ? ($_POST['duedate'] == '' ? null : $_POST['duedate']) : null;
            $status = isset($_POST['status']) ? $_POST['status'] : '';

            // Unset task infomation in $_POST
            if (isset($_POST['title']))
                unset($_POST['title']);
            if (isset($_POST['content']))
                unset($_POST['content']);
            if (isset($_POST['duedate']))
                unset($_POST['duedate']);
            if (isset($_POST['status']))
                unset($_POST['status']);

            // Check valid task
            $error = $this->checkVaildTask($title, $content, $duedate, $status);
            if ($error != '') {
                $this->view("loggedLayout", ["Page" => "editTask", "Error" => $error, "idTask" => $id, "Task" => ['title' => $title, 'content' => $content, 'duedate' => $duedate, 'status' => $status]]);
                exit();
            }

            // Change status to number
            $status = $status == 'Done' ? 1 : 0;

            // Update task to database
            $curtask = $this->model("TaskModel");
            $result = $curtask->updateTask($id, $title, $content, $duedate, $status);
            //$this->model("TaskModel")->updateTask($id, $title, $content, $duedate, $status);
            $this->redirect("Tasks");
        } else {
            $curUser = $this->model("TaskModel");
            $task = $curUser->getTask($id);
            $this->view("loggedLayout", ["Page" => "editTask", "Error" => "", "Task" => $task[0], "idTask" => $id]);
        }
    }

    // Import tasks from file (txt or xlsx)
    public function importFile()
    {
        // If user is not logged in, redirect to login page
        if (!isset($_SESSION['isLogin'])) {
            $this->redirect("Login");
            exit();
        }

        // If user submit file
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileToUpload"])) {
            $fileType = pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION);
            $fileType = strtolower($fileType);

            // txt file
            if ($fileType == "txt") {
                $file = file($_FILES["fileToUpload"]["tmp_name"]);
                $error = $this->readTxt($file);
                $this->redirect("Tasks");
                exit();
            }

            // xlxs file
            if ($fileType == "xlsx") {
                $error = $this->readXlsx($_FILES["fileToUpload"]["tmp_name"]);
                $this->redirect("Tasks");
                exit();
            }

            unset($_FILES["fileToUpload"]);
            // Unsupported file type
            $this->redirect("Tasks");
        }
    }

    // Change status task, 0 is undone, 1 is done, 2 is delete
    public function changeStatus($id, $curstatus, $newstatus) {
        // If user is not logged in, redirect to login page
        if (!isset($_SESSION['isLogin'])) {
            $this->redirect("Login");
            exit();
        }

        // Check if the task is of the user or not
        if (($this->checkTaskOfUser($id)) == false) {
            $this->redirect("Tasks");
            exit();
        }

        // If user change status of task to the same status, redirect to undone or done tasks
        if ($curstatus == $newstatus) {
            if ($curstatus == 0) { // go to undone tasks page
                $this->redirect("Tasks");
                exit();
            }
            if ($curstatus == 1) { // go to done tasks page
                $this->redirect("Tasks/doneTasks");
                exit();
            }
        }

        // Change status of task
        $curTask = $this->model("TaskModel");
        $changeStatus = $curTask->changeStatus($id, $newstatus);
        if ($curstatus == 0) { // go to undone tasks page
            $this->redirect("Tasks");
            exit();
        }
        if ($curstatus == 1) { // go to done tasks page
            $this->redirect("Tasks/doneTasks");
            exit();
        }
    }

    // Done tasks of user
    public function doneTasks() {
        // If user is not logged in, redirect to login page
        if (!isset($_SESSION['isLogin'])) {
            $this->redirect("Login");
            exit();
        }
        
        // If user search for tasks in done tasks page
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['findTitle']) && $_POST['findTitle'] != '' && isset($_POST['findDate']) && $_POST['findDate'] != '') { // Filter task by title and date
                $search = $_POST['findTitle'];
                $date = $_POST['findDate'];
                $curTask = $this->model("TaskModel");
                $tasks = $curTask->findDoneByTitleAndDate($_SESSION['userId'], $search, $date);
                $this->view("loggedLayout", ["Page" => "doneTasks", "Tasks" => $tasks, "findTitle" => $search, "findDate" => $date]);

                // Unset task infomation in $_POST
                if (isset($_POST['findTitle']))
                    unset($_POST['findTitle']);
                if (isset($_POST['findDate']))
                    unset($_POST['findDate']);

                exit();
            }
            if (isset($_POST['findTitle']) && $_POST['findTitle'] != '') { // Filter task by title
                $search = $_POST['findTitle'];
                $curTask = $this->model("TaskModel");
                $tasks = $curTask->findDoneByTitle($_SESSION['userId'], $search);
                $this->view("loggedLayout", ["Page" => "doneTasks", "Tasks" => $tasks, "findTitle" => $search]);

                if (isset($_POST['findTitle']))
                    unset($_POST['findTitle']);

                exit();
            }
            if (isset($_POST['findDate']) && $_POST['findDate'] != '') { // Filter task by date
                $search = $_POST['findDate'];
                $curTask = $this->model("TaskModel");
                $tasks = $curTask->findDoneByDate($_SESSION['userId'], $search);
                $this->view("loggedLayout", ["Page" => "doneTasks", "Tasks" => $tasks, "findDate" => $search]);

                if (isset($_POST['findDate']))
                    unset($_POST['findDate']);

                exit();
            }
        }
        // If user is logged in, show done tasks
        $curTask = $this->model("TaskModel");
        $tasks = $curTask->getDoneTasksByUser($_SESSION['userId']);
        $this->view("loggedLayout", ["Page" => "doneTasks", "Tasks" => $tasks]);
        exit();
    }

//--- Private function
    
    // Check valid task, return error message or empty string
    private function checkVaildTask($title, $content, $duedate, $status)
    {
        // Check if title is empty
        $title = trim($title);
        if ($title == '' || $title == null) {
            return "Title is empty";
        }
        // Check if title is too long (> 50 characters)
        if (strlen($title) > 50) {
            return "Title must be less than 50 characters";
        }
        // Check if content is too long (> 1000 characters)
        if (strlen($content) > 1000) {
            return "Content must be less than 1000 characters";
        }
        // Duedate can be empty. But if not, check if it is a valid date
        if ($duedate != null && $duedate != "") {
            $date = explode('-', $duedate);
            if (count($date) != 3 || !checkdate($date[1], $date[2], $date[0]) || $date[0] < 1900 || $date[0] > 2106) {
                return "Duedate is invalid";
            }
        }
        return '';
    }

    // Read xlsx file to import tasks
    private function readXlsx($filename)
    {
        $zip = new ZipArchive;

        if ($zip->open($filename) === TRUE) {
            // Locate the shared strings file
            $sharedStrings = $zip->getFromName('xl/sharedStrings.xml');
            $sharedStringsXml = simplexml_load_string($sharedStrings);

            // Locate the sheet data file
            $sheet = $zip->getFromName('xl/worksheets/sheet1.xml');
            $sheetXml = simplexml_load_string($sheet);

            $allErrors = ""; // All errors when import file
            $idRow = 0;
            // Loop through rows and cells, each row is a task
            foreach ($sheetXml->sheetData->row as $row) {
                $idRow++;
                $task = [];

                // Check empty task
                if (empty($row->c[0]->v)) {
                    continue;
                }

                // each col is a field of task:  0 title, 1 content, 2 duedate, 3 status
                for ($col = 0; $col < 4; $col++) {
                    $cell = $row->c[$col];
                    $value = isset($cell->v) ? (string) $cell->v : '';

                    // If the cell has a "t" attribute, it means it's a shared string
                    if (isset($cell['t']) && (string) $cell['t'] == 's') {
                        $value = (string) $sharedStringsXml->si[intval($value)]->t;
                    }

                    // '/' is empty cell
                    if ($value == "/") {
                        $value = "";
                        if ($col == 2)
                            $value = null;
                        if ($col == 3)
                            $value = 0;
                    } else if ($col == 2) { // Format date
                        $dateValue = floatval($value);
                        $timestamp = strtotime('1899-12-30') + ($dateValue * 24 * 60 * 60);
                        $formattedDate = date('Y-m-d', $timestamp);
                        $value = $formattedDate;
                    }
                    $task[] = $value;
                }

                // Check valid task
                $error = $this->checkVaildTask($task[0], $task[1], $task[2], $task[3]);
                if ($error == '') {
                    // Add task to database
                    $curTask = $this->model("TaskModel");
                    $addTask = $curTask->addTask($_SESSION['userId'], $task[0], $task[1], $task[2], $task[3]);
                } else {
                    $allErrors .= "Row " . $idRow . ": " . $error . "<br/>";
                }
            }
            $zip->close();
        } else {
            $allErrors = "Failed to open the XLSX file";
        }
        return ($allErrors == "") ? "" : "ImportFailed";
    }

    // Read txt file to import tasks, return error message or empty string
    private function readTxt($file)
    {
        $readInstruction = false; // check if read instruction or not
        $idTask = -1; // id of task
        $idCol = 0; // field of task: 0 title, 1 content, 2 duedate, 3 status
        $allErrors = []; // All errors when import file
        $task = ["", "", null, 0]; // task information

        // Loop through each line of file
        foreach ($file as $line) {
            $line = trim($line);
            if ($line == "\*") { // Start read instruction
                $readInstruction = true;
                continue;
            }
            if ($readInstruction) { // Read instruction
                if ($line == "*/") { // End read instruction
                    $readInstruction = false;
                }
                continue;
            }
            if ($line == "title:") {
                $idCol = 0;
                if ($task[0] != "") { // Add the previous task to database
                    // Check valid task
                    $error = $this->checkVaildTask($task[0], $task[1], $task[2], $task[3]);
                    if ($error == '') {
                        $curTask = $this->model("TaskModel");
                        $addTask = $curTask->addTask($_SESSION['userId'], $task[0], $task[1], $task[2], $task[3]);
                    } else {
                        $allErrors .= $error . "<br/>";
                    }
                }
                // Reset task information
                $task = ["", "", null, 0];
            } else if ($line == "content:")
                $idCol = 1;
            else if ($line == "duedate:")
                $idCol = 2;
            else if ($line == "status:")
                $idCol = 3;
            else { // Read task information
                $value = $line;
                if ($idCol == 2) { // If duedate, format date
                    if ($value == "")
                        $value = null; // If empty, set null
                    else {
                        $dateTime = DateTime::createFromFormat('d/m/Y', $value);
                        if ($dateTime == false) {
                            $allErrors .= "Invalid date format: " . $value . "<br/>";
                            $value = null;
                        } else {
                            $value = $dateTime->format('Y-m-d');
                        }
                    }
                } else if ($idCol == 3) { // If status, change to number
                    if ($value == "")
                        $value = 0;
                }
                if ($value != "")
                    $task[$idCol] = $value; // If value is not empty, add to task information
            }
        }
        if ($task[0] != "") { // Add last task to database
            $error = $this->checkVaildTask($task[0], $task[1], $task[2], $task[3]);
            if ($error == '') {
                $curTask = $this->model("TaskModel");
                $addTask = $curTask->addTask($_SESSION['userId'], $task[0], $task[1], $task[2], $task[3]);
            } else {
                $allErrors .= $error . "<br/>";
            }
        }

        return ($allErrors == "") ? "" : "ImportFailed";
    }

    // Check if the task is of the user or not, return true or false
    private function checkTaskOfUser($id) {
        $curTask = $this->model("TaskModel");
        $task = $curTask->getUserIdOfTask($id); // A list of task
        return ($task == $_SESSION['userId']);
    }
}
?>
