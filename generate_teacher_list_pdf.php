<?php
require('fpdf.php');
require 'db_connect.php';

// Start session and check admin login
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}

// Create PDF
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

// Set title
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'Teachers List', 0, 1, 'C');
$pdf->Ln(5);

// Set table headers
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(52, 152, 219); // Blue
$pdf->SetTextColor(255);
$pdf->Cell(20, 10, 'ID', 1, 0, 'C', true);
$pdf->Cell(80, 10, 'Name', 1, 0, 'C', true);
$pdf->Cell(90, 10, 'Email', 1, 1, 'C', true);

// Fetch teacher data
$result = $conn->query("SELECT * FROM teachers");

// Table rows
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0);
while ($teacher = $result->fetch_assoc()) {
    $pdf->Cell(20, 10, $teacher['id'], 1, 0, 'C');
    $pdf->Cell(80, 10, $teacher['name'], 1, 0, 'L');
    $pdf->Cell(90, 10, $teacher['email'], 1, 1, 'L');
}

// Output the PDF
$pdf->Output('D', 'Teachers_List.pdf');
?>
