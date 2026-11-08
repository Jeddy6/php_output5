
<?php

require_once "config/database.php";
require_once "models/Faculty.php";
require_once "controllers/FacultyController.php";

// DATABASE CONNECTION
$database = new Database();
$db = $database->connect();

// CREATE MODEL AND CONTROLLER
$model = new Faculty($db);
$controller = new FacultyController($model);

// DEFAULT VALUES
$errors = [];
$editData = null;

// HANDLE FORM SUBMISSION
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST["action"] ?? "";

    $data = [
        "first_name" => trim($_POST["first_name"] ?? ""),
        "middle_name" => trim($_POST["middle_name"] ?? ""),
        "last_name" => trim($_POST["last_name"] ?? ""),
        "age" => trim($_POST["age"] ?? ""),
        "gender" => trim($_POST["gender"] ?? ""),
        "address" => trim($_POST["address"] ?? ""),
        "position" => trim($_POST["position"] ?? ""),
        "salary" => trim($_POST["salary"] ?? "")
    ];

    if ($action == "add") {

        $errors = $controller->store($data);

    } elseif ($action == "update") {

        $id = (int)($_POST["id"] ?? 0);

        $errors = $controller->update($id, $data);
    }

    // KEEP FORM DATA IF VALIDATION FAILS
    if (!empty($errors)) {
        $editData = $data;

        if ($action == "update") {
            $editData["id"] = (int)($_POST["id"] ?? 0);
        }
    }
}

// DELETE FACULTY
if (isset($_GET["delete"])) {

    $controller->destroy((int)$_GET["delete"]);
}

// LOAD EDIT DATA
if (isset($_GET["edit"]) && empty($editData)) {

    $editData = $controller->edit((int)$_GET["edit"]);
}

// DISPLAY ALL FACULTY
$facultyList = $controller->index();

// LOAD VIEW
require "views/faculty/index.php";

?>
