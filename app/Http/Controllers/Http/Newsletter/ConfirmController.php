<?php

namespace App\Http\Controllers\Http\Newsletter;

use App\Domain\Newsletter\Services\NewsletterService;
use App\Http\Controllers\Controller;

class ConfirmController extends Controller
{
    public function __invoke(string $token, NewsletterService $service)
    {
        $sub = $service->confirm($token);

        return view('newsletter.message', [
            'title' => 'Успешно потвърдено',
            'body'  => 'Благодарим! Абонаментът е активен.',
            'excerpt_url' => route('newsletter.excerpt', $sub->token),
            'unsubscribe_url' => route('newsletter.unsubscribe', $sub->token),
        ]);
    }
}
