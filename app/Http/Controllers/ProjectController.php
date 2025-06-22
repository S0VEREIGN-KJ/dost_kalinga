<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Coordinate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse; 

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $projects = Project::with('coordinate')
                ->select([
                    'proj_id',
                    'proj_name',
                    'proj_municipality',
                    'proj_desc',
                    'proj_type',
                    'org_name',
                    'proj_address',
                    'sector',
                    'status',
                    'proj_loc',
                    'proj_created'
                ])
                ->orderBy('proj_municipality')
                ->orderBy('proj_name')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $projects,
                'count' => $projects->count(),
                'message' => 'Projects retrieved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving projects',
                'error' => $e->getMessage()
            ], 500);
        }
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
        'proj_municipality' => 'required|string',
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
        'proj_municipality' => $validated['proj_municipality'],
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
    $project->proj_municipality = $request->input('proj_municipality', $project->proj_municipality);
    $project->proj_address = $request->input('proj_address', $project->proj_address);
    $project->sector = $request->input('sector', $project->sector);
    $project->status = $request->input('status', $project->status);

    $project->save();

    return response()->json($project);
}

// delete function
public function destroy($id)
{
    $project = Project::with('coordinate')->find($id);

    if (!$project) {
        return response()->json(['message' => 'Project not found'], 404);
    }

    try {
        // Delete the related coordinate first
        if ($project->coordinate) {
            $project->coordinate->delete();
        }

        // Then delete the project
        $project->delete();

        return response()->json(['message' => 'Project and coordinate deleted successfully']);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to delete project'], 500);
    }
}



    /**
     * Get projects by municipality
     */
    public function byMunicipality($municipality): JsonResponse
    {
        try {
            $tbl_kalinga = Project::byMunicipality($municipality)
                ->select([
                    'proj_id',
                    'proj_name',
                    'proj_desc',
                    'proj_type',
                    'org_name',
                    'proj_address',
                    'sector',
                    'status',
                    'proj_created'
                ])
                ->orderBy('proj_name')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $tbl_kalinga,
                'municipality' => $municipality,
                'count' => $tbl_kalinga->count(),
                'message' => "Projects for {$municipality} retrieved successfully"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving projects for municipality',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get unique municipalities
     */
    public function municipalities(): JsonResponse
    {
        try {
            $municipalities = Project::select('proj_municipality')
                ->distinct()
                ->orderBy('proj_municipality')
                ->pluck('proj_municipality');

            return response()->json([
                'success' => true,
                'data' => $municipalities,
                'count' => $municipalities->count(),
                'message' => 'Municipalities retrieved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving municipalities',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single project details
     */
    public function show($id): JsonResponse
    {
        try {
            $project = Project::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $project,
                'message' => 'Project retrieved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Get projects statistics
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = [
                'total_projects' => Project::count(),
                'municipalities_count' => Project::distinct('proj_municipality')->count(),
                'projects_by_status' => Project::selectRaw('status, COUNT(*) as count')
                    ->groupBy('status')
                    ->pluck('count', 'status'),
                'projects_by_municipality' => Project::selectRaw('proj_municipality, COUNT(*) as count')
                    ->groupBy('proj_municipality')
                    ->orderBy('count', 'desc')
                    ->pluck('count', 'proj_municipality')
            ];

            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Statistics retrieved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
