<?php

namespace App\Http\Controllers;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VendorController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'user_id' => 'required|string',
            'introduction' => 'required|string',
            'experience' => 'required|string',
            'your_enjoy' => 'required|string',
            'skills' => 'required|string',
            'special_skill' => 'required|string',
            'emid' => 'required|string',
            'front_picture' => 'required|image|mimes:jpeg,png,jpg,gif',
            'back_picture' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);
    
        // Create the vendor
        $vendor = Vendor::create([
            'user_id' => $request->user_id,
            'introduction' => $request->introduction,
            'experience' => $request->experience,
            'your_enjoy' => $request->your_enjoy,
            'skills' => $request->skills,
            'special_skill' => $request->special_skill,
            'emid' => $request->emid,
        ]);
    
        // Save the front picture and back picture
        if ($request->hasFile('front_picture')) {
            $frontPicture = $request->file('front_picture')->store('public/vendor-pictures');
            $vendor->front_picture_url = Storage::url($frontPicture);
            $vendor->save();
        }

        // Save the back picture
        if ($request->hasFile('back_picture')) {
            $backPicture = $request->file('back_picture')->store('public/vendor-pictures');
            $vendor->back_picture_url = Storage::url($backPicture);
            $vendor->save();
        }
        return response()->json(['message' => 'Vendor created successfully', 'data' => $vendor], 201);
    }

    public function getVendorById($id)
    {
        $vendor = Vendor::find($id);

        if (!$vendor) {
            return response()->json(['message' => 'Vendor not found'], 404);
        }
        return response()->json(['data' => $vendor], 200);
    }
}
