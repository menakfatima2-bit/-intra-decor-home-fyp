<?php
/**
 * Optional: register this URL in your Safepay Dashboard -> Developers -> Endpoints
 *   https://yourdomain.infinityfreeapp.com/safepay_webhook.php
 *
 * This is a good thing to demo separately in your FYP viva: unlike the
 * server-to-server calls your PHP makes OUT to Safepay (which can be
 * affected by hosting restrictions), this endpoint only receives INBOUND
 * requests from Safepay, which works fine even on restrictive free hosts.
 *
 * This does not replace safepay_return.php (which is what actually places
 * the order the shopper sees) — it's an audit trail / async safety net.
 */

include "db.php";
require_once __DIR__ . '/safepay/SafepayClient.php';

$sfpyConfig = require __DIR__ . '/safepay/config.php';
$safepay    = new SafepayClient($sfpyConfig);

$rawBody   = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_SFPY_SIGNATURE'] ?? '';

if (!$safepay->verifyWebhook($rawBody, $signature)) {
    http_response_code(400);
    error_log('[Safepay Webhook] invalid signature');
    echo 'invalid signature';
    exit();
}

$event = json_decode($rawBody, true);
$tracker = $event['data']['tracker'] ?? ($event['tracker'] ?? null);
$type    = $event['type'] ?? 'unknown';

if ($tracker) {
    $tok_esc = mysqli_real_escape_string($conn, $tracker);
    $raw_esc = mysqli_real_escape_string($conn, $rawBody);
    $status  = (strpos($type, 'succeeded') !== false) ? 'paid'
             : ((strpos($type, 'failed') !== false) ? 'failed' : 'webhook_seen');

    mysqli_query($conn, "UPDATE payments SET status='$status', raw_response='$raw_esc' WHERE tracker_token='$tok_esc'");
}

http_response_code(200);
echo 'ok';
