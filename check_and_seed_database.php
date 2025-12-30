<?php
/**
 * Script to check database connection and seed data if needed
 */

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Database Check & Seed</title>";
echo "<style>body{font-family:Arial;padding:20px;max-width:800px;margin:0 auto;} .success{color:green;} .error{color:red;} .warning{color:orange;} .info{color:blue;}</style>";
echo "</head><body>";
echo "<h1>Database Check & Seed</h1>";
echo "<hr>";

// Load database config
$config = require __DIR__ . '/config/database.php';

try {
    // Connect to MySQL
    $pdo = new PDO(
        'mysql:host=' . $config['host'] . ';charset=' . $config['charset'],
        $config['username'],
        $config['password']
    );

    echo "<p class='success'>✓ Database connection successful</p>";

    // Check if database exists
    $stmt = $pdo->query("SHOW DATABASES LIKE '{$config['database']}'");
    $dbExists = $stmt->fetch();

    if (!$dbExists) {
        echo "<p class='error'>✗ Database '{$config['database']}' does not exist</p>";
        echo "<p class='info'>Please create the database first:</p>";
        echo "<pre style='background:#f0f0f0;padding:10px;border-radius:5px;'>CREATE DATABASE {$config['database']} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;</pre>";
        echo "<p>Or run the setup script: <a href='setup_database.php'>Setup Database</a></p>";
        exit;
    }

    echo "<p class='success'>✓ Database '{$config['database']}' exists</p>";

    // Connect to the specific database
    $pdo->exec("USE {$config['database']}");

    // Check if posts table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'posts'");
    $tableExists = $stmt->fetch();

    if (!$tableExists) {
        echo "<p class='warning'>⚠ Posts table does not exist</p>";
        echo "<p class='info'>Please run the database setup first:</p>";
        echo "<pre style='background:#f0f0f0;padding:10px;border-radius:5px;'>mysql -u root -p {$config['database']} < database.sql</pre>";
        echo "<p>Or run the setup script: <a href='setup_database.php'>Setup Database</a></p>";
        exit;
    }

    echo "<p class='success'>✓ Posts table exists</p>";

    // Check if posts exist
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM posts");
    $result = $stmt->fetch();
    $postCount = $result['count'];

    echo "<p class='info'>Current posts count: {$postCount}</p>";

    if ($postCount == 0) {
        echo "<p class='warning'>⚠ No posts found. Running seed data...</p>";

        // Read and execute seed data
        $seedFile = __DIR__ . '/seed_data.sql';
        if (file_exists($seedFile)) {
            $seedContent = file_get_contents($seedFile);

            // Split into individual statements
            $statements = array_filter(array_map('trim', explode(';', $seedContent)));

            $successCount = 0;
            $errorCount = 0;

            foreach ($statements as $statement) {
                if (!empty($statement) && !preg_match('/^--/', $statement)) {
                    try {
                        $pdo->exec($statement);
                        $successCount++;
                    } catch (Exception $e) {
                        echo "<p class='error'>Error executing: " . substr($statement, 0, 50) . "... - " . $e->getMessage() . "</p>";
                        $errorCount++;
                    }
                }
            }

            echo "<p class='success'>✓ Seed data executed: {$successCount} statements successful";
            if ($errorCount > 0) {
                echo ", {$errorCount} errors";
            }
            echo "</p>";

            // Check posts again
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM posts");
            $result = $stmt->fetch();
            $newPostCount = $result['count'];
            echo "<p class='success'>✓ Posts after seeding: {$newPostCount}</p>";

        } else {
            echo "<p class='error'>✗ Seed file not found: {$seedFile}</p>";
        }

    } else {
        echo "<p class='success'>✓ Posts already exist ({$postCount} posts)</p>";

        // Show recent posts
        $stmt = $pdo->query("SELECT id, title FROM posts ORDER BY id DESC LIMIT 5");
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<p class='info'>Recent posts:</p>";
        echo "<ul>";
        foreach ($posts as $post) {
            echo "<li>ID {$post['id']}: {$post['title']}</li>";
        }
        echo "</ul>";
    }

    echo "<hr>";
    echo "<h2 class='success'>✓ Database Ready!</h2>";
    echo "<p>The dashboard should now work properly.</p>";
    echo "<p><a href='index.php'>Go to Website</a> | <a href='admin/login'>Admin Login</a></p>";

} catch (Exception $e) {
    echo "<p class='error'>✗ Database error: " . $e->getMessage() . "</p>";
    echo "<p class='info'>Make sure MySQL is running and credentials are correct.</p>";
    echo "<p>Check XAMPP control panel and start MySQL service.</p>";
}

echo "</body></html>";
?>
