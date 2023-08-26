<?php

namespace App\Http\Middleware;
use App\Models\Roleuser;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class User_Role_Jwt
{
    public function handle(Request $request, Closure $next)
    {
        $id = auth()->user()->id;
        $role_id = RoleUser::select('role_id')
            ->where('user_id', $id)
            ->first()->role_id;
        if($role_id == 1){

            return $next($request);
        }
        else{
            return response()->json(['status' => 401, 'message' => 'No tienes permiso de acceder a esta ruta'], 401);        
        }
    }
}
