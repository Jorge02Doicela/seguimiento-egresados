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

        if ($request->filled('area_laboral')) {
            $area = $request->input('area_laboral');

            if ($area === 'tecnologia' && $request->filled('sector_tecnologia')) {
                $query->where('sector', $request->input('sector_tecnologia'));
            } elseif ($area === 'otros' && $request->filled('sector_otros')) {
                $query->where('sector', $request->input('sector_otros'));
            }
        }

        $graduates = $query->with('user')->paginate(10);

        $cohortYears = Graduate::select('cohort_year')
            ->distinct()
            ->orderBy('cohort_year', 'desc')
            ->pluck('cohort_year');

        return view('employer.graduates', [
            'graduates' => $graduates,
            'filters' => $request->only('cohort_year', 'gender', 'area_laboral', 'sector_tecnologia', 'sector_otros'),
            'cohortYears' => $cohortYears,
        ]);
    }
}
