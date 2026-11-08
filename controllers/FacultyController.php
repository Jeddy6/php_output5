
<?php

class FacultyController {

    private $faculty;

    public function __construct($model) {
        $this->faculty = $model;
    }

    // VALIDATE INPUT
    private function validate($data) {

        $errors = [];

        if ($data["first_name"] == "") {
            $errors[] = "First name is required.";
        }

        if ($data["last_name"] == "") {
            $errors[] = "Last name is required.";
        }

        if (!ctype_digit($data["age"]) ||
            (int)$data["age"] < 1 ||
            (int)$data["age"] > 120) {

            $errors[] = "Age must be between 1 and 120.";
        }

        if (!in_array($data["gender"], ["Male", "Female"])) {
            $errors[] = "Please select a valid gender.";
        }

        if ($data["address"] == "") {
            $errors[] = "Address is required.";
        }

        if ($data["position"] == "") {
            $errors[] = "Position is required.";
        }

        if (!is_numeric($data["salary"]) ||
            $data["salary"] < 0 ||
            $data["salary"] > 99999999.99) {

            $errors[] = "Please enter a valid salary.";
        }

        return $errors;
    }

    // GET ALL FACULTY
    public function index() {
        return $this->faculty->getAll();
    }

    // ADD FACULTY
    public function store($data) {

        $errors = $this->validate($data);

        if (!empty($errors)) {
            return $errors;
        }

        $this->faculty->add($data);

        header("Location: index.php?success=1");
        exit;
    }

    // GET FACULTY FOR EDITING
    public function edit($id) {
        return $this->faculty->getById($id);
    }

    // UPDATE FACULTY
    public function update($id, $data) {

        $errors = $this->validate($data);

        if (!empty($errors)) {
            return $errors;
        }

        $this->faculty->update($id, $data);

        header("Location: index.php?updated=1");
        exit;
    }

    // DELETE FACULTY
    public function destroy($id) {

        $this->faculty->delete($id);

        header("Location: index.php?deleted=1");
        exit;
    }
}

?>
