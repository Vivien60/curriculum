<?php
// Envoie le PDF au navigateur. Retourne false, sans rien avoir envoyé, si le fichier est illisible.
return static function ($file): void {
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="cv.pdf"');
    header('Content-Length: ' . $file->fstat()['size']);
    $file->fpassthru();
};  // le fichier est fermé quand $file est détruit, pas de fclose
