<?php
//header('Location: cv.pdf');
$filepath = getenv('MEDIA_PATH').'/cv.pdf';
$fh = @fopen($filepath, 'rb');          // @ : évite que le warning PHP s'affiche
if ($fh === false) {
    error_log("CV illisible : $filepath");   // détail dans les logs seulement
    http_response_code(500);
    exit('Service indisponible.');       // message générique
}

header('Content-Description: File Transfer');
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="cv.pdf"');
header('Content-Length: ' . fstat($fh)['size']);

fpassthru($fh);
fclose($fh);
