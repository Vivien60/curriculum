<?php
// Template de la page de défi : retourne une fonction, donc son scope est isolé de l'appelant.
return static function (string $siteKey, ?string $message): string {
    $key = htmlspecialchars($siteKey, ENT_QUOTES);
    $msg = $message !== null ? '<p>' . htmlspecialchars($message) . '</p>' : '';

    return <<<HTML
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vérification</title>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
</head>
<body>
<h1>Vérification de sécurité en cours</h1>
<p>Ce site utilise un service de sécurité pour se protéger contre les robots malveillants. Cette page s'affiche pendant que la vérification a lieu, merci de patienter quelques instants.</p>
$msg
<form id="challenge" method="post">
    <div class="cf-turnstile" data-sitekey="$key" data-callback="onVerified"></div>
    <noscript>JavaScript est nécessaire pour afficher le CV.</noscript>
</form>
<script>function onVerified() { document.getElementById('challenge').submit(); }</script>
</body>
</html>
HTML;
};