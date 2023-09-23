<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceQuestion;
use App\Models\ServiceImage;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return response()->json(['services' => $services], 200);
    }
    // public function store(Request $request)
    // {
    //     // Validate the incoming request data
    //     $request->validate([
    //         'type' => 'required',
    //         'title' => 'required',
    //         'listing_summary' => 'required',
    //         'description' => 'required',
    //         'price' => 'required|numeric',
    //         'location' => 'required',
    //         'country' => 'required',
    //         'city' => 'required',
    //         'zipcode' => 'required',
    //         'street_number' => 'required',
    //         'user_id' => 'required|exists:users,id',
    //         'questions' => 'array', // Assuming questions are in an array
    //         'images' => 'array', // Assuming images are in an array
    //     ]);

    //     // Create a new service
    //     $service = Service::create($request->all());

    //     // Add service questions
    //     foreach ($request->input('questions') as $question) {
    //         ServiceQuestion::create([
    //             'question' => $question,
    //             'service_id' => $service->id,
    //         ]);
    //     }

    //     // Add service images
    //     foreach ($request->input('images') as $imageUrl) {
    //         ServiceImage::create([
    //             'url' => $imageUrl,
    //             'service_id' => $service->id,
    //         ]);
    //     }

    //     return response()->json(['message' => 'Service created successfully'], 201);
    // }
    // public function store(Request $request)
    // {
    //     // Validate the incoming request data
    //     $request->validate([
    //         'type' => 'required',
    //         'title' => 'required',
    //         'listing_summary' => 'required',
    //         'description' => 'required',
    //         'price' => 'required|numeric',
    //         'location' => 'required',
    //         'country' => 'required',
    //         'city' => 'required',
    //         'zipcode' => 'required',
    //         'street_number' => 'required',
    //         'user_id' => 'required|exists:users,id',
    //         'questions' => 'array', // Assuming questions are in an array
    //         'photos' => 'array', // Assuming photos are in an array
    //     ]);
    
    //     // Create a new service
    //     $service = Service::create($request->except('questions', 'photos'));
    
    //     // Add service questions
    //     foreach ($request->input('questions') as $question) {
    //         ServiceQuestion::create([
    //             'question' => $question,
    //             'service_id' => $service->id,
    //         ]);
    //     }
    
    //     // Add service images
    //     if ($request->hasFile('photos')) {
    //         foreach ($request->file('photos') as $photo) {
    //             $photoUrl = $photo->store('service-photos', 'public'); // 'service-photos' is the directory to store images
    //             ServiceImage::create([
    //                 'url' => $photoUrl,
    //                 'service_id' => $service->id,
    //             ]);
    //         }
    //     }
    
    //     return response()->json(['message' => 'Service created successfully'], 201);
    // }
    public function store(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'type' => 'required',
        'title' => 'required',
        'listing_summary' => 'required',
        'description' => 'required',
        'price' => 'required|numeric',
        'location' => 'required',
        'country' => 'required',
        'city' => 'required',
        'zipcode' => 'required',
        'street_number' => 'required',
        'user_id' => 'required|exists:users,id',
        'questions' => 'array', // Assuming questions are in an array
        'questions.*.question' => 'required', // Validate each question has a 'question' field
        'questions.*.answer' => 'required', // Validate each question has an 'answer' field
        'photos' => 'array', // Assuming photos are in an array
    ]);

    // Create a new service
    $serviceData = $request->except('questions', 'photos');
    $service = Service::create($serviceData);

    // Add service questions
    foreach ($request->input('questions') as $questionData) {
        ServiceQuestion::create([
            'question' => $questionData['question'],
            'answer' => $questionData['answer'],
            'service_id' => $service->id,
        ]);
    }

    // Add service images
    if ($request->hasFile('photos')) {
        foreach ($request->file('photos') as $photo) {
            $photoUrl = $photo->store('service-photos', 'public'); // 'service-photos' is the directory to store images
            ServiceImage::create([
                'url' => $photoUrl,
                'service_id' => $service->id,
            ]);
        }
    }

    return response()->json(['message' => 'Service created successfully'], 201);
}

    
    // public function show($id)
    // {
    //     // Retrieve the service and related questions and images
    //     $service = Service::with('questions', 'images')->find($id);

    //     if (!$service) {
    //         return response()->json(['message' => 'Service not found'], 404);
    //     }

    //     return response()->json(['service' => $service], 200);
    // }
    public function show($id)
{
    // Retrieve the service by its ID along with related questions and images
    $service = Service::with(['questions', 'images'])->find($id);

    if (!$service) {
        return response()->json(['message' => 'Service not found'], 404);
    }

    // Transform the questions data into the desired format
    $questionsData = $service->questions->map(function ($question) {
        return [
            'question' => $question->question,
            'answer' => $question->answer,
        ];
    });

    // Create a response array with the desired format
    $response = [
        'id' => $service->id,
        'type' => $service->type,
        'title' => $service->title,
        'listing_summary' => $service->listing_summary,
        'description' => $service->description,
        'price' => $service->price,
        'location' => $service->location,
        'country' => $service->country,
        'city' => $service->city,
        'zipcode' => $service->zipcode,
        'street_number' => $service->street_number,
        'user_id' => $service->user_id,
        'questions' => $questionsData,
        'images' => $service->images->pluck('url'), // Assuming you want an array of image URLs
    ];

    return response()->json(['service' => $response], 200);
}
public function getServicesByUserId($userId)
{
    $services = Service::where('user_id', $userId)->get();
    return response()->json(['services' => $services], 200);
}

}

