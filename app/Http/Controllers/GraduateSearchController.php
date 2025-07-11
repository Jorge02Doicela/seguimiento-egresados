<?php

namespace App\Http\Controllers;

use App\Models\Graduate;
use Illuminate\Http\Request;

class GraduateSearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Graduate::query();

        if ($request->filled('cohort_year')) {
            $query->where('cohort_year', $request->cohort_year);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('sector')) {
            $query->where('sector', $request->sector);
        }

        $graduates = $query->with('user')->paginate(10);

        return view('employer.graduates', [
            'graduates' => $graduates,
            'filters' => $request->only('cohort_year', 'gender', 'sector'),
        ]);
    }
}
