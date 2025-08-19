<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use RuntimeException;

class PayPal
{
    protected string $base;
    protected string $id;
    protected string $secret;

    public function __construct()
    {
        $cfg = config('services.paypal');
        $this->base   = rtrim($cfg['base_url'], '/');
        $this->id     = (string) $cfg['client_id'];
        $this->secret = (string) $cfg['secret'];
    }

    protected function request(string $method, string $url, array $opts = [], ?string $bearer = null): array
    {
        $ch = curl_init($this->base . $url);

        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'User-Agent: Satori/1.0 (+https://example.com)',
            'Accept-Language: bg-BG',
        ];
        if ($bearer) {
            $headers[] = 'Authorization: Bearer ' . $bearer;
        }

        if (!empty($opts['headers']) && is_array($opts['headers'])) {
            $headers = array_merge($headers, $opts['headers']);
        }

        $payload = isset($opts['json']) ? json_encode($opts['json'], JSON_UNESCAPED_UNICODE) : null;

        $curlOpts = [
            CURLOPT_CUSTOMREQUEST   => $method,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_HTTPHEADER      => $headers,
            CURLOPT_CONNECTTIMEOUT  => 8,
            CURLOPT_TIMEOUT         => 20,
            CURLOPT_SSL_VERIFYPEER  => true,
            CURLOPT_SSL_VERIFYHOST  => 2,
        ];
        if ($payload !== null) {
            $curlOpts[CURLOPT_POSTFIELDS] = $payload;
        }

        curl_setopt_array($ch, $curlOpts);

        $res  = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($res === false) {
            $err = curl_error($ch);
            curl_close($ch);
            throw new RuntimeException("PayPal cURL error: {$err}");
        }

        curl_close($ch);

        $data = json_decode($res, true) ?? [];

        if ($code >= 400) {
            \Log::error('PayPal API error', [
                'url'      => $this->base . $url,
                'status'   => $code,
                'response' => $data ?: $res,
                'payload'  => $payload ?? null,
                'headers'  => $headers,
            ]);
            $msg = $data['message'] ?? $data['error_description'] ?? $res;
            throw new RuntimeException("PayPal HTTP {$code}: {$msg}");
        }

        return $data;
    }


    public function token(): string
    {
        $cacheKey = 'paypal_access_token:' . sha1($this->base . '|' . $this->id);

        if ($tok = Cache::get($cacheKey)) {
            return $tok;
        }

        $ch = curl_init($this->base . '/v1/oauth2/token');

        curl_setopt_array($ch, [
            CURLOPT_POST            => true,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_USERPWD         => $this->id . ':' . $this->secret,
            CURLOPT_POSTFIELDS      => 'grant_type=client_credentials',
            CURLOPT_HTTPHEADER      => [
                'Accept: application/json',
                'Accept-Language: bg-BG',
                'User-Agent: Satori/1.0',
                'Content-Type: application/x-www-form-urlencoded',
            ],
            CURLOPT_CONNECTTIMEOUT  => 8,
            CURLOPT_TIMEOUT         => 20,
            CURLOPT_SSL_VERIFYPEER  => true,
            CURLOPT_SSL_VERIFYHOST  => 2,
        ]);

        $res  = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($res === false) {
            $err = curl_error($ch);
            curl_close($ch);
            throw new RuntimeException("PayPal token cURL error: {$err}");
        }

        curl_close($ch);

        $data = json_decode($res, true) ?? [];

        if ($code >= 400) {
            throw new RuntimeException("PayPal token HTTP {$code}: " . ($data['error_description'] ?? $res));
        }

        $access = (string)($data['access_token'] ?? '');
        if ($access === '') {
            throw new RuntimeException('PayPal token: missing access_token');
        }

        $ttl = max(60, (int)($data['expires_in'] ?? 3000) - 120);
        Cache::put($cacheKey, $access, $ttl);

        return $access;
    }


    public function createOrder(string $currency, float $amount, string $returnUrl, string $cancelUrl, array $metadata = [], ?string $brandName = null): array
    {
        $token = $this->token();

        $localOrderId = (string)($metadata['local_order_id'] ?? '');
        if ($localOrderId === '') {
            throw new \RuntimeException('createOrder: missing local_order_id in $metadata');
        }


        $body = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'custom_id'    => $localOrderId,
                'reference_id' => "order-{$localOrderId}",
                'invoice_id'   => "INV-{$localOrderId}",
                'amount' => [
                    'currency_code' => strtoupper($currency),
                    'value' => number_format($amount, 2, '.', ''),
                ],
            ]],
            'application_context' => [
                'return_url' => $returnUrl,
                'cancel_url' => $cancelUrl,
                'shipping_preference' => 'NO_SHIPPING',
                'brand_name' => $brandName ?? (config('app.name') ?: 'Store'),
                'user_action' => 'PAY_NOW',
            ],
        ];

        return $this->request('POST', '/v2/checkout/orders', ['json' => $body], $token);
    }

    public function captureOrder(string $orderId): array
    {
        $token = $this->token();

        $idempotencyKey = bin2hex(random_bytes(16));
        return $this->request(
            'POST',
            "/v2/checkout/orders/{$orderId}/capture",
            ['headers' => ['PayPal-Request-Id: ' . $idempotencyKey]],
            $token
        );
    }

    public static function extractApproveLink(array $order): ?string
    {
        foreach (($order['links'] ?? []) as $link) {
            if (($link['rel'] ?? null) === 'approve' && !empty($link['href'])) {
                return $link['href'];
            }
        }
        return null;
    }
}
