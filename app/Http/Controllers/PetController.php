<?php

namespace App\Http\Controllers;
use App\Models\Pet;
use App\Models\PetPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class PetController extends Controller
{
    public function index()
    {
        $pets = Pet::with('photos')->get();
        return response()->json($pets);
    }

    public function store(Request $request)
    {
        try {
            //code...
     
        $validator = Validator::make($request->all(), [
            'petowner' => 'required|exists:users,id',
            'pettype' => 'required|string',
            'petbreed' => 'required|string',
            'petsize' => 'required|string',
            'petgender' => 'required|string',
            'dateofbirth' => 'required|date',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $pet = Pet::create($request->all());

        if ($request->has('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photoUrl = $photo->store('pet-photos', 'public');
                PetPhoto::create([
                    'petid' => $pet->id,
                    'photo_url' => $photoUrl,
                ]);
            }
        }

        return response()->json($pet, 201);
    } catch (\Throwable $th) {
        throw $th;
//        return response()->json($th, 500);
    }
    }
    public function deletePet($id)
    {
        $pet = Pet::find($id);

        if (!$pet) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        // Delete the related photos first
        $pet->photos()->delete();

        // Then delete the post
        $pet->delete();

        return response()->json(['message' => 'Pet and associated photos deleted successfully'], 200);
    }

    public function show($id)
    {
        $pet = Pet::with('photos','owner')->find($id);
        if (!$pet) {
            return response()->json(['error' => 'Pet not found'], 404);
        }
        return response()->json($pet);
    }
    public function getPetsByUserId($userId)
    {
        // Assuming you have a 'user_id' column in the 'pets' table that stores the owner's user ID.

        // Fetch pets that belong to the given user ID
        $pets = Pet::where('petowner', $userId)->with('photos')->get();
        return response()->json($pets);
    }
}
