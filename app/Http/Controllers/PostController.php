<?php

namespace App\Http\Controllers;
use App\Models\PetPost;
use App\Models\PetPostPhoto;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = PetPost::with('postPhotos','user')->get();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'userid'=>'required|string',
            'title' => 'required|string|max:255',
            'description' => 'string',
            'photos' => 'array',
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Create the post
        $post = new PetPost([
            'userid'=>$request->userid,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        // Save the post
        $post->save();

        // Process and save the images
  

                if ($request->has('photos')) {
                    foreach ($request->file('photos') as $photo) {
                        $photo = $photo->store('post-photos', 'public');
                // Save the image URL and post ID in the Post_Photos table
                PetPostPhoto::create([
                    'postid' => $post->id,
                    'photo_url' => $photo,
                ]);                
            }
        }

        return response()->json(['message' => 'Post created successfully'], 201);
    }
    public function show($id)
    {
        // Retrieve the post with the given ID
        $post = PetPost::with('postPhotos','user')->findOrFail($id);

        return response()->json($post);
    }
    // public function deletePost($id)
    // {
    //     try {
    //         //code...
       
    //     // Find the post by ID
    //     $post = PetPost::find($id);

    //     // Check if the post exists
    //     if (!$post) {
    //         return response()->json(['message' => 'Post not found'], 404);
    //     }
    //     if ($post->post_photos) {
    //     // Delete the post photos from the storage folder
    //     foreach ($post->post_photos as $photo) {
    //         Storage::delete('post-photos/' . $photo->photo_url);
    //     }

    //     // Delete the post photos from the Pet_post_photos table
    //     PetPostPhoto::where('postid', $id)->delete();
    // }
    //     // Delete the post
    //     $post->delete();

    //     return response()->json(['message' => 'Post and photos deleted successfully'], 200);
    // } catch (\Throwable $th) {
    //     throw $th;
    // }
    // }
    public function deletePost($id)
    {
        $post = PetPost::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        // Delete the related photos first
        $post->postPhotos()->delete();

        // Then delete the post
        $post->delete();

        return response()->json(['message' => 'Post and associated photos deleted successfully'], 200);
    }
    public function getPostsByUserId($userId)
    {
        // // Assuming you have a 'user_id' column in the 'pets' table that stores the owner's user ID.

        // Fetch pets that belong to the given user ID
        $pets = PetPost::where('userid', $userId)->with('postPhotos')->get();
        if($pets)
        {return response()->json($pets);}
        return response()->json(['message' => 'Not found'], 201);
    }
}
