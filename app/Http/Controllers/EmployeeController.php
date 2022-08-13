<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
// use RealRashid\SweetAlert\Facades\Alert;

class EmployeeController extends Controller
{
    //
    public function index()
    {
        return view('employee.index');
    }

    public function fetchEmployee()
    {
        $employee = Employee::all();
        return response()->json([
            'employee' => $employee,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' =>'required|max:191',
            'phone' =>'required|max:100',
            'image' =>'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }
        else
        {
            $employee = new Employee;
            $employee->name = $request->input('name');
            $employee->phone = $request->input('phone');
            if($request->hasFile('image'))
            {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/employee/', $filename);
                $employee->image = $filename;
            }
            $employee->save();
            // Alert::success('Congrats', 'You\'ve Successfully Registered');
            return response()->json([
                'status' => 200,
                'message' => 'Employee Data Added Successfully',
            ]);
        }
    }

    public function edit($id)
    {
        $employee = Employee::find($id);
        if($employee)
        {
            return response()->json([
                'status' => 200,
                'employee' => $employee
            ]);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => 'Employee Not Found'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' =>'required|max:191',
            'phone' =>'required|max:100',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }
        else
        {
            $employee = Employee::find($id);
            if($employee)
            {
                $employee->name = $request->input('name');
                $employee->phone = $request->input('phone');
                if($request->hasFile('image'))
                {
                    $path = 'uploads/employee/'.$employee->image;
                    if(File::exists($path))
                    {
                        File::delete($path);
                    }
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/employee/', $filename);
                    $employee->image = $filename;
                }
                $employee->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Employee Data Updated Successfully',
                ]);
            }
            else
            {
                return response()->json([
                    'status' => 404,
                    'message' => 'Employee Not Found',
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);
        if($employee)
        {
            $path = 'uploads/employee/'.$employee->image;
            if(File::exists($path))
            {
                File::delete($path);
            }
            $employee->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Employee deleted successfully'
            ]);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => 'Employee Not Found',
            ]);
        }
    }
}
