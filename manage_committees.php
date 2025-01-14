<?php
$conn = new mysqli("localhost", "root", "root", "college",3307);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $name = $conn->real_escape_string($_POST['name']);
        $conn->query("INSERT INTO committees (name) VALUES ('$name')");
    } elseif (isset($_POST['delete'])) {
        $id = (int)$_POST['id'];
        $conn->query("DELETE FROM committees WHERE id = $id");
    }


    
    //Redirect to avoid resubmission
    header("Location:manage_committees.php");
    exit();
}

// Fetch committees
$committees = $conn->query("SELECT * FROM committees");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Committees</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>Manage Committees</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Committee Name" required>
        <button type="submit" name="add">Add Committee</button>
    </form>
    <h3>Existing Committees</h3>
    <ul>
        <?php while ($committee = $committees->fetch_assoc()): ?>
            <li>
                <?= htmlspecialchars($committee['name']) ?>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $committee['id'] ?>">
                    <button type="submit" name="delete">Delete</button>
                </form>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
