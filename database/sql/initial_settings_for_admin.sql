-- Начални стойности за Spatie Laravel Settings
-- Таблица: settings (id, group, name, payload, created_at, updated_at)

INSERT INTO `settings` (`group`, `name`, `payload`, `created_at`, `updated_at`) VALUES
-- SITE
('site','site_name','"Satori"',NOW(),NOW()),
('site','logo_path','null',NOW(),NOW()),
('site','contact_email','null',NOW(),NOW()),
('site','contact_phone','null',NOW(),NOW()),
('site','address','null',NOW(),NOW()),
('site','facebook','null',NOW(),NOW()),
('site','instagram','null',NOW(),NOW()),

-- SEO
('seo','meta_title','null',NOW(),NOW()),
('seo','meta_description','null',NOW(),NOW()),
('seo','og_image','null',NOW(),NOW()),

-- PAYMENT
('payment','stripe_public_key','null',NOW(),NOW()),
('payment','stripe_secret_key','null',NOW(),NOW()),
('payment','stripe_webhook_secret','null',NOW(),NOW()),
('payment','currency','"BGN"',NOW(),NOW()),

-- SHIPPING
('shipping','sender_name','""',NOW(),NOW()),
('shipping','sender_phone','""',NOW(),NOW()),
('shipping','sender_city','""',NOW(),NOW()),
('shipping','sender_post','""',NOW(),NOW()),
('shipping','sender_street','""',NOW(),NOW()),
('shipping','sender_num','""',NOW(),NOW()),
('shipping','econt_env','"test"',NOW(),NOW()),
('shipping','econt_user','""',NOW(),NOW()),
('shipping','econt_pass','""',NOW(),NOW())
ON DUPLICATE KEY UPDATE
  `payload` = VALUES(`payload`),
  `updated_at` = NOW();
