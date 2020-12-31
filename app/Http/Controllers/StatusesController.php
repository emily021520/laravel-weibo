<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Status;
use Auth;

/**
 * 创建和删除微博
 */
class StatusesController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 创建微博
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:140'
        ]);

        Auth::user()->statuses()->create([
            'content' => $request['content']
        ]);
        session()->flash('success', '发布成功！');
        return redirect()->back();
    }

}
