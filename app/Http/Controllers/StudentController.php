<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudent;
use App\Http\Requests\UpdateStudent;
use App\Student;
use Illuminate\Http\Request;
use App\ClusterStudent;

class StudentController extends Controller
{
    public function index(){
        return view('student.index');
    }
    public function list()
    {
        $students = Student::with('clusters')->orderBy('id_number', 'asc')->get();
        // $students = Student::from('clusters as c')
        // ->select('s.id_number', 's.first_name', 's.middle_name', 's.last_name', 's.email','s.contact_number', 's.status', 'c.cluster')
        // ->join('students','s.id_number','=','cluster_student.student_id_number')
        // ->join('clusters','c.id','=','cluster_student.cluster_id')
        // ->where('s.status','1')
        // ->orderBy('s.id_number','asc')
        // ->get();
        // $students = Student::all();
        // return view('student.index', compact('students'));
        return $students;
    }

    public function create(Student $student)
    {
        return view('student.create', compact('student'));
    }


    public function store(Student $request)
    {
        $student = Student::create($request->except('clusters'));
        $student->clusters()->sync($request->clusters);

        // return redirect(route('students.index', $student->id_number))
        //     ->with('message', 'Student created successfully.');
        return $student()->with('message', 'Student created successfully.');
    }

    public function saveEditStudent(Request $request){
        $student_edit = Student::find($request['original_id_number']);
        $student_edit->id_number = $request['id_number'];
        $student_edit->first_name = $request['first_name'];
        $student_edit->last_name = $request['last_name'];
        $student_edit->middle_name = $request['middle_name'];
        $student_edit->email = $request['email'];
        $student_edit->contact_number = $request['contact_number'];
        $student_edit->save();
        foreach($request['cluster'] as $clu){
            $check_cluster = ClusterStudent::where('student_id_number',$request['id_number'])
            ->where('cluster_id',$clu)
            ->get();
            if(!$check_cluster->count()>0){
                $new_cluster = ClusterStudent::Create([
                    'cluster_id' => $clu,
                    'student_id_number' => $request['id_number']
                ]);
            }
        }
        return "Success";
    }

    public function saveNewStudent(Request $request){
        $id = Student::orderBy('id_number','DESC')
        ->pluck('id_number')
        ->first();
        $auto_id = $request['id_number'];
        if(empty($request['id_number'])){
            $auto_id = $id+1;
        }

        if(empty($request['first_name'])){
            foreach($request['cluster'] as $clu){
                $check_cluster = ClusterStudent::where('student_id_number',$request['id_number'])
                ->where('cluster_id',$clu)
                ->get();
                if(!$check_cluster->count()>0){
                    $new_cluster = ClusterStudent::Create([
                        'student_id_number' => $auto_id,
                        'cluster_id' => $clu
                    ]);
                }
            }
        }else{
            $new_student = Student::Create([
                'id_number' => $auto_id,
                'first_name' => $request['first_name'],
                'middle_name' => $request['middle_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
                'contact_number' => $request['contact_number']
            ]);
            foreach($request['cluster'] as $clu){
                $new_cluster = ClusterStudent::Create([
                    'student_id_number' => $auto_id,
                    'cluster_id' => $clu
                ]);
            }
        }
        return $auto_id;
    }

    public function checkIdStudent(Request $request){
        $id_data = Student::where('id_number',$request['id'])
        ->with('clusters')
        ->get();
        return $id_data;
    }

    public function show(Student $student)
    {
        $this->authorize('view', $student);

        return view('student.show', compact('student'));
    }


    public function edit($id_number)
    {
        $this->authorize('update', $id_number);

        return view('student.edit', compact('student'));
    }


    public function update(UpdateStudent $request, Student $student)
    {
        $this->authorize('update', $student);

        $student->update($request->except('clusters'));
        $student->clusters()->sync([]);
        $student->clusters()->sync($request->clusters);

        return redirect(route('students.show', $student->id_number))
            ->with('message', 'Student updated successfully.');
    }


    public function activate(Student $student)
    {
        $student->update([
            'status' => 1,
        ]);

        return back()->with('message', "$student->fullname has been activated.");
    }


    public function deactivate(Student $student)
    {
        $student->update([
            'status' => 0,
        ]);

        return back()->with('message', "$student->fullname has been deactivated.");
    }


    public function updateStatus(Student $student)
    {
        $currentStatus = $student->status;

        if ($currentStatus == 'Active') {
            $newStatus = 0;
        }
        else {
            $newStatus = 1;
        }

        $student->status = $newStatus;
        $student->save();

        return redirect(route('students.show', $student->id_number));
    }
}
