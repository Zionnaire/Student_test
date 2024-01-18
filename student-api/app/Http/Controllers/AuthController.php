<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:6'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response(['user' => $user], 200);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required|min:6',
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials'], 401);
        }

        $accessToken = auth()->user()->createToken('authToken')->plainTextToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken], 200);
    }

 //Show Logout Form
 public function logout(Request $request){
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    // return redirect('/')->with('message', 'User logged out successfully!');
    return response(['message' => 'User logged out successfully!'], 200);
}


}


