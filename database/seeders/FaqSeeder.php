<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Postmeta;
use Illuminate\Support\Str;

class FaqSeeder extends Seeder
{
    public function run()
    {
        $faqs = [
            [
                'q' => 'What is the WhatsApp Cloud API?',
                'a' => 'The WhatsApp Cloud API is the official enterprise-grade solution from Meta that allows businesses to send and receive messages at scale without the risk of being banned. It offers higher reliability and security compared to unofficial solutions.'
            ],
            [
                'q' => 'Is there a risk of my number being banned?',
                'a' => 'By using the Official WhatsApp Cloud API through our platform, the risk of being banned is significantly reduced to near zero. Unlike unofficial automation tools, the Cloud API follows Meta\'s official guidelines.'
            ],
            [
                'q' => 'Can I send unlimited messages?',
                'a' => 'Yes, depending on your plan tier, you can send unlimited messages. However, Meta imposes "Messaging Limits" (tiers) that increase as you maintain a good quality rating with your customers.'
            ],
            [
                'q' => 'How much does Meta charge for messages?',
                'a' => 'Meta uses a conversation-based pricing model. The first 1,000 service conversations each month are free. For marketing and utility messages, Meta charges a small fee per 24-hour window, which varies by country.'
            ],
            [
                'q' => 'Do I need a verified Facebook Business Manager?',
                'a' => 'While you can start testing immediately without verification, Meta requires Business Verification to scale your messaging limits and use your own phone number for high-volume campaigns.'
            ],
            [
                'q' => 'Can I use my existing WhatsApp number?',
                'a' => 'Yes, you can register an existing number with the Cloud API, but you must first delete any existing WhatsApp or WhatsApp Business accounts associated with that number.'
            ],
            [
                'q' => 'What is a Flow Builder?',
                'a' => 'Our Visual Flow Builder allows you to create complex automated chat sequences without coding. You can drag and drop boxes to create interactive menus, collect data, and route customers.'
            ],
            [
                'q' => 'How do I set up a Webhook?',
                'a' => 'We provide a unique Callback URL in your dashboard. You simply paste this into your Meta Developer portal under the WhatsApp Configuration section to start receiving messages in real-time.'
            ],
            [
                'q' => 'Does this platform support team collaboration?',
                'a' => 'Yes! Pro and Reseller plans support multi-user access, allowing your entire team to manage customer conversations and campaigns from a single dashboard.'
            ],
            [
                'q' => 'Can I send images and PDF documents?',
                'a' => 'Absolutely. The Cloud API supports text, images, videos, audio files, PDFs, and even interactive buttons and list messages.'
            ],
            [
                'q' => 'What is the "Verify Token"?',
                'a' => 'The Verify Token is a security string you set in our portal and match in the Meta Dev portal. For our platform, the default verify token is "gowasender".'
            ],
            [
                'q' => 'How many numbers can I connect?',
                'a' => 'This depends on your subscription plan. Starter plans usually support one device, while Pro and Reseller plans allow for multiple WhatsApp API connections.'
            ],
            [
                'q' => 'Do you provide the source code?',
                'a' => 'The Reseller plan includes the full PHP/Laravel source code, allowing you to host the platform on your own server and brand it as your own.'
            ],
            [
                'q' => 'Is there a refund policy?',
                'a' => 'We offer a 7-day money-back guarantee if you are not satisfied with our platform features, provided you haven\'t exceeded our fair usage limits.'
            ],
            [
                'q' => 'Can I schedule messages? ',
                'a' => 'Yes, our platform includes a robust scheduling engine. You can set up campaigns to go out at specific dates and times, or even recurring sequences.'
            ],
            [
                'q' => 'How does the AI Chatbot work?',
                'a' => 'Our AI Chatbot uses natural language processing to understand customer intent. It can be trained on your business data to answer complex questions automatically 24/7.'
            ],
            [
                'q' => 'What happens if my subscription expires?',
                'a' => 'If your subscription expires, your automated flows and campaigns will pause. Your data will be safely stored for 30 days while you renew your plan.'
            ],
            [
                'q' => 'Can I integrate this with my CRM?',
                'a' => 'Yes, we provide advanced Webhooks and API endpoints that allow you to sync WhatsApp data with external CRM systems like Salesforce, HubSpot, or custom databases.'
            ],
            [
                'q' => 'Is my data secure?',
                'a' => 'We use enterprise-grade SSL encryption and secure database practices. Your customer data and message contents are never shared with third parties.'
            ],
            [
                'q' => 'What support do you offer?',
                'a' => 'We provide email support for all users. Pro and Reseller plan holders get priority WhatsApp support and technical onboarding assistance.'
            ],
        ];

        foreach ($faqs as $item) {
            $post = Post::updateOrCreate(
                ['slug' => Str::slug($item['q'])],
                [
                    'title' => $item['q'],
                    'type' => 'faq',
                    'status' => 1,
                    'featured' => 1,
                    'lang' => 'en'
                ]
            );

            Postmeta::updateOrCreate(
                ['post_id' => $post->id, 'key' => 'excerpt'],
                ['value' => $item['a']]
            );
        }
    }
}
