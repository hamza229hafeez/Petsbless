<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Pet;

class JobController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data for the job
        $request->validate([
            'service_type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'service_location' => 'required|string',
            'description' => 'required|string',
            'pickup_service' => 'required|boolean',
            'user_id' => 'required|exists:users,id', // Assuming you have a 'users' table
        ]);

        // Create a new job
        $job = Job::create($request->except('pet_ids')); // Exclude pet_ids from job creation

        // Handle the pet_ids and attach them to the job
        if ($request->has('pet_ids') && is_array($request->pet_ids)) {
            foreach ($request->pet_ids as $pet_id) {
                // You should validate $pet_id here to ensure it exists in the 'pets' table
                // You can use a similar validation as you did for user_id
                $job->pets()->attach($pet_id);
            }
        }

        // Return a success response
        return response()->json(['message' => 'Job created successfully', 'data' => $job], 201);
    }
    public function indexWithPets()
    {
        // Retrieve all jobs with their associated pets
        // $jobs = Job::with('pets')->get();
        $jobs = Job::with(['pets', 'user', 'pets.photos'])->get();

        // Return a JSON response with the list of jobs and their pets
        return response()->json(['data' => $jobs]);
    }
    public function getJobsByUserId($user_id)
    {
        // Retrieve jobs for the specified user_id
        $jobs = Job::where('user_id', $user_id)->get();

        // Return a JSON response with the list of jobs
        return response()->json(['data' => $jobs]);
    }
    public function index()
    {
        // Get all jobs
        $jobs = Job::all();

        // Return a JSON response with the list of jobs
        return response()->json(['data' => $jobs]);
    }
}
