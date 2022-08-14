<?php

namespace App\Http\Controllers;

use App\Models\Engineer;
use Illuminate\Http\Request;

class EngineerController extends Controller
{
    //
    public function index()
    {
        return view('engineer.index');
    }

    public function store(Request $req)
    {
        // print_r($_POST); // print js console.log
        // print_r($_FILES); // print js console.log
        $file = $req->file('avatar');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/images', $filename);

        $engData = [
            'first_name' => $req->fname,
            'last_name' => $req->lname,
            'email' => $req->email,
            'post' => $req->post,
            'phone' => $req->phone,
            'avatar' => $filename,
        ];

        Engineer::create($engData);
        return response()->json([
            'status' => 200
        ]);
    }

    public function fetchAll()
    {
        $engs = Engineer::all();
        print_r($engs);
    }
}
