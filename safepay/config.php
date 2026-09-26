<?php
/**
 * Safepay Sandbox configuration.
 *
 * Get these from https://sandbox.api.getsafepay.com/dashboard/signup
 *  -> Sign up / log in
 *  -> Settings / Developers section -> API Keys
 *
 * public_key  : the "Client" / publishable key, looks like sec_xxxxxxxx-xxxx-...
 * secret_key  : the "Secret Key" used to sign/verify the redirect back to your site
 * webhook_secret : Dashboard -> Developers -> Endpoints -> shared webhook secret
 *                  (only needed if you set up safepay_webhook.php)
 *
 * NEVER commit real keys to a public GitHub repo. For a FYP demo this is fine,
 * but treat these the same way you treat the DB password in db.php.
 */
return [
    'environment'    => 'sandbox', // 'sandbox' now, 'production' only after you go live
    'base_url'       => 'https://sandbox.api.getsafepay.com',
    'public_key'     => 'YOUR_SAFEPAY_PUBLIC_KEY',
    'secret_key'     => 'YOUR_SAFEPAY_SECRET_KEY',
    'webhook_secret' => 'YOUR_SAFEPAY_WEBHOOK_SECRET',
    'currency'       => 'PKR',
];
