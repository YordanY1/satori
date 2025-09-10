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

        $latestExcerpt = \App\Models\NewsletterExcerpt::latest()->first();
        abort_unless($latestExcerpt && $latestExcerpt->file_path, 404, 'Няма качен файл.');

        $path = storage_path('app/public/' . $latestExcerpt->file_path);
        abort_unless(is_file($path), 404, 'Файлът липсва.');

        return response()->download($path, $latestExcerpt->title . '.pdf');
    }
}
