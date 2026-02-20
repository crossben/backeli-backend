<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index()
    {
        $totalMembers = \App\Models\Membre::count();
        $activeMembers = \App\Models\Membre::where('statut', true)->count();
        $inactiveMembers = $totalMembers - $activeMembers;

        // Count distinct cities that are not null or empty
        $coveredCities = \App\Models\Membre::whereNotNull('ville')
            ->where('ville', '!=', '')
            ->distinct('ville')
            ->count('ville');

        return response()->json([
            'total_members' => $totalMembers,
            'active_members' => $activeMembers,
            'inactive_members' => $inactiveMembers,
            'covered_cities' => $coveredCities,
        ]);
    }
}
