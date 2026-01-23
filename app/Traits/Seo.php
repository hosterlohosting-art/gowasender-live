<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\SEOTools;

trait Seo
{

    public function metadata($key)
    {
        $seo = get_option($key, true);
        $siteName = $seo->site_name ?? env('APP_NAME');
        $description = $seo->matadescription ?? '';
        $preview = !empty($seo->preview) ? asset($seo->preview) : asset('assets/img/brand/logo.png');
        $keywords = $seo->matatag ?? '';

        SEOMeta::setTitle($siteName);
        SEOMeta::setDescription($description);
        SEOMeta::addKeyword($keywords);
        SEOMeta::setCanonical(url()->current());

        OpenGraph::setTitle($siteName);
        OpenGraph::setDescription($description);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('site_name', $siteName);
        if ($preview) {
            OpenGraph::addImage($preview);
        }

        TwitterCard::setTitle($siteName);
        TwitterCard::setDescription($description);
        TwitterCard::setType('summary_large_image');
        if ($preview) {
            TwitterCard::setImage($preview);
        }

        JsonLd::setTitle($siteName);
        JsonLd::setDescription($description);
        JsonLd::setType('WebPage');
        if ($preview) {
            JsonLd::addImage($preview);
        }
    }


    public function pageMetaData($data)
    {
        $title = $data['title'] ?? env('APP_NAME');
        $description = $data['description'] ?? '';
        $preview = !empty($data['preview']) ? $data['preview'] : asset('assets/img/brand/logo.png');
        $tags = $data['tags'] ?? '';

        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::addKeyword($tags);
        SEOMeta::setCanonical(url()->current());

        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'article');
        if ($preview) {
            OpenGraph::addImage($preview);
        }

        TwitterCard::setTitle($title);
        TwitterCard::setDescription($description);
        TwitterCard::setType('summary_large_image');
        if ($preview) {
            TwitterCard::setImage($preview);
        }

        JsonLd::setTitle($title);
        JsonLd::setDescription($description);
        JsonLd::setType('WebPage');
        if ($preview) {
            JsonLd::addImage($preview);
        }
    }

}