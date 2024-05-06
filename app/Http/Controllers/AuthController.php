<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth ;
use validator ;
 use App\Models\User ;


class AuthController extends Controller
{   public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

     public function register (Request $request) {
     $validator=Validator::make($request->all(),[
        'nom'=>'required | string| max:20 ', 
        'prenom'=>'required| string | max:20 ',
       'email'=>'required | string |email | max:40 | unique:users',
       'mot_de_passe'=>'required | max:30 | min:8 '
     ]);  
     if($validator->fails()) {
        return response()->json($validator->errors()->toJson(),400);
     } 
     $user = User ::create(array_merge(
        $validator->validated() ,
        ['mot_de_passe'=>bcrypt($request->mot_de_passe)]
     )) ; 
     return response()->json([
     'message'=>'Utilisateur enregistré avec succès ', 
     'User'=>$user
     ],201);
    } 



    public function login (Request $request) {
    $validator=Validator::make($request->all(),[
        
       'email'=>'required | email ',
       'mot_de_passe'=>'required | max:30 | min:8 '
     ]); 
     if($validator->fails()) {
        return response()->json($validator->errors(),422);
     }
     if(!$token=auth()->attempt($validator->validated())) {
        return response()->json(['error'=>'Non autorisé'],401) ;
     } 
     return $this->createNewToken($token); 
    } 
    public function createNewToken($token) {
        return response () ->json ([
            'access_token'=>$token ,
            'token_type' => 'bearer',
            'expires_in'=>auth()->factory()->getTTL()*60 ,
            'user'=>auth()->user()
        ]);
    } 
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Déconnexion réussie']);
    }
}
