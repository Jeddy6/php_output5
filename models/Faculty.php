
<?php

class Faculty {

    private $conn;
    private $table = "faculty";

    public function __construct($db) {
        $this->conn = $db;
    }

    // DISPLAY ALL FACULTY
    public function getAll() {

        $sql = "SELECT * FROM " . $this->table . " ORDER BY id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ADD FACULTY
    public function add($data) {

        $sql = "INSERT INTO faculty
                (first_name, middle_name, last_name,
                 age, gender, address, position, salary)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $data["first_name"],
            $data["middle_name"],
            $data["last_name"],
            $data["age"],
            $data["gender"],
            $data["address"],
            $data["position"],
            $data["salary"]
        ]);
    }

    // GET ONE FACULTY
    public function getById($id) {

        $sql = "SELECT * FROM faculty WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE FACULTY
    public function update($id, $data) {

        $sql = "UPDATE faculty SET
                first_name = ?,
                middle_name = ?,
                last_name = ?,
                age = ?,
                gender = ?,
                address = ?,
                position = ?,
                salary = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $data["first_name"],
            $data["middle_name"],
            $data["last_name"],
            $data["age"],
            $data["gender"],
            $data["address"],
            $data["position"],
            $data["salary"],
            $id
        ]);
    }

    // DELETE FACULTY
    public function delete($id) {

        $sql = "DELETE FROM faculty WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}

?>
