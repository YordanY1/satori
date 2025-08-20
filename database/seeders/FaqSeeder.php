<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $rows = __('faq.questions');

        foreach ($rows as $row) {
            Faq::firstOrCreate(
                ['question' => $row['q']],
                ['answer' => $row['a'], 'tags' => $row['tags'], 'is_active' => true]
            );
        }
    }
}
