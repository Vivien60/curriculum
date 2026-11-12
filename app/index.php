<?php
//header('Location: cv.pdf');
$filepath = getenv('CV_PDF_PATH');
header('Content-Description: File Transfer');
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="cv.pdf"');
header('Content-Length: ' . filesize($filepath));

$fh = fopen($filepath, 'r');
if(!$fh) {
    return false;
}
while ($line = fgets($fh)) {
    echo $line;
}
fclose($fh);
