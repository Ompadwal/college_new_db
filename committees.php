<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "root", "college",3307);

// Fetch committees and their documents
$committees = $conn->query("SELECT * FROM committees");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Committees</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div id="sidebar">
        <h2>Committees</h2>
        <?php while ($committee = $committees->fetch_assoc()): ?>
            <div class="committee" onclick="showContent('committee<?= $committee['id'] ?>')">
                <?= htmlspecialchars($committee['name']) ?>
            </div>
        <?php endwhile; ?>
    </div>

    <div id="content">
        <?php
        $committees = $conn->query("SELECT * FROM committees");
        while ($committee = $committees->fetch_assoc()):
        ?>
            <div id="committee<?= $committee['id'] ?>" class="committee-content">
                <h2><?= htmlspecialchars($committee['name']) ?></h2>
                <?php
                $documents = $conn->query("SELECT * FROM documents WHERE committee_id = {$committee['id']}");
                while ($document = $documents->fetch_assoc()):
                ?>
                    <div class="report">
                        <span><?= htmlspecialchars($document['name']) ?></span>
                        <a href="uploads/<?= htmlspecialchars($document['path']) ?>" class="download-btn" download>DOWNLOAD</a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endwhile; ?>
    </div>

    <script src="assets/script.js"></script>
</body>
</html>
