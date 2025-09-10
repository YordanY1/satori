<?php

namespace App\Console\Commands;

use App\Models\NewsletterExcerpt;
use App\Models\NewsletterSubscriber;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterExcerptMail;

class SendNewsletterExcerpts extends Command
{
    protected $signature = 'newsletter:send {excerptId}';
    protected $description = 'Изпраща PDF откъс на всички абонати';

    public function handle(): int
    {
        $excerpt = NewsletterExcerpt::findOrFail($this->argument('excerptId'));
        $subs = NewsletterSubscriber::active()->get();
        foreach ($subs as $sub) {
            Mail::to($sub->email)->queue(new NewsletterExcerptMail($excerpt, $sub));
        }

        $excerpt->update(['is_sent' => true]);

        $this->info('Изпратен е успешно до всички абонати.');
        return Command::SUCCESS;
    }
}
