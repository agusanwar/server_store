<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Laravel\Fortify\Rules\Password;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // var_dump('test regis');
        // die;
        try {
            //request validasi
             $request->validate([
                 'name' => ['required','string','max:255'],
                 'username' => ['required','string','max:255','unique:users'],
                 'email' => ['required','string','email','max:255','unique:users'],
                 'phone' => ['nullable','string','max:255'],
                 'password' =>['required', 'string', new Password],
                 // 'password' => $this->passwordRules(),
             ]);
 
               //create user
             User::create([
                 'name' => $request->name,
                 'email' => $request->email,
                 'username' => $request->username,
                 'phone' => $request->phone,
                 'password' => Hash::make($request->password),
             ]);
 
               //untuk mengambil data didatabase user
             $user = User::where('email', $request->email)->first();
 
             //untuk mengambil token
             $tokenResault = $user->createToken('authToken')->plainTextToken;
 
             //mengembalika token beserta data user
             return ResponseFormatter::success([
                 'access_token' => $tokenResault,
                 'token_type' => 'Bearer',
                 'user' => $user
             ]);
 
          //untuk mengecek eroor dan mengmablikan
         } catch (Exception $error) {
             return ResponseFormatter::error([
                 'message' => 'Something went wrong',
                //  'error' => $error,
             ], 'Authenticated Failed', 500);
         }
    }
    
    public function login(Request $request)
    {
        // var_dump('test regis');
        // die;
        try {
            //validasi input login
            $request->validate ([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            //mengecek credentials (login)
            $credentials = request(['email', 'password']);
            if(!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 500);
            }

            //jika berhasil tidak sesuai maka beri error
            $user = User::where('email', $request->email)->first();
            if(!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentils');
            }

             //jika berhasil maka login
             $tokenResault = $user->createToken('authToken')->plainTextToken;

             return ResponseFormatter::success([
                 'access_token' => $tokenResault,
                 'token_type' => 'Bearer',
                 'user' => $user,
             ], 'Authenticated');

        } catch(Exception $error) {
            return ResponseFormatter::Error([
                'message' => 'Something went wrong',
                // 'error' => $error,
            ], 'Authenticated Failed', 500 );
        }
    }
}
