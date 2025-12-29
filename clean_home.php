<?php
// Temporary file to check line count
$file = file_get_contents('views/public/home.php');
$lines = explode("\n", $file);
echo "Total lines: " . count($lines) . "\n";
echo "Last 10 lines:\n";
for ($i = max(0, count($lines) - 10); $i < count($lines); $i++) {
    echo ($i + 1) . ": " . $lines[$i] . "\n";
}
?>

