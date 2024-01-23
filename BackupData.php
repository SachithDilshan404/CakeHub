<?php 
session_start();
require "connection.php";
require "tcpdf.php";

$adminEmail = $_POST['email'];
$adminPassword = $_POST['Pass'];

$query = Database::search("SELECT * FROM users WHERE email = '$adminEmail'");

if ($query->num_rows == 1) {
    $admin_data = $query->fetch_assoc();
    $hashedPasswordFromDatabase = $admin_data['password'];

    if (password_verify($adminPassword, $hashedPasswordFromDatabase)) {

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        $pdf->SetCreator('Your Application');
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Database Backup');
        $pdf->SetSubject('Database Backup');
        $pdf->SetKeywords('Database, Backup');

        // Add a page
        $pdf->AddPage();

        // The connection to the database is already established via "connection.php"
        
        $tablesQuery = Database::search("SHOW TABLES");
        $tableNames = array();

        while ($row = $tablesQuery->fetch_assoc()) {
            $tableNames[] = $row['Tables_in_cakehub'];
        }

        foreach ($tableNames as $tableName) {
            // Enclose the table name in backticks to handle reserved words
            $dataQuery = Database::search("SELECT * FROM `$tableName`");

            // Add a table title
            $pdf->SetFont('times', 'B', 14);
            $pdf->Cell(0, 10, "Table: {$tableName}", 0, 1);

            // Add table data to the PDF
            $pdf->SetFont('times', '', 12);
            while ($row = $dataQuery->fetch_assoc()) {
                foreach ($row as $key => $value) {
                    // Format the data as needed (e.g., adjust column width, alignment)
                    $pdf->Cell(40, 10, $key, 1);
                    $pdf->Cell(60, 10, $value, 1);
                    $pdf->Ln();
                }
            }

            // Add spacing between tables
            $pdf->Ln(10);
        }

        // Generate the PDF content
        $pdfContent = $pdf->Output('database_backup.pdf', 'S');

        // Provide the PDF file for download
        header('Content-Type: application/pdf');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"database_backup.pdf\"");
        echo $pdfContent;

        
    } else {
        echo "InvalidAdminPassword";
    }
} else {
    echo "NotAdmin";
}
?>
