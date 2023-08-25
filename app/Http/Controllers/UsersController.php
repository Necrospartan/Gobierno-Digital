<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Roleuser;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    //function to create user
    public function create(Request $request){
        try{
            $rules = [
                'name' => 'required | string | max:191',
                'email' => 'required | email | max:191 |unique:App\Models\User,email',
                'password' => 'required | string | max:191'
            ];
            $messages = [
                'name.required' => 'Name is required',
                'name.string' => 'Name must be a string',
                'name.max' => 'Name must be less than 191 characters',

                'email.required' => 'Email is required',
                'email.email' => 'Email must be a valid email',
                'email.max' => 'Email must be less than 191 characters',
                'email.unique' => 'Email already exists',

                'password.required' => 'Password is required',
                'password.string' => 'Password must be a string',
                'password.max' => 'Password must be less than 100 characters',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if($validator->fails()){
                return [
                    'validation' => 'failed',
                    'status' => false,
                    'error' => $validator->errors()
                ];
            }

            $user = User::insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $role_user = Roleuser::insert([
                'user_id' => $user,
                'role_id' => $request->role_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
            ]);
        } catch(\Exception $e){
            return response()->json([
                'Exception' => 'Exception',
                'status' => false,
                'message' => $e->getMessage()
                ], 500);
        }
    }

    //function to read user
    public function read($id = null){
        try{
            if($id != null){
                $data_user = User::find($id);
                if($data_user){
                    return response()->json([
                        'status' => true,
                        'message' => 'User found',
                        'data' => $data_user
                        ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'User not found'
                        ], 404);
                }
            } else {
                $all_data_use = User::all();
                if($all_data_use){
                    return response()->json([
                        'status' => true,
                        'message' => 'All Users',
                        'data' => $all_data_use
                        ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'The data_users is empty'
                        ], 404);
                }
            }
        } catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
                ], 500);
        }
    }
    //function to update user
    public function update(Request $request){
        try{
            $rules = [
                'id' => 'required | integer | exists:App\Models\User,id',
                'name' => 'required | string | max:191',
                'email' => 'required | email | max:191',
                'password' => 'required | string | max:191'
            ];
            $messages = [
                'id.required' => 'Id is required',
                'id.integer' => 'Id must be an integer',
                'id.exists' => 'Id not found',
                'name.required' => 'Name is required',
                'name.string' => 'Name must be a string',
                'name.max' => 'Name must be less than 191 characters',
                'email.required' => 'Email is required',
                'email.email' => 'Email must be a valid email',
                'email.max' => 'Email must be less than 191 characters',
                'password.required' => 'Password is required',
                'password.string' => 'Password must be a string',
                'password.max' => 'Password must be less than 100 characters',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if($validator->fails()){
                return [
                    'status' => false,
                    'error' => $validator->errors()
                ];
            }

            $user = User::find($request->id);
            if($user){
                User::where('id', $request->id)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                return response()->json([
                    'status' => true,
                    'message' => 'User updated successfully'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                    ], 404);
            }
        } catch(\Exception $e){
            return response()->json([
                'Exception'=> 'Exception',
                'status' => false,
                'message' => $e->getMessage()
                ], 500);
        }
    }
    //function to delete user
    public function delete(Request $request){
        try{
            $validator = Validator::make(['id' => $request->id], [
                'id' => [ 
                    'required',
                    'numeric',
                    'exists:App\Models\User,id'
                ]
            ]);
            if($validator->fails()){
                return [
                    'status' => false,
                    'error' => $validator->errors()
                    ];
            }
            $user = User::find($request->id);
            if($user){
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'User deleted successfully'
                    ]);
            }
            else {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                    ], 404);
            }
        } catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
                ], 500);
        }
    }
}