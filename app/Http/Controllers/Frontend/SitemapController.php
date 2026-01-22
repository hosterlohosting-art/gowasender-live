<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 1)->where('lang', app()->getLocale())->whereIn('type', ['blog', 'page', 'feature'])->get();

        $urls = [
            ['loc' => url('/'), 'lastmod' => date('Y-m-d'), 'priority' => '1.0'],
            ['loc' => url('/about'), 'lastmod' => date('Y-m-d'), 'priority' => '0.8'],
            ['loc' => url('/blogs'), 'lastmod' => date('Y-m-d'), 'priority' => '0.8'],
            ['loc' => url('/pricing'), 'lastmod' => date('Y-m-d'), 'priority' => '0.8'],
            ['loc' => url('/features'), 'lastmod' => date('Y-m-d'), 'priority' => '0.8'],
            ['loc' => url('/faq'), 'lastmod' => date('Y-m-d'), 'priority' => '0.7'],
            ['loc' => url('/contact'), 'lastmod' => date('Y-m-d'), 'priority' => '0.7'],
        ];

        foreach ($posts as $post) {
            $path = '';
            if ($post->type == 'blog') {
                $path = '/blog/' . $post->slug;
            } elseif ($post->type == 'page') {
                $path = '/page/' . $post->slug;
            } elseif ($post->type == 'feature') {
                $path = '/feature/' . $post->slug;
            }

            if ($path) {
                $urls[] = [
                    'loc' => url($path),
                    'lastmod' => $post->updated_at->format('Y-m-d'),
                    'priority' => '0.6',
                ];
            }
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($urls as $url) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($url['loc']) . '</loc>';
            $xml .= '<lastmod>' . $url['lastmod'] . '</lastmod>';
            $xml .= '<priority>' . $url['priority'] . '</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return Response::make($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
