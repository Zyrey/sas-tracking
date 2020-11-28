<?php

namespace App\Http\Controllers;

use App\Semester;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::latest('created_at')->paginate(10);
        return view('semester.index', compact('semesters'));
    }

    public function list(){
        $semesters = Semester::get();
        return $semesters;
    }


    public function create(Semester $semester)
    {
        return view('semester.create', compact('semester'));
    }

    public function updateSem(Request $request){
        $semesters = Semester::where('current',1)
        ->pluck('id');
        $current = Semester::find($semesters[0]);
        $current->current=0;
        $current->save();
        $semesters_new = Semester::find($request['updatesem']);
        $semesters_new->current=1;
        $semesters_new->save();
        return $current;
    }

    public function store(Request $request)
    {
        $this->validatedCreateRequest($request);
        $semester = Semester::create($request->all());
        return redirect(route('semesters.show', $semester->id));
    }


    public function show(Semester $semester)
    {
        return view('semester.show', compact('semester'));
    }


    public function edit(Semester $semester)
    {
        return view('semester.edit', compact('semester'));
    }


    public function update(Request $request, Semester $semester)
    {
        $this->validatedEditRequest($request, $semester);
        $semester->update($request->all());

        return redirect(route('semesters.show', $semester->id))
            ->with('message', $semester->termAndYear . ' has been updated successfully.');
    }


    public function updateCurrentSemester(Semester $semester)
    {
        // Unset current semester
        Semester::whereCurrent(1)->update([
            'current' => 0,
        ]);
        // Set the selected semester as current semester
        $semester->update([
            'current' => 1,
        ]);

        return redirect(route('semesters.show', $semester->id))
            ->with('message', $semester->termAndYear . ' has been set as the current semester.');
    }


    private function validatedCreateRequest($request)
    {
        return
            $request->validate([
                'term' => [
                    'required', 'integer', 'between:1,3',
                    Rule::unique('semesters')->where(function ($query) use($request){
                        return $query->where('term', $request->term)
                            ->where('year_start', $request->year_start)
                            ->where('year_end', $request->year_end);
                    })
                ],
                'year_start' => 'bail|required|digits:4|integer|min:'.date('Y').'|max:'.(date('Y')+1),
                'year_end' => 'bail|required|digits:4|integer|gt:year_start|max:'.(date('Y')+1),
            ]);
    }


    private function validatedEditRequest($request, $semester)
    {
        return
            $request->validate([
                'term' => [
                    'required', 'integer', 'between:1,3',
                    Rule::unique('semesters')->where(function ($query) use($request, $semester){
                        return $query->where('term', $request->term)
                            ->where('year_start', $request->year_start)
                            ->where('year_end', $request->year_end)
                            ->whereNotIn('id', [$semester->id]);
                    })
                ],
                'year_start' => 'bail|required|digits:4|integer|min:'.date('Y').'|max:'.(date('Y')+1),
                'year_end' => 'bail|required|digits:4|integer|gt:year_start|min:'.date('Y').'|max:'.(date('Y')+1),
            ]);
    }
}
