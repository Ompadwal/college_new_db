<?php
$conn = new mysqli("localhost", "root", "root", "college",3307);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $committee_id = (int)$_POST['committee_id'];
        $name = $conn->real_escape_string($_POST['name']);
        $file = $_FILES['file'];
        $path = $file['name'];
        move_uploaded_file($file['tmp_name'], "uploads/$path");
        $conn->query("INSERT INTO documents (committee_id, name, path) VALUES ($committee_id, '$name', '$path')");
    } elseif (isset($_POST['delete'])) {
        $id = (int)$_POST['id'];
        $conn->query("DELETE FROM documents WHERE id = $id");
    }


    //Redirect to avoid resubmission
    header("Location:manage_committees.php");
    exit();
}



// Fetch committees and documents
$committees = $conn->query("SELECT * FROM committees");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Documents</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>Manage Documents</h2>
    <form method="POST" enctype="multipart/form-data">
        <select name="committee_id" required>
            <option value="">Select Committee</option>
            <?php while ($committee = $committees->fetch_assoc()): ?>
                <option value="<?= $committee['id'] ?>"><?= htmlspecialchars($committee['name']) ?></option>
            <?php endwhile; ?>
        </select>
        <input type="text" name="name" placeholder="Document Name" required>
        <input type="file" name="file" required>
        <button type="submit" name="add">Add Document</button>
    </form>

    <h3>Existing Documents</h3>
    <ul>
        <?php
        $documents = $conn->query("SELECT documents.*, committees.name AS committee_name FROM documents JOIN committees ON documents.committee_id = committees.id");
        while ($document = $documents->fetch_assoc()):
        ?>
            <li>
                <?= htmlspecialchars($document['name']) ?> (<?= htmlspecialchars($document['committee_name']) ?>)
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $document['id'] ?>">
                    <button type="submit" name="delete">Delete</button>
                </form>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>

