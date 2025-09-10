<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('settings')->upsert([
            // SITE
            ['group' => 'site', 'name' => 'site_name',        'payload' => '"Satori"', 'created_at' => now(), 'updated_at' => now()],
            ['group' => 'site', 'name' => 'logo_path',        'payload' => 'null',     'created_at' => now(), 'updated_at' => now()],
            ['group' => 'site', 'name' => 'contact_email',    'payload' => 'null',     'created_at' => now(), 'updated_at' => now()],
            ['group' => 'site', 'name' => 'contact_phone',    'payload' => 'null',     'created_at' => now(), 'updated_at' => now()],
            ['group' => 'site', 'name' => 'address',          'payload' => 'null',     'created_at' => now(), 'updated_at' => now()],
            ['group' => 'site', 'name' => 'facebook',         'payload' => 'null',     'created_at' => now(), 'updated_at' => now()],
            ['group' => 'site', 'name' => 'instagram',        'payload' => 'null',     'created_at' => now(), 'updated_at' => now()],

            // SEO
            ['group' => 'seo', 'name' => 'meta_title',        'payload' => 'null',     'created_at' => now(), 'updated_at' => now()],
            ['group' => 'seo', 'name' => 'meta_description',  'payload' => 'null',     'created_at' => now(), 'updated_at' => now()],
            ['group' => 'seo', 'name' => 'og_image',          'payload' => 'null',     'created_at' => now(), 'updated_at' => now()],

            // PAYMENT
            ['group' => 'payment', 'name' => 'stripe_public_key',     'payload' => 'null',   'created_at' => now(), 'updated_at' => now()],
            ['group' => 'payment', 'name' => 'stripe_secret_key',     'payload' => 'null',   'created_at' => now(), 'updated_at' => now()],
            ['group' => 'payment', 'name' => 'stripe_webhook_secret', 'payload' => 'null',   'created_at' => now(), 'updated_at' => now()],
            ['group' => 'payment', 'name' => 'currency',              'payload' => '"BGN"', 'created_at' => now(), 'updated_at' => now()],

            // SHIPPING
            ['group' => 'shipping', 'name' => 'sender_name',   'payload' => '""',    'created_at' => now(), 'updated_at' => now()],
            ['group' => 'shipping', 'name' => 'sender_phone',  'payload' => '""',    'created_at' => now(), 'updated_at' => now()],
            ['group' => 'shipping', 'name' => 'sender_city',   'payload' => '""',    'created_at' => now(), 'updated_at' => now()],
            ['group' => 'shipping', 'name' => 'sender_post',   'payload' => '""',    'created_at' => now(), 'updated_at' => now()],
            ['group' => 'shipping', 'name' => 'sender_street', 'payload' => '""',    'created_at' => now(), 'updated_at' => now()],
            ['group' => 'shipping', 'name' => 'sender_num',    'payload' => '""',    'created_at' => now(), 'updated_at' => now()],
            ['group' => 'shipping', 'name' => 'econt_env',     'payload' => '"test"', 'created_at' => now(), 'updated_at' => now()],
            ['group' => 'shipping', 'name' => 'econt_user',    'payload' => '""',    'created_at' => now(), 'updated_at' => now()],
            ['group' => 'shipping', 'name' => 'econt_pass',    'payload' => '""',    'created_at' => now(), 'updated_at' => now()],
        ], ['group', 'name']); // ключове за upsert
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('group', ['site','seo','payment','shipping'])->delete();
    }
};
