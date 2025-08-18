<?php

namespace App\Http\Controllers\Http\Newsletter;

use App\Domain\Newsletter\Contracts\NewsletterSubscriberRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class ExcerptController extends Controller
{
    public function __invoke(string $token, NewsletterSubscriberRepositoryInterface $repo)
    {
        $sub = $repo->findByToken($token);
        abort_unless($sub && $sub->confirmed_at && !$sub->unsubscribed_at, 403, 'Нямаш достъп.');

        $path = storage_path('app/public/excerpts/presence.pdf');
        abort_unless(is_file($path), 404, 'Откъсът липсва.');

        return Response::download($path, 'presence.pdf');
    }
}
