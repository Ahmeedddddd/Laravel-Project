<?php
$dbFile = __DIR__ . '/../database/database.sqlite';
$db = new PDO('sqlite:' . $dbFile);
$cols = [];
foreach ($db->query("PRAGMA table_info('profiles')") as $c) {
    $cols[] = $c['name'];
}
if (in_array('birthday', $cols)) {
    echo "birthday exists\n";
} else {
    echo "adding birthday column...\n";
    $db->exec("ALTER TABLE profiles ADD COLUMN birthday DATE");
    echo "done\n";
}

foreach ($db->query("PRAGMA table_info('profiles')") as $c) {
    echo $c['cid'] . "\t" . $c['name'] . "\t" . $c['type'] . PHP_EOL;
}

