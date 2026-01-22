<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Postmeta;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        $articles = [
            [
                'title' => 'Why WhatsApp Marketing is the Future of Business Communication',
                'excerpt' => 'Discover how WhatsApp is transforming business-to-customer relationships and why your business needs an automation strategy today.',
                'content' => '<h1>Why WhatsApp Marketing is the Future of Business Communication</h1><p>WhatsApp has become the most widely used messaging app globally, with over 2 billion active users. For businesses, this presents an unprecedented opportunity to connect with customers where they are most comfortable.</p><h2>High Engagement Rates</h2><p>Unlike email marketing, which often has low open rates, WhatsApp messages have an incredible open rate of over 90%. This means your marketing campaigns are almost guaranteed to be seen.</p><h2>Personalized Customer Experience</h2><p>Automation allows you to send personalized messages, product update notifications, and real-time support, creating a seamless and premium customer experience.</p>',
                'tags' => 'whatsapp marketing, automation, business communication, customer engagement'
            ],
            [
                'title' => 'Official vs Unofficial WhatsApp API: Which One is Right for You?',
                'excerpt' => 'Learn the key differences between the Official WhatsApp Business API and Unofficial gateways to make an informed decision for your business.',
                'content' => '<h1>Official vs Unofficial WhatsApp API</h1><p>Choosing the right way to automate your WhatsApp messages is crucial for long-term success. Let\'s break down the two main options.</p><h2>The Official WhatsApp Business API</h2><p>Meta\'s official solution is reliable, supports high-volume messaging, and protects your business from being banned. It requires a verification process but offers enterprise-grade security.</p><h2>Unofficial Gateways</h2><p>Unofficial gateways are often easier to set up but carry a higher risk of account suspension. They are suitable for small scale or experimental projects but lack the stability of the official solution.</p>',
                'tags' => 'whatsapp api, meta, automation, business tools, messaging gateways'
            ],
            [
                'title' => '5 Pro Strategies for E-commerce Growth Using WhatsApp Automation',
                'excerpt' => 'Boost your sales and customer loyalty with these 5 proven WhatsApp automation strategies tailored for modern e-commerce stores.',
                'content' => '<h1>5 Pro Strategies for E-commerce Growth</h1><p>WhatsApp is not just a chat app; it\'s a powerful sales engine. Here are five strategies to scale your e-commerce business.</p><h2>1. Abandoned Cart Recovery</h2><p>Send a gentle reminder to customers who left items in their cart. A 10% discount coupon sent over WhatsApp can recover up to 25% of lost sales.</p><h2>2. Real-time Order Updates</h2><p>Keep your customers informed with automated shipping and delivery updates. Transparency builds trust.</p><h2>3. Broadcast Exclusive Deals</h2><p>Use bulk sending to reach your most loyal customers with flash sales and exclusive offers.</p>',
                'tags' => 'ecommerce, whatsapp sales, growth hacking, automation strategies'
            ],
        ];

        foreach ($articles as $art) {
            $post = Post::updateOrCreate(
                ['slug' => Str::slug($art['title'])],
                [
                    'title' => $art['title'],
                    'type' => 'blog',
                    'status' => 1,
                    'featured' => 1,
                    'lang' => 'en'
                ]
            );

            // Add Meta
            Postmeta::updateOrCreate(
                ['post_id' => $post->id, 'key' => 'short_description'],
                ['value' => $art['excerpt']]
            );

            Postmeta::updateOrCreate(
                ['post_id' => $post->id, 'key' => 'main_description'],
                ['value' => $art['content']]
            );

            // SEO Meta
            $seo = [
                'title' => $art['title'],
                'description' => $art['excerpt'],
                'tags' => $art['tags'],
            ];
            Postmeta::updateOrCreate(
                ['post_id' => $post->id, 'key' => 'seo'],
                ['value' => json_encode($seo)]
            );
        }
    }
}
