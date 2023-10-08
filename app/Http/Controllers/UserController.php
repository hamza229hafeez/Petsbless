<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Vendor;

use Illuminate\Http\Request;

class UserController extends Controller
{
 
    public function index()
    {
        $users = User::all();

        return response()->json(['users' => $users], 200);
    }
    public function store(Request $request)
    {
        
        try {
            //code...
        // Validate the incoming request data
        $validatedData = $request->validate([
            'id' => 'required|string',
            'username' => 'required|string|unique:users',
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'profilepicture' => 'image|mimes:jpeg,png,jpg,gif',
            'contactnumber' => 'required|string',
            'address' => 'nullable|string',
            'latitute' => 'nullable|numeric',
            'longitute' => 'nullable|numeric',
            'userstatus' => 'nullable|integer',
        ]);

        // Upload and save the profile picture if provided
        if ($request->hasFile('profilepicture')) {
            $profilePicturePath = $request->file('profilepicture')->store('profile_pictures', 'public');

            // Save the profile picture path to the user record
            $validatedData['profilepicture'] = $profilePicturePath;
        }

        // Create the user in the database
        $user = User::create($validatedData);

        // Return the newly created user record
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    } catch (\Throwable $th) {
        return response()->json([
            'message' => 'error',
            'user' => $th
        ], 500);
    }
    }
    public function show($id)
    { try {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Check if the user has associated vendor data
        $vendor = Vendor::where('user_id', $user->id)->first();

        if ($user && $vendor) {
            // If both user and vendor exist, return user and vendor data
            return response()->json(['user' => $user, 'vendor' => $vendor], 200);
        }

        // If the user exists but doesn't have vendor data
        if ($user) {
            return response()->json(['user' => $user, 'vendor' => null], 200);
        }

        return response()->json(['message' => 'No user exist'], 404);
    } catch (\Throwable $th) {
        return response()->json([
            'message' => 'Error',
            'error' => $th->getMessage(),
        ], 500);
    }
    }
    public function searchByAddress(Request $request)
    {
        $address = $request->input('address');

        // Use Eloquent to search for users based on the address
        $users = User::where('address', 'like', "%$address%")->get();

        // Return the search results as JSON
        return response()->json(['users' => $users]);
    }
    // public function deleteUserData($userId)
    // {
    //     $user = PetPost::find($userId);

    //     if (!$user) {
    //         return response()->json(['message' => 'Post not found'], 404);
    //     }

    //     // Delete the related photos first
    //     $user->petPosts()->pets()->delete();

    //     // Then delete the post
    //     $user->delete();

    //     return response()->json(['message' => 'Post and associated photos deleted successfully'], 200);
    // }

// public function deletePostsAndPicturesByUserId($userId)
// {
//     $user = User::find($userId);

//     if (!$user) {
//         return response()->json(['message' => 'User not found'], 404);
//     }

//     // Delete the posts and related pictures
//     foreach ($user->posts as $post) {
//         foreach ($post->pictures as $picture) {
//             // Delete the picture file from storage (if applicable)
//             Storage::delete($picture->filename);
//             // Delete the picture record from the database
//             $picture->delete();
//         }
//         // Delete the post record from the database
//         $post->delete();
//     }

//     return response()->json(['message' => 'User posts and associated pictures deleted successfully'], 200);
// }

}
