<?php
session_start();
require "connection.php"; // Include your database connection here
require_once 'vendor/autoload.php';

use Google\Client;
use Google\Service\Drive;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$adminEmail = $_POST['Email'];
$adminPassword = $_POST['Pass'];

$query = Database::search("SELECT * FROM users WHERE email = '$adminEmail'");

if ($query->num_rows == 1) {
    $admin_data = $query->fetch_assoc();
    $hashedPasswordFromDatabase = $admin_data['password'];

    if (password_verify($adminPassword, $hashedPasswordFromDatabase)) {
        // Define the backup file name and path
        $backupFileName = 'backup.sql';
        $backupFilePath = './backup/' . $backupFileName;

        // Define a function to generate the SQL backup
        function generateSQLBackup($backupFilePath, $db) {
            $sql = "-- SQL Backup CakeHub.inc Systems 2023 --\n";

            $sql .= "CREATE DATABASE IF NOT EXISTS `cakehub`;\n";
            $sql .= "USE `cakehub`;\n";
            // Retrieve a list of tables in the database
            $tables = $db->search('SHOW TABLES');
            while ($row = $tables->fetch_assoc()) {
                $tableName = $row['Tables_in_cakehub']; // Adjust the database name
                $sql .= "-- Table structure for table `$tableName`\n";
                
                // Retrieve the table schema
                $schema = $db->search("SHOW CREATE TABLE `$tableName`");
                $row = $schema->fetch_assoc();
                $sql .= $row['Create Table'] . ";\n\n";

                // Retrieve data from the table and insert it into the SQL dump
                $result = $db->search("SELECT * FROM `$tableName`");

                while ($row = $result->fetch_assoc()) {
                    $sql .= "INSERT INTO `$tableName` (";

                    // Extract column names
                    $columns = implode('`, `', array_keys($row));
                    $sql .= "`$columns`) VALUES (";

                    // Build the values to insert
                    $values = [];
                    foreach ($row as $value) {
                        $values[] = "'" . $db::$connection->real_escape_string($value) . "'";
                    }

                    $sql .= implode(', ', $values) . ");\n";
                }

                $sql .= "\n";
            }

            // Write the SQL dump to the backup file
            file_put_contents($backupFilePath, $sql);
        }
        $db = new Database();

        generateSQLBackup($backupFilePath, $db);

        // Check if the backup file was created successfully
        if (file_exists($backupFilePath)) {
            // Continue with the Google Drive upload
            try {
                $client = new Client();
                $client->useApplicationDefaultCredentials();
                $client->setAccessType('offline'); // Add this line
                $client->setApprovalPrompt('force'); // Add this line
                $client->setScopes([Drive::DRIVE]);
                $client->setAuthConfig([
                    'type' => $_ENV['GOOGLE_SERVICE_ACCOUNT_TYPE'],
                    'project_id' => $_ENV['GOOGLE_SERVICE_ACCOUNT_PROJECT_ID'],
                    'private_key_id' => $_ENV['GOOGLE_SERVICE_ACCOUNT_PRIVATE_KEY_ID'],
                    'private_key' => $_ENV['GOOGLE_SERVICE_ACCOUNT_PRIVATE_KEY'],
                    'client_email' => $_ENV['GOOGLE_SERVICE_ACCOUNT_CLIENT_EMAIL'],
                    'client_id' => $_ENV['GOOGLE_SERVICE_ACCOUNT_CLIENT_ID'],
                    'auth_uri' => $_ENV['GOOGLE_SERVICE_ACCOUNT_AUTH_URI'],
                    'token_uri' => $_ENV['GOOGLE_SERVICE_ACCOUNT_TOKEN_URI'],
                    'auth_provider_x509_cert_url' => $_ENV['GOOGLE_SERVICE_ACCOUNT_AUTH_PROVIDER_X509_CERT_URL'],
                    'client_x509_cert_url' => $_ENV['GOOGLE_SERVICE_ACCOUNT_CLIENT_X509_CERT_URL'],
                    'universe_domain' => $_ENV['GOOGLE_SERVICE_UNIVERSE_DOMAIN'],
                ]);       
                $driveService = new Drive($client);
                $fileName = basename($backupFilePath);
                $mimeType = 'application/octet-stream'; // Set the correct MIME type for SQL files
                $fileMetadata = new Drive\DriveFile([
                    'name' => $fileName,
                    'parents' => [$_ENV['GOOGLE_DRIVE_PARENT_FOLDER_ID']]
                ]);                
                $content = file_get_contents($backupFilePath);
                $file = $driveService->files->create($fileMetadata, [
                    'data' => $content,
                    'mimeType' => $mimeType,
                    'uploadType' => 'multipart'
                ]);
                printf("File ID: %s\n", $file->id);

                // Clear the SQL backup file from local storage
                if (unlink($backupFilePath)) {
                    echo "Local SQL backup file deleted successfully.";
                } else {
                    echo "Error deleting local SQL backup file.";
                }

                echo "OK";
            } catch (Exception $e) {
                echo "Error Message: " . $e->getMessage();
            }
        } else {
            echo "Error creating SQL backup file.";
        }
    } else {
        echo "InvalidAdminPassword";
    }
} else {
    echo "NotAdmin";
}
?>
