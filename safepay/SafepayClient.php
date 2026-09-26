<?php
/**
 * Safepay API client — plain cURL, no Composer needed, so it works on
 * shared hosting like InfinityFree where you can only upload files via FTP.
 *
 * Implements Safepay's current documented "Express Checkout" flow:
 *   1. createSession()       -> opens a payment session (needs intent+mode)
 *   2. createPassportToken() -> short-lived (1hr) client auth token
 *   3. buildCheckoutUrl()    -> just builds a URL, no network call
 *   4. (redirect the shopper's browser to that URL)
 *   5. verifySignature()     -> check the ?tracker=&sig= Safepay appends to your redirect_url
 *   6. fetchTracker()        -> server-to-server GET, confirms the real payment state
 */

class SafepayClient
{
    private $baseUrl;
    private $publicKey;
    private $secretKey;
    private $webhookSecret;
    private $environment;

    public function __construct(array $config)
    {
        $this->baseUrl       = rtrim($config['base_url'], '/');
        $this->publicKey     = $config['public_key'];
        $this->secretKey     = $config['secret_key'];
        $this->webhookSecret = $config['webhook_secret'];
        $this->environment   = $config['environment'];
    }

    /**
     * Step 1: create a payment session ("tracker") for this order.
     * $amountMajor is in normal currency units (e.g. 1580.00 PKR) — this
     * method converts it to the "lowest denomination" Safepay's v3 API
     * expects (i.e. paisa: 1580.00 PKR -> 158000).
     * $intent is the payment channel Safepay routes to: 'CYBERSOURCE' or 'MPGS'.
     */
    public function createSession($amountMajor, $currency = 'PKR', $intent = 'CYBERSOURCE')
    {
        $amountMinor = (int) round($amountMajor * 100);

        return $this->request('POST', '/order/payments/v3/', [
            'merchant_api_key' => $this->publicKey,
            'intent'           => $intent,
            'mode'             => 'payment',
            'entry_mode'       => 'raw', // 'raw' = classic hosted-redirect checkout;
                                         // 'flex' (the default) is for embedding fields
                                         // directly on your own page instead.
            'currency'         => $currency,
            'amount'           => $amountMinor,
        ], true);
    }

    /**
     * Step 2: generate a short-lived (1 hour) client-side auth token.
     * Required to build a valid Checkout URL. This endpoint's error messages
     * indicate it authenticates using your merchant WEBHOOK secret (from
     * Dashboard -> Developers -> Endpoints), not your API secret key.
     */
    public function createPassportToken()
    {
        return $this->request('POST', '/client/passport/v1/token', [
            'merchant_api_key' => $this->publicKey,
        ], true, [
            'X-SFPY-MERCHANT-SECRET: ' . $this->secretKey,
        ]);
    }

    /**
     * Step 3: build the hosted Checkout URL to send the shopper's browser to.
     * No network call — this is just string building.
     */
    public function buildCheckoutUrl($trackerToken, $tbt, $orderRef, $redirectUrl, $cancelUrl)
    {
        // NOTE: this used to build /components?beacon=... — that path and
        // param name don't match Safepay's actual hosted-checkout endpoint,
        // which left every session stuck at "initiated" (confirmed against
        // a working integration on another project + Safepay's own SDK
        // source: the correct path is /embedded and the param is `tracker`,
        // not `beacon`).
        $params = [
            'environment'  => $this->environment,
            'tracker'      => $trackerToken,
            'tbt'          => $tbt,
            'source'       => 'hosted',
            'redirect_url' => $redirectUrl,
            'cancel_url'   => $cancelUrl,
        ];
        return $this->baseUrl . '/embedded?' . http_build_query($params);
    }

    /**
     * Step 5: verify the tracker/signature pair Safepay appends to redirect_url.
     * This proves the redirect actually came from Safepay and wasn't forged
     * by someone typing ?tracker=...&sig=fake in the address bar.
     */
    public function verifySignature($trackerToken, $signature)
    {
        if (!$trackerToken || !$signature) {
            return false;
        }
        $expected = hash_hmac('sha256', $trackerToken, $this->secretKey);
        return hash_equals($expected, (string) $signature);
    }

    /**
     * Step 6: ask Safepay directly what state this tracker is really in.
     * Do this even though you already checked the signature — the signature
     * only proves the redirect wasn't forged, not that the payment actually
     * succeeded. This is the real source of truth.
     */
    public function fetchTracker($trackerToken)
    {
        // Was authenticated=true (Authorization: Bearer ...) — Safepay's own
        // error response for this endpoint lists every auth strategy it
        // tried and explicitly says the merchant secret header was missing,
        // confirming this endpoint needs X-SFPY-MERCHANT-SECRET (same header
        // createPassportToken() already uses correctly below), not a Bearer
        // token. Was also /v1/ instead of /v2/ — both are now fixed.
        return $this->request('GET', '/reporter/api/v2/payments/' . rawurlencode($trackerToken), null, false, [
            'X-SFPY-MERCHANT-SECRET: ' . $this->secretKey,
        ]);
    }

    /**
     * Verify an incoming webhook body (optional, see safepay_webhook.php).
     */
    public function verifyWebhook($rawBody, $signatureHeader)
    {
        if (!$signatureHeader) {
            return false;
        }
        $expected = hash_hmac('sha256', $rawBody, $this->webhookSecret);
        return hash_equals($expected, (string) $signatureHeader);
    }

    /**
     * Low-level request helper. Never throws — always returns an array so
     * callers can gracefully fall back instead of fataling if the host
     * blocks outbound connections (a known issue on some free hosts).
     *
     * $authenticated adds the secret-key Authorization header required by
     * Safepay's newer session/passport/reporter endpoints.
     */
    private function request($method, $path, $payload, $authenticated = false, $extraHeaders = [])
    {
        $ch = curl_init($this->baseUrl . $path);

        $headers = ['Content-Type: application/json', 'Accept: application/json'];
        if ($authenticated) {
            $headers[] = 'Authorization: Bearer ' . $this->secretKey;
        }
        $headers = array_merge($headers, $extraHeaders);

        $opts = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_CONNECTTIMEOUT => 8,
            CURLOPT_SSL_VERIFYPEER => true,
        ];
        if ($payload !== null) {
            $opts[CURLOPT_POSTFIELDS] = json_encode($payload);
        }
        curl_setopt_array($ch, $opts);

        $body     = curl_exec($ch);
        $errno    = curl_errno($ch);
        $error    = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($errno) {
            return [
                'ok'        => false,
                'http_code' => 0,
                'error'     => "cURL error ($errno): $error",
                'data'      => null,
                'raw'       => null,
            ];
        }

        $decoded = json_decode($body, true);

        return [
            'ok'        => $httpCode >= 200 && $httpCode < 300,
            'http_code' => $httpCode,
            'error'     => ($httpCode >= 200 && $httpCode < 300) ? null : "HTTP $httpCode",
            'data'      => $decoded,
            'raw'       => $body,
        ];
    }
}