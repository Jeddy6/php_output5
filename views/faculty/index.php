
<?php

function escape($value) {
    return htmlspecialchars($value ?? "", ENT_QUOTES, "UTF-8");
}

$isEditing = !empty($editData);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Faculty Management System</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <div class="header">
        <h1>Faculty Management System</h1>
        <p>Manage faculty information and records</p>
    </div>

    <div class="form-card">

        <h2>
            <?php echo $isEditing ? "Update Faculty" : "Add New Faculty"; ?>
        </h2>

        <?php if (!empty($errors)): ?>

            <div class="error-box">
                <strong>Please correct the following:</strong>

                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo escape($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

        <?php endif; ?>

        <?php if (isset($_GET["success"])): ?>
            <div class="success-box">
                Faculty successfully added!
            </div>
        <?php endif; ?>

        <?php if (isset($_GET["updated"])): ?>
            <div class="success-box">
                Faculty information successfully updated!
            </div>
        <?php endif; ?>

        <?php if (isset($_GET["deleted"])): ?>
            <div class="success-box">
                Faculty record successfully deleted!
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php">

            <input type="hidden" name="action"
                value="<?php echo $isEditing ? "update" : "add"; ?>">

            <?php if ($isEditing): ?>

                <input type="hidden" name="id"
                    value="<?php echo escape($editData["id"] ?? ""); ?>">

            <?php endif; ?>

            <div class="grid">

                <div class="input-group">
                    <label>First Name *</label>
                    <input type="text" name="first_name"
                        value="<?php echo escape($editData["first_name"] ?? ""); ?>"
                        maxlength="100" required>
                </div>

                <div class="input-group">
                    <label>Middle Name</label>
                    <input type="text" name="middle_name"
                        value="<?php echo escape($editData["middle_name"] ?? ""); ?>"
                        maxlength="100">
                </div>

                <div class="input-group">
                    <label>Last Name *</label>
                    <input type="text" name="last_name"
                        value="<?php echo escape($editData["last_name"] ?? ""); ?>"
                        maxlength="100" required>
                </div>

                <div class="input-group">
                    <label>Age *</label>
                    <input type="number" name="age"
                        value="<?php echo escape($editData["age"] ?? ""); ?>"
                        min="1" max="120" step="1" required>
                </div>

                <div class="input-group">
                    <label>Gender *</label>

                    <select name="gender" required>

                        <option value="">Select Gender</option>

                        <option value="Male"
                            <?php if (($editData["gender"] ?? "") == "Male") echo "selected"; ?>>
                            Male
                        </option>

                        <option value="Female"
                            <?php if (($editData["gender"] ?? "") == "Female") echo "selected"; ?>>
                            Female
                        </option>

                    </select>
                </div>

                <div class="input-group">
                    <label>Position *</label>
                    <input type="text" name="position"
                        value="<?php echo escape($editData["position"] ?? ""); ?>"
                        maxlength="100" required>
                </div>

                <div class="input-group">
                    <label>Salary *</label>
                    <input type="number" name="salary"
                        value="<?php echo escape($editData["salary"] ?? ""); ?>"
                        min="0" max="99999999.99"
                        step="0.01" required>
                </div>

                <div class="input-group full">
                    <label>Address *</label>
                    <textarea name="address" required><?php echo escape($editData["address"] ?? ""); ?></textarea>
                </div>

            </div>

            <button type="submit" class="submit-btn">
                <?php echo $isEditing ? "Update Faculty" : "Add Faculty"; ?>
            </button>

            <?php if ($isEditing): ?>

                <a href="index.php" class="cancel-btn">
                    Cancel Editing
                </a>

            <?php endif; ?>

        </form>

    </div>

    <div class="table-card">

        <h2>Faculty Records</h2>

        <p class="record-count">
            Total Faculty: <?php echo count($facultyList); ?>
        </p>

        <?php if (!empty($facultyList)): ?>

            <div class="table-container">

                <table>

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Position</th>
                            <th>Salary</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($facultyList as $faculty): ?>

                            <tr>

                                <td><?php echo escape($faculty["id"]); ?></td>

                                <td>
                                    <?php echo escape(
                                        $faculty["first_name"] . " " .
                                        $faculty["middle_name"] . " " .
                                        $faculty["last_name"]
                                    ); ?>
                                </td>

                                <td><?php echo escape($faculty["age"]); ?></td>

                                <td><?php echo escape($faculty["gender"]); ?></td>

                                <td><?php echo escape($faculty["address"]); ?></td>

                                <td><?php echo escape($faculty["position"]); ?></td>

                                <td>
                                    ₱<?php echo number_format(
                                        (float)$faculty["salary"], 2
                                    ); ?>
                                </td>

                                <td class="actions">

                                    <a class="edit-btn"
                                        href="index.php?edit=<?php echo $faculty["id"]; ?>">
                                        Edit
                                    </a>

                                    <a class="delete-btn"
                                        href="index.php?delete=<?php echo $faculty["id"]; ?>"
                                        onclick="return confirm('Are you sure you want to delete this faculty?');">
                                        Delete
                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php else: ?>

            <div class="empty-state">
                No faculty records available.
            </div>

        <?php endif; ?>

    </div>

</div>

</body>
</html>
