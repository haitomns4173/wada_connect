<?php
require_once('../assets/extensions/fpdf/autoload.php');  // Ensure you have autoloaded Composer dependencies

use setasign\Fpdi\Fpdi;

function addTextToTopOfPdf($inputPath, $outputPath, $text)
{
    $pdf = new Fpdi();

    // Set the source PDF file
    $pdf->setSourceFile($inputPath);

    // Import the first page (or loop for all pages)
    $templateId = $pdf->importPage(1);  // Import page 1
    $pdf->addPage();
    $pdf->useTemplate($templateId);

    // Set font and text position for the new line
    $pdf->SetFont('Arial', 'B', 12);  // Bold font with size 12
    $pdf->SetXY(10, 10);  // Position text 10 units from the top left

    // Add the text
    $pdf->Cell(0, 10, $text, 0, 1, 'L');  // Adjust text and position as needed

    // Output the modified PDF to a file
    $pdf->Output('F', $outputPath);  // Save to specified output file
}
?>
