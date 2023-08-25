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
                'email' => 'required | email | max:191 |unique:users, email',
                'password' => 'required | string | min:100'
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
                    'status' => false,
                    'error' => $validator->errors()
                ];
            }

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($user->password);
            $user->created_at = date('Y-m-d H:i:s');
            $user->updated_at = date('Y-m-d H:i:s');
            $user->save();

            $role_user = new Roleuser;
            $role_user->user_id = $user->id;
            $role_user->role_id = $request->role_id;
            $role_user->created_at = date('Y-m-d H:i:s');
            $role_user->updated_at = date('Y-m-d H:i:s');
            $role_user->save();

            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password
            ]);
        } catch(\Exception $e){
            return response()->json([
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
                'id' => 'required | integer | exists:users, id',
                'name' => 'required | string | max:191',
                'email' => 'required | email | max:191',
                'password' => 'required | string | min:100'
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
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($user->password);
                $user->updated_at = date('Y-m-d H:i:s');
                $user->save();
                return response()->json([
                    'status' => true,
                    'message' => 'User updated successfully',
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => $user->password
                ]);
            } else {
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
    //function to delete user
    public function delete(Request $request){
        try{
            $rules = [
                'id' => 'required | integer | exists:users, id',
            ];
            $messages = [
                'id.required' => 'Id is required',
                'id.integer' => 'Id must be an integer',
                'id.exists' => 'Id not found',
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