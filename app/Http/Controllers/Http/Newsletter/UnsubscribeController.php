<?php

namespace App\Http\Controllers\Http\Newsletter;

use App\Domain\Newsletter\Services\NewsletterService;
use App\Http\Controllers\Controller;

class UnsubscribeController extends Controller
{
    public function __invoke(string $token, NewsletterService $service)
    {
        $service->unsubscribe($token);

        return view('newsletter.message', [
            'title' => 'Успешно отписване',
            'body'  => 'Спряхме писмата. Можеш да се абонираш отново по всяко време.',
        ]);
    }
}
