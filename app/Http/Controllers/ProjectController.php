<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Coordinate;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
{
    $projects = Project::with('coordinate')->get();
    return response()->json($projects);
}

public function store(Request $request)
{
    $validated = $request->validate([
        'proj_name' => 'required|string|max:255',
        'proj_desc' => 'required|string',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'org_name' => 'required|string',
        'proj_type' => 'required|string',
        'proj_address' => 'required|string',
        'sector' => 'required|string',
        'status' => 'required|string',
    ]);

    $coordinate = Coordinate::create([
        'latitude' => $validated['latitude'],
        'longitude' => $validated['longitude']
    ]);

    $project = Project::create([
        'proj_loc' => $coordinate->loc_id,
        'proj_name' => $validated['proj_name'],
        'proj_desc' => $validated['proj_desc'],
        'org_name' => $validated['org_name'],
        'proj_type' => $validated['proj_type'],
        'proj_address' => $validated['proj_address'],
        'sector' => $validated['sector'],
        'status' => $validated['status'],
        'proj_created' => now(),
    ]);

    // Reload the project with the coordinate relation included
    $project->load('coordinate');

    return response()->json($project, 201);
}



}
