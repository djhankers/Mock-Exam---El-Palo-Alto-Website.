<!DOCTYPE html>
<html>
<head>
    <title>Menu</title>
    <style>
        .menu-item {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px;
            width: 300px;
        }
    </style>
</head>
<body>

<h1>Our Menu</h1>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='menu-item'>";
        echo "<h3>{$row['name']}</h3>";
        echo "<p>{$row['description']}</p>";
        echo "<strong>$ {$row['price']}</strong>";
        echo "<p><em>{$row['category']}</em></p>";
        echo "</div>";
    }
} else {
    echo "No menu items found.";
}
?>

</body>
</html>
