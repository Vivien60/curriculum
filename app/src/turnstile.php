<?php
// Implémentation Cloudflare Turnstile de la vérification anti-robot.
// Seul ce fichier (et son template) connaît le fournisseur : index.php n'appelle
// que verifyChallenge() et renderChallenge().

const TURNSTILE_VERIFY_URL = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';


/**
 * @param false|array|string $siteKey
 * @param string|null $secret
 * @return bool
 */
function canMakeBotChallenge(false|array|string $siteKey, ?string $secret): bool
{
    return !empty($siteKey) && $secret !== null;
}

/** Vérifie auprès de Cloudflare le jeton soumis avec le formulaire. */
function verifyChallenge(string $secret): bool
{
    $token = (string)($_POST['cf-turnstile-response'] ?? '');
    if ($token === '' || strlen($token) > 2048) {
        return false;
    }

    $ch = curl_init(TURNSTILE_VERIFY_URL);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 3,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_POSTFIELDS => http_build_query(['secret' => $secret, 'response' => $token]),
    ]);
    $body = curl_exec($ch);
    if ($body === false) {
        error_log('Turnstile injoignable : ' . curl_error($ch));
        return false;
    }

    $result = json_decode($body, true);
    return is_array($result) && ($result['success'] ?? false) === true;
}

/** Page du défi : le widget se valide seul, puis le formulaire est soumis automatiquement. */
function renderChallenge(string $siteKey, ?string $message = null): string
{
    header('Cache-Control: no-store');
    $template = require 'templates/turnstile-challenge.inc.php';
    return $template($siteKey, $message);
}
