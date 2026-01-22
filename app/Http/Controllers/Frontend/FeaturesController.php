<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Plan;
use App\Traits\Seo;

class FeaturesController extends Controller
{
    use Seo;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $overview = get_option('overview', true, true);

        $this->metadata('seo_features');

        $features = Post::where('type', 'feature')->where('featured', 1)->where('lang', app()->getLocale())->with('preview', 'excerpt')->latest()->take(6)->get();

        return view('frontend.features', compact('features'));
    }
}
