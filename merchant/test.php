<?php
echo "PHP is working!<br>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Current Directory: " . getcwd() . "<br>";

// Test database connection
try {
    $db = new SQLite3('./database/database.sqlite');
    echo "Database connection: SUCCESS<br>";
    
    // Test query
    $result = $db->query("SELECT COUNT(*) as count FROM dealers");
    $row = $result->fetchArray();
    echo "Dealers in database: " . $row['count'] . "<br>";
    
} catch (Exception $e) {
    echo "Database error: " . $e->getMessage() . "<br>";
}

// Test Laravel autoloader
try {
    require_once './vendor/autoload.php';
    echo "Laravel autoloader: SUCCESS<br>";
} catch (Exception $e) {
    echo "Laravel autoloader error: " . $e->getMessage() . "<br>";
}
?>


