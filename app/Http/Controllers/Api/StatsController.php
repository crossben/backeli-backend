<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index()
    {
        $memberQuery = \App\Models\User::where('role', 'member');
        $totalMembers = clone $memberQuery;
        $totalMembers = $totalMembers->count();

        $activeMembers = clone $memberQuery;
        $activeMembers = $activeMembers->where('statut', true)->count();

        $inactiveMembers = $totalMembers - $activeMembers;

        $coveredCitiesQuery = clone $memberQuery;
        $coveredCities = $coveredCitiesQuery->whereNotNull('ville')
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
