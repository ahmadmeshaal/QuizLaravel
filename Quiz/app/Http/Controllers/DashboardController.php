<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lecturer;
use App\Models\Course;
use App\Models\Lecture;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLecturers = Lecturer::where('isActivated', true)->count();

        $totalCourses = Course::count();

        $totalLectures = Lecture::count();

        $totalEnrollments = DB::table('course_user')->count();

        return view('dashboard', compact(
            'totalLecturers',
            'totalCourses',
            'totalLectures',
            'totalEnrollments'
        ));
    }
}
