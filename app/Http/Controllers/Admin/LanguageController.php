<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Option;
use Cache;
use Auth;
use File;
class LanguageController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:language');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = get_option('languages', true);
        $countries = base_path('lang/langlist.json');
        $countries = json_decode(file_get_contents($countries), true);

        return view('admin.language.index', compact('languages', 'countries'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(preg_match('/[^a-zA-Z0-9_-]/', $request->language_code), 400); // Prevent path traversal
        $file = base_path('lang/default.json');
        $file = file_get_contents($file);
        File::put(base_path('lang/' . $request->language_code . '.json'), $file);
        $languages = get_option('languages', true);

        $arr = [];
        if (!empty($languages)) {
            foreach ($languages as $key => $value) {
                $arr[$key] = $value;
            }
        }

        $arr[$request->language_code] = $request->name;

        $langlist = Option::where('key', 'languages')->first();
        if (empty($langlist)) {
            $langlist = new Option;
            $langlist->key = 'languages';
        }
        $langlist->value = json_encode($arr);
        $langlist->save();
        Cache::forget('languages');


        return response()->json([
            'redirect' => route('admin.language.show', $request->language_code),
            'message' => __('Language Created successfully.')
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(preg_match('/[^a-zA-Z0-9_-]/', $id), 404); // Prevent path traversal
        $file = base_path('lang/' . $id . '.json');
        $posts = file_get_contents($file);
        $posts = json_decode($posts);
        return view('admin.language.show', compact('posts', 'id'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(preg_match('/[^a-zA-Z0-9_-]/', $id), 404); // Prevent path traversal
        $data = [];
        foreach ($request->values as $key => $row) {
            $data[$key] = $row;
        }

        $file = json_encode($data, JSON_PRETTY_PRINT);
        File::put(base_path('lang/' . $id . '.json'), $file);

        return response()->json([
            'redirect' => route('admin.language.index'),
            'message' => __('Settings Updated Successfully.')
        ]);
    }

    public function addKey(Request $request)
    {
        $request->validate([
            'key' => 'required',
            'value' => 'required',
        ]);

        abort_if(preg_match('/[^a-zA-Z0-9_-]/', $request->id), 404); // Prevent path traversal
        $file = base_path('lang/' . $request->id . '.json');
        $posts = file_get_contents($file);
        $posts = json_decode($posts);
        foreach ($posts as $key => $row) {
            $data[$key] = $row;
        }
        $data[$request->key] = $request->value;

        File::put(base_path('lang/' . $request->id . '.json'), json_encode($data, JSON_PRETTY_PRINT));

        return response()->json([
            'message' => __('Key Added Successfully.')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(preg_match('/[^a-zA-Z0-9_-]/', $id), 404); // Prevent path traversal
        $posts = Option::where('key', 'languages')->first();
        $languages = json_decode($posts->value);

        $data = [];
        foreach ($languages as $key => $row) {
            if ($id != $key) {
                $data[$key] = $row;
            }
        }

        $posts->value = json_encode($data);
        $posts->save();

        if (file_exists(base_path('lang/' . $id . '.json'))) {
            unlink(base_path('lang/' . $id . '.json'));
        }

        Cache::forget('languages');

        return response()->json([
            'redirect' => route('admin.language.index'),
            'message' => __('Language Removed successfully.')
        ]);

    }
}
