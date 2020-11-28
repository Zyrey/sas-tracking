<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgram;
use App\Http\Requests\UpdateProgram;
use App\Program;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProgramController extends Controller
{
    public function index()
    {
        return view('program.index');
    }

    public function list(){
        $programs = Program::with('cluster')->orderBy('program')->get();
        return $programs;
    }


    public function create(Program $program)
    {
        return view('program.create', compact('program'));
    }

    public function createProgram(Request $request){
        $new_program = Program::create([
            'program' => $request['program'],
            'cluster_id' => $request['cluster_id'],
            'type' => $request['type']
        ]);
        return 'Created';
    }

    public function saveProgram(Request $request){
        $edit_program = Program::find($request['id']);
        $edit_program->program = $request['program'];
        $edit_program->cluster_id = $request['cluster_id'];
        $edit_program->type = $request['type'];
        $edit_program->save();
        return 'SUCCESS';
    }

    public function store(Request $request)
    {
        $request->validate([
            'cluster_id' => 'required|exists:clusters,id',
            'type' => 'required|integer|between:1,2',
            'program' => 'required|string|min:3|max:225|regex:/^[A-Za-z\s\-_\.\,]+$/|unique:programs,program'
        ]);

        $program = Program::create($request->all());

        return redirect(route('programs.show', $program->id))
            ->with('message', 'Program has been created successfully.');
    }


    public function show(Program $program)
    {
        $this->authorize('view', $program);

        return view('program.show', compact('program'));
    }


    public function edit(Program $program)
    {
        $this->authorize('update', $program);

        return view('program.edit', compact('program'));
    }


    public function update(Request $request, Program $program)
    {
        $this->authorize('update', $program);

        $request->validate([
            'cluster_id' => 'required|exists:clusters,id',
            'type' => 'required|integer|between:1,2',
            'program' => [
                'required', 'string', 'min:3', 'max:225', 'regex:/^[A-Za-z\s\-_\.\,]+$/',
                Rule::unique('programs')->ignore($program->id),
            ]
        ]);

        $program->update($request->all());

        return redirect(route('programs.show', $program->id))
            ->with('message', 'Program has been updated successfully.');
    }

}
