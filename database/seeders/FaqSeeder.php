<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['В какъв срок се доставя поръчката?', 'Стандартно 1–3 работни дни с Еконт.', 'доставка,срок'],
            ['Какви методи за плащане поддържате?', 'Наложен платеж, карта (Stripe), PayPal.', 'плащане,stripe,paypal'],
            ['Мога ли да върна продукт?', 'Да, в рамките на 14 дни според ЗЗП. Свържи се с нас.', 'връщане,отказ'],
        ];
        foreach ($rows as [$q, $a, $t]) {
            Faq::firstOrCreate(['question' => $q], ['answer' => $a, 'tags' => $t, 'is_active' => true]);
        }
    }
}
