<?php
$dbFile = __DIR__ . '/../database/database.sqlite';
if (! file_exists($dbFile)) {
    echo "Database file not found: $dbFile\n";
    exit(1);
}
$db = new PDO('sqlite:' . $dbFile);
$res = $db->query("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name");
foreach ($res as $row) {
    echo $row['name'] . PHP_EOL;
}

