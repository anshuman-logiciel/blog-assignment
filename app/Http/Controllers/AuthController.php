<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserImage;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class AuthController extends Controller
{
    public function registerUser(Request $request)
    {
        
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required',
            'password'=>'required', 
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors(),412);
        }
        $user= User::create([
            'name' =>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
            ]);
        $accessToken = $user->createToken('authToken')->plainTextToken;
        return response()->json(['token'=>$accessToken],200);
    }

    public function loginUser(Request $request)
    {
        $login_credentials=[
            'email'=>$request->email,
            'password'=>$request->password,
        ];
        if(auth()->attempt($login_credentials))
        {  
            $success['token'] = auth()->user()->createToken('myApp')->plainTextToken;
            return response()->json(['token' => $success['token']], 200);
        } 
            return response()->json(['error' => 'UnAuthorised Access'], 401);
    }    
    public function authenticatedUserDetails()
    {   
      return response()->json(['authenticated-user' => auth()->user()], 200);
    }
    public function active_status(Request $request, $id)
    {
        $users=User::find($id);
        if($users)
        {
            $data=$request->is_active;
            
            if($data==0)
            {
                $users->is_active=$request->is_active;
                $users->save();
                return response()->json(["message"=>'User Inactive'],200);
            }
            elseif($data==1)
            { 
                $users->is_active=$request->is_active;
                $users->save();
                return response()->json(["message"=>'User Active'],200);
            }
            return response()->json(["message"=>'This is not a boolean value'],404);
        } 
        return response()->json(["message"=>'Invalid User_id'],404);
    }
    public function userdepartment(Request $request,$id)
    {
        $user=User::find($id);
        if(!$user) 
        {
            return response()->json(["message"=>'Invalid Id'],404);
        }
        $data=$request->department_id;  
        $check=Department::find($data)->count();
        if($check==3)
        {
            $user->departments()->attach($data);
            return response()->json(["message"=>'Record Attached'],200);
        }
        return response()->json(["message"=>'Invalid Department Id'],404);
    }
    public function imagestore(Request $request)
    {
        if(!$request->hasFile('Images')) 
        {
            return response()->json(['upload_file_not_found'], 400);
        }
        $allowedfileExtension=['pdf','jpg','png'];
        $file= $request->file('Images'); 
        $extension = $file->getClientOriginalExtension();
        $check = in_array($extension,$allowedfileExtension);
        if($check)
        {
            $path = $file->store('public/images'); 
            $file = basename($path);
            $save = new UserImage();
            $save->users_id=$request->users_id;
            $save->images=$path;
            $save->save(); 
            return response()->json([
                "message"=>'image uploaded successfully',
               
               "image"=> asset('storage/images/' . $file)
                ]);
        }
        return response()->json(['invalid_file_format'], 422);
    }
 }
 