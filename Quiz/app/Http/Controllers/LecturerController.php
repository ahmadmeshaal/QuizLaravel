<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class LecturerController extends Controller
{
    public function index()
    {
        $lecturers = Lecturer::with('user')
            ->withCount('courses')
            ->where('isActivated', true)
            ->get();

        return view('lecturers.index', compact('lecturers'));
    }

    public function create()
    {
        $users = User::whereDoesntHave('lecturer')->get();

        return view('lecturers.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id|unique:lecturers,user_id',
            'employee_number' => 'required|unique:lecturers,employee_number',
            'department' => 'required',
            'academic_rank' => 'required',
            'office_room' => 'required',
            'photo' => 'nullable|image',
        ]);


        Lecturer::create($data);

        return redirect()->route('lecturers.index');
    }

    public function show(Lecturer $lecturer)
    {
        return view('lecturers.show', compact('lecturer'));
    }

    public function edit(Lecturer $lecturer)
    {
        $users = User::whereDoesntHave('lecturer')
            ->orWhere('id', $lecturer->user_id)
            ->get();

        return view('lecturers.edit', compact('lecturer', 'users'));
    }

    public function update(Request $request, Lecturer $lecturer)
    {
        $data = $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                Rule::unique('lecturers', 'user_id')->ignore($lecturer->id),
            ],
            'employee_number' => [
                'required',
                Rule::unique('lecturers', 'employee_number')->ignore($lecturer->id),
            ],
            'department' => 'required',
            'academic_rank' => 'required',
            'office_room' => 'required',
            'photo' => 'nullable|image',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('lecturers', 'public');

            if ($lecturer->photo) {
                Storage::disk('public')->delete($lecturer->photo);
            }
        }

        $lecturer->update($data);

        return redirect()->route('lecturers.index');
    }

    public function destroy(Lecturer $lecturer)
    {
        if ($lecturer->courses()->exists()) {
            return back()->with('error', 'Lecturer has courses!');
        }

        $lecturer->delete();

        return redirect()->route('lecturers.index');
    }
}
