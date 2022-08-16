<?php

namespace App\Http\Controllers;

use App\Models\Engineer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    //fetch all employee
    public function fetchAll()
    {
        $engs = Engineer::all();
        // print_r($engs);
        // echo $engs;
        $output = '';
        if($engs->count() > 0)
        {
            // text-center is cut from table class
            $output .= '<table class = "table table-striped table-sm align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>E-mail</th>
                    <th>Post</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>';
            foreach($engs as $eng)
            {
              $output .= '<tr>
              <td>' .$eng->id. '</td>
              <td><img src="storage/images/' .$eng->avatar. '" width = "50px" class = "img-thumbnail rounded-circle" </td>
              <td>' .$eng->first_name.' ' .$eng->last_name. '</td>
              <td>' .$eng->email. '</td>
              <td>' .$eng->post. '</td>
              <td>' .$eng->phone. '</td>
              <td>
                <a href="#" id="' .$eng->id. '" class = "text-success mx-1 editIcon" data-bs-toggle = "modal" data-bs-target = "#editEngineerModal"><i class = "bi-pencil-square h4"></i></a>

                <a href="#" id="' .$eng->id. '" class = "text-danger mx-1 deleteIcon"><i class = "bi-trash h4"></i></a>
              </td>
            </tr>';
            }
            $output .= '</tbody>
            </table>';
            echo $output;
        }
        else
        {
            echo '<h1 class = "text-center text-secondary my-5">No record present in the database!</h1>';
        }
    }

    public function edit(Request $req)
    {
        $id = $req->id;
        $eng = Engineer::find($id);
        return response()->json($eng);
    }

    //update engineer ajax request
    public function update(Request $req)
    {
        $filename = '';
        $eng = Engineer::find($req->eng_id);
        if($req->hasFile('avatar'))
        {
            $file = $req->file('avatar');
            $filename = time(). '.' .$file->getClientOriginalExtension();
            $file->storeAs('public/images', $filename);
            if($eng->avatar)
            {
                Storage::delete('public/images', $eng->avatar);
            }
        }
        else
        {
            $filename = $req->eng_avatar;
        }
        $engData = [
            'first_name' => $req->fname,
            'last_name' => $req->lname,
            'email' => $req->email,
            'post' => $req->post,
            'phone' => $req->phone,
            'avatar' => $filename,
        ];
        $eng->update($engData);
        return response()->json([
            'status' => 200
        ]);
    }

    //delete engineer ajax request
    public function delete(Request $req)
    {
        $id = $req->id;
        $eng = Engineer::find($id);
        if(Storage::delete('public/images' .$eng->avatar))
        {
            Engineer::destroy($id);
        }
    }
}
