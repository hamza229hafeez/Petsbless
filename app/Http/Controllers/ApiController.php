<?php

namespace App\Http\Controllers;

use Faker\Provider\tr_TR\DateTime;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Apicontroller extends Controller
{
    function getAllUsers(Request $request)
    {
        //return User::all();
    }
    // function check(Request $request)
    // {
    //     if ($request->hasFile('back')) {
    //         $image = $request->file('back');
    //         $imageName = time() . '.' . $image->getClientOriginalExtension();
    //         $image->move(public_path('images'), $imageName);
    //         return response('SEXY 1', 200);
    //     }
    //     return response('SEXY 2', 200);
    // }
    function register(Request $request)
    {
        // $backimage = $request->file('back');
        // $backimageName = time() . '.' . $backimage->getClientOriginalExtension();
        // $backimage->move(public_path('images'), $backimageName);
        // return response($backimage);
        $firstName = $request->input('name');
        $username = $request->input('username');
        $contact = $request->input('contact');
        $email = $request->input('email');
        $password = $request->input('password');
        
        // $emid = $request->input('emid');
        // $isValidEmid = preg_match('/^\d{15}$/', $emid);
        // if ($isValidEmid) {
            
            
        // } else {
        //     return response("EMID is not valid",400);
        // }
        
        $validator = Validator::make(
            ['contact' => $contact],
            ['contact' => 'regex:/^\d{13}$/']
        );
        if ($validator->fails()) {
            return response('Invalid Contact No.', 400);
        }
        while (User::where('email', $email)->exists()) {
            return response('Email Already Exists', 400);
            // $username = $this->generateUsername($username);
        }
        while (User::where('contact', $contact)->exists()) {
            return response('Contact Already Exists', 400);
            // $username = $this->generateUsername($username);
        }
        // $receiver_email = $email;
        // $subject = "testingg";
        // $message = "Verifications Code";
        // $headers = "From:global<info@vxworld.net> \r\n";
        // $headers .= "Reply-To: global<info@vxworld.net> \r\n";
        // $headers .= "MIME-Version: 1.0\r\n";
        // $headers .= "Content-Type: text/html; charset=utf-8\r\n";
        // $result = @mail($receiver_email, $subject, $message, $headers);
        // if ($result) {
        // } else {
        // }

        if (strlen($password) < 6) {
            return response('Password must be at least six characters long', 400);
        }
        if (!empty($username)) {
            while (User::where('username', $username)->exists()) {
                $username = $this->generateUsername($username);
            }
        } else {
            $username = $this->generateUsername($firstName);
            while (User::where('username', $username)->exists()) {
                $username = $this->generateUsername($firstName);
            }
        }
        $user = new User;
        $user->name = $firstName;
        $user->username = $username;
        $user->email = $email;
        $user->contact = $contact;
        $user->password = Hash::make($password);
        $user->save();
        $user->password=null;
        return response()->json(['message' => 'User created successfully', 'username' => $user], 200);

    }

    private function generateUsername($firstName)
    {
        // Generate three random digits
        $randomDigits = mt_rand(100, 999);

        // Concatenate the random digits with the first name and last name
        $username = $firstName . $randomDigits;

        return $username;
    }
    // public function login(Request $request)
    // {
    //    // $credentials = $request->input('value');

    //         $user = User::where('email',$request->email)->Where('password',Hash::make($request->password))->first();
    //        // $token = $user->createToken('auth_token')->plainTextToken;

    //         if($user!=null){return response()->json(['user_data' => $user], 200);}
    //         return response()->json(['user_data not found'], 404);

    //    // return response()->json(['error' => $credentials], 401);
    // }
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $request->email)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        // Password is correct, proceed with authentication
        // You can also generate and return an access token here if using Laravel Passport.
        return response()->json(['message' => 'Login successful',$user], 200);
    }

    return response()->json(['message' => 'Invalid credentials'], 401);
}

// public function login(Request $request)
// {
//     $request->validate([
//         'email' => 'required|email',
//         'password' => 'required|string',
//     ]);

//     $credentials = $request->only('email', 'password');

//     if (Auth::attempt($credentials)) {
//         $user = Auth::user();
//         $token = $user->createToken('MyAppToken')->accessToken;

//         return response()->json(['token' => $token], 200);
//     }

//     return response()->json(['message' => 'Unauthorized'], 401);
// }
public function getUserData(Request $request)
{
    $request->validate([
        'id' => 'required'
    ]);

    $user = User::where('id', $request->id)->first();

    if ($user) {
        // Password is correct, proceed with authentication
        // You can also generate and return an access token here if using Laravel Passport.
        return response()->json(['message' => 'Login successful',$user], 200);
    }

    return response()->json(['message' => 'Invalid credentials'], 401);
}
public function deteteUserData(Request $request)
{
    $request->validate([
        'id' => 'required'
    ]);

    $user = User::where('id', $request->id)->first();

    if ($user) {
        // Password is correct, proceed with authentication
        // You can also generate and return an access token here if using Laravel Passport.
        return response()->json(['message' => 'Login successful',$user], 200);
    }

    return response()->json(['message' => 'Invalid credentials'], 401);
}
public function updateUserData(Request $request)
{
    $request->validate([
        'id' => 'required'
    ]);

    $user = User::where('id', $request->id)->first();

    if ($user) {

        return response()->json(['message' => 'Login successful',$user], 200);
    }

    return response()->json(['message' => 'Invalid credentials'], 401);
}
}