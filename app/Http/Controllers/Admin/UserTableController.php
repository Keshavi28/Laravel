<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\UserTable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class UserTableController extends Controller
{
    public function form() {
        $users = UserTable::get();
        $roles = Role::get();
        return view('user_form', compact('users', 'roles'));
    }
    public function save(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:user_tables',
            'phone' => 'required|regex:/^[6-9]\d{9}$/',
            'description' => 'required',
            'role' => 'required'
        ], [
            'name.required' => 'Please enter your name.',
        
            'email.required' => 'An email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email address is already registered.',
        
            'phone.required' => 'Please enter the phone number.',
            'phone.regex' => 'Please enter a valid 10-digit Indian phone number.',
        
            'description.required' => 'Please provide a description.',
            'role.required' => 'Please select a role.'
        ]);


        if ($validator->fails()) {
            return response()->json([
                        'error' => $validator->errors()
                    ]);
        }
        $user = new UserTable();

        if($request->file('profile_image')!='')
        {
            $image_path = 'public/uploads/user_profile/'.$user->profile_image;
            
            if (file_exists($image_path)) 
            {
               File::delete($image_path);
            }

            $imageName = request()->profile_image->getClientOriginalName();
            $upload_path = 'public/uploads/user_profile';
            request()->profile_image->move($upload_path, $imageName);
            $user->profile_image = $imageName;
        }

        $user->name         = $request->name;
        $user->email        = $request->email;
        $user->phone        = $request->phone;
        $user->description  = $request->description;
        $user->role_id      = $request->role;

        if($request->status) {
            $user->status = $request->status;
        }
        else {
            $user->status = 0;
        }
        $user->save();
        $users = UserTable::get();
        $data = Log::info($users);
        return response()->json(['success' => 'Form submitted successfully.', $data],);
    }
    
    public function delete($id)
    {
        $user = UserTable::find($id);
        $user->delete();

        return redirect()->back();
    }
}
