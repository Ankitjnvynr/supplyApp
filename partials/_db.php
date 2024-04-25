<?php
function parseEnv($filePath)
{
    $file = fopen($filePath, 'r');
    while (($line = fgets($file)) !== false)
    {
        $line = trim($line);
        if (!empty($line) && strpos($line, '=') !== false)
        {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[$key] = $value;
        }
    }
    fclose($file);
}

// Load the .env file
$root = $_SERVER['DOCUMENT_ROOT'];
parseEnv( $root.'/supplyApp/.env');

// Now you can access your database credentials
$dbHost = $_ENV['DB_HOST'];
$dbUser = $_ENV['DB_USER'];
$dbPass = $_ENV['DB_PASS'];
$dbName = $_ENV['DB_NAME'];

// Use these variables to connect to your database
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $connection->connect_error);
} else
{
    // echo "Connected successfully";
}

?>