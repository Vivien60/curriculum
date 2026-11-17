<?php
require_once 'src/turnstile.php';
require_once 'src/utils.php';
require_once 'src/errorHandler.php';
$renderError = require 'templates/error.php';

$siteKey = getenv('BOT_CHECK_SITE_KEY');
$secret = readSecret('bot_check_secret');

if (!canMakeBotChallenge($siteKey, $secret)) {
    $renderError(500, 'Service indisponible');
    fail(500, 'BOT_CHECK_SITE_KEY non défini ou secret bot_check_secret illisible');
}

// 1re visite : on affiche le défi, sans envoyer le PDF
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo renderChallenge($siteKey);
    exit;
}

// Soumission : le jeton doit être valide
if (!verifyChallenge($secret)) {
    http_response_code(403);
    echo renderChallenge($siteKey, 'Vérification échouée, veuillez réessayer.');
    exit;
}

$displayPdf = require 'templates/pdf.inc.php';
try {
    $file = new SplFileObject(getenv('MEDIA_PATH') . '/cv.pdf', 'rb');
    $displayPdf($file);
} catch (RuntimeException $e) {
    $renderError(500, "Erreur lors de l'affichage du PDF");
    fail(500, "Erreur lors de l'affichage du PDF");
}
