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

public function update(Request $request, $proj_id)
{
    $project = Project::findOrFail($proj_id);

    $project->proj_name = $request->input('proj_name', $project->proj_name);
    $project->proj_desc = $request->input('proj_desc', $project->proj_desc);
    $project->org_name = $request->input('org_name', $project->org_name);
    $project->proj_type = $request->input('proj_type', $project->proj_type);
    $project->proj_address = $request->input('proj_address', $project->proj_address);
    $project->sector = $request->input('sector', $project->sector);
    $project->status = $request->input('status', $project->status);

    $project->save();

    return response()->json($project);
}

// delete function
public function destroy($id)
{
    // Find the project by primary key 'proj_id'
    $project = Project::find($id);

    if (!$project) {
        return response()->json(['message' => 'Project not found'], 404);
    }

    try {
        $project->delete();
        return response()->json(['message' => 'Project deleted successfully']);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to delete project'], 500);
    }
}

}
