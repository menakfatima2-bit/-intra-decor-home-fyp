<?php
/**
 * SAFEPAY CONNECTIVITY DIAGNOSTIC
 * --------------------------------
 * Upload this to your site root and open it in the browser, e.g.
 *   https://yourdomain.infinityfreeapp.com/safepay_diag.php
 *
 * It does NOT touch your database or your real config — it just checks
 * whether your InfinityFree account can make an outbound HTTPS request to
 * Safepay's sandbox API. Some free hosts block or throttle this, and if
 * that's the case here, you need to know it BEFORE building the demo
 * around it, not five minutes before your defense.
 *
 * DELETE THIS FILE once you've confirmed things work — no need to leave a
 * public diagnostic endpoint lying around.
 */

header('Content-Type: text/plain');

echo "1) Is the cURL extension available?\n";
if (!function_exists('curl_init')) {
    echo "   NO — curl is not enabled on this hosting account. Stop here and\n";
    echo "   contact InfinityFree support / check your control panel for a way\n";
    echo "   to enable the curl PHP extension.\n";
    exit;
}
echo "   YES\n\n";

echo "2) Can we reach Safepay's sandbox API over HTTPS?\n";

$ch = curl_init('https://sandbox.api.getsafepay.com/order/v1/init');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST  => 'POST',
    CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
    // Intentionally sending a bogus payload — we only care whether the
    // REQUEST reaches Safepay's server at all, not whether it succeeds.
    CURLOPT_POSTFIELDS     => json_encode(['client' => 'diagnostic-test']),
    CURLOPT_TIMEOUT        => 15,
    CURLOPT_CONNECTTIMEOUT => 8,
]);

$body     = curl_exec($ch);
$errno    = curl_errno($ch);
$error    = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($errno) {
    echo "   FAILED — cURL error $errno: $error\n\n";
    echo "   This means outbound requests are being blocked or the DNS/network\n";
    echo "   on this hosting account can't reach getsafepay.com. This is a known\n";
    echo "   issue on some InfinityFree accounts. Options:\n";
    echo "     - Try again in a few minutes (sometimes it's transient)\n";
    echo "     - Ask InfinityFree support to whitelist outbound HTTPS to\n";
    echo "       sandbox.api.getsafepay.com\n";
    echo "     - Move just the payment part to a host that allows outbound\n";
    echo "       requests (Render/Railway free tier, or any real shared host)\n";
    echo "     - As a last resort for your demo, present the flow using the\n";
    echo "       client-side/JS Safepay button instead of the server API\n";
    exit;
}

echo "   Reached the server. HTTP status: $httpCode\n";
echo "   Raw response body:\n\n$body\n\n";
echo "   A 400/401-style JSON error response here is actually GOOD NEWS —\n";
echo "   it means your request got through to Safepay and it's just\n";
echo "   rejecting the fake test payload. That confirms outbound HTTPS works.\n";
echo "   If instead you saw a 'FAILED' cURL error above, that's the real problem.\n";
