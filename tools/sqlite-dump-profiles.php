<?php
$dbFile = __DIR__ . '/../database/database.sqlite';
if (! file_exists($dbFile)) {
    echo "Database file not found: $dbFile\n";
    exit(1);
}
$db = new PDO('sqlite:' . $dbFile);
// show schema of profiles
echo "profiles table schema:\n";
$res = $db->query("PRAGMA table_info('profiles')");
foreach ($res as $row) {
    echo $row['cid'] . " \t " . $row['name'] . " \t " . $row['type'] . " \t notnull:" . $row['notnull'] . " default:" . $row['dflt_value'] . "\n";
}

echo "\nusers table schema:\n";
$res = $db->query("PRAGMA table_info('users')");
foreach ($res as $row) {
    echo $row['cid'] . " \t " . $row['name'] . " \t " . $row['type'] . " \t notnull:" . $row['notnull'] . " default:" . $row['dflt_value'] . "\n";
}

echo "\nJoined sample rows (profiles LEFT JOIN users):\n";
$res = $db->query("SELECT p.id as pid, p.user_id, p.username, p.display_name, p.avatar_path, p.birthday, p.bio, u.id as uid, u.name, u.email FROM profiles p LEFT JOIN users u ON p.user_id = u.id ORDER BY p.id DESC LIMIT 20");
foreach ($res as $row) {
    echo json_encode($row) . PHP_EOL;
}

