<?php
// Start output buffering to prevent any accidental output
ob_start();

// Include configuration file (ensure this file does not output anything)
include("php/db_config.php");

// Include the FPDF library
require 'fpdf/fpdf.php';

// Create a new FPDF instance and set up the page
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

// Set the font for the header
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(277, 7, 'LAPORAN RIP PET SHELL', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(277, 7, 'DAFTAR HEWAN RIP PET SHELL DESEMBER 2024', 0, 1, 'C');

// Add a space below the title
$pdf->Cell(10, 7, '', 0, 1);

// Set font for the table header
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 6, 'ID', 1, 0, 'C');
$pdf->Cell(100, 6, 'NAMA HEWAN', 1, 0, 'C');
$pdf->Cell(150, 6, 'DESKRIPSI', 1, 1, 'C');

// Set font for the table data
$pdf->SetFont('Arial', '', 10);

// Query to fetch data from the database
$query = "SELECT * FROM item_hewan";
$hewan = mysqli_query($conn, $query);

// Check if query was successful
if ($hewan) {
    // Loop through the data and add it to the PDF
    while ($row = mysqli_fetch_array($hewan)) {
        $pdf->Cell(20, 6, $row['id'], 1, 0, 'C');
        $pdf->Cell(100, 6, $row['nama'], 1, 0);
        $pdf->Cell(150, 6, $row['deskripsi'], 1, 1);
    }
} else {
    $pdf->Cell(190, 6, 'No data available', 1, 0, 'C');
}

// End output buffering and clean any output before generating the PDF
ob_end_clean();

// Output the PDF
$pdf->Output();
?>
