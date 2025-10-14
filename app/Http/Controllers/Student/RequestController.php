<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CounselingRequest;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function index()
    {
        $id = session('user.id');
        $requests = CounselingRequest::where('id_user',$id)->orderBy('requested_at','desc')->paginate(10);
        return view('student.requests.index', compact('requests'));
    }

    public function create()
    {
        return view('student.requests.create');
    }

    public function store(Request $r)
    {
        $r->validate(['reason'=>'required|string|max:255']);
        CounselingRequest::create([
            'id_user'=>session('user.id'),
            'reason'=>$r->reason,
            'status'=>'pending',
            'requested_at'=>now()
        ]);
        return redirect()->route('student.requests.index')->with('success','Permintaan konseling dikirim');
    }

    public function destroy(CounselingRequest $request)
    {
        if ($request->id_user != session('user.id')) abort(403);
        $request->delete();
        return back()->with('success','Permintaan dibatalkan');
    }
}
