<?php
/**
 * safepay_verify_diag.php
 *
 * Upload this to your site root and open it in the browser. It fetches the
 * MOST RECENT tracker from your `payments` table and calls fetchTracker()
 * on it directly, printing the exact raw response — the real error instead
 * of guessing. Delete this file once you're done debugging.
 */
header('Content-Type: text/plain');
include "db.php";
require_once __DIR__ . '/safepay/SafepayClient.php';

$sfpyConfig = require __DIR__ . '/safepay/config.php';
$safepay    = new SafepayClient($sfpyConfig);

$res = mysqli_query($conn, "SELECT tracker_token, status, created_at FROM payments ORDER BY id DESC LIMIT 1");
$row = $res ? mysqli_fetch_assoc($res) : null;

if (!$row) {
    echo "No rows in payments table yet.\n";
    exit;
}

echo "Most recent tracker: {$row['tracker_token']}\n";
echo "Stored status: {$row['status']}\n";
echo "Created at: {$row['created_at']}\n";
echo "\n--- Calling fetchTracker() now ---\n\n";

$statusResp = $safepay->fetchTracker($row['tracker_token']);

echo "ok: "        . var_export($statusResp['ok'], true) . "\n";
echo "http_code: " . var_export($statusResp['http_code'], true) . "\n";
echo "error: "      . var_export($statusResp['error'], true) . "\n";
echo "\nraw response body:\n";
echo $statusResp['raw'] ?? '(null)';
echo "\n\ndecoded data:\n";
print_r($statusResp['data']);
