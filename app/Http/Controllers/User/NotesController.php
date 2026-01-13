<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\CloudApi;
use App\Models\User;
use App\Rules\Phone;
use App\Traits\Cloud;
use App\Models\ChatMessage;
use Auth;
use DB;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cloudapis=CloudApi::where('user_id',Auth::id())->where('status',1)->latest()->get();
        return view('user.notes.index',compact('cloudapis'));
    }

}