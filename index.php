<?php
header('Location: cv.pdf');
if (file_exists(__DIR__ . $_SERVER['REQUEST_URI']) && !is_dir(__DIR__ . $_SERVER['REQUEST_URI'])) {
    return false; // Dit au serveur PHP de servir le fichier directement
}
