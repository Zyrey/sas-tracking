<?php

namespace App\Http\Controllers;

use App\Course;
use App\EnrolledCourse;
use App\Faculty;
use App\Http\Requests\StoreFaculty;
use App\Http\Requests\UpdateFaculty;
use App\Institution;
use App\Cluster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ClusterFaculty;
use App\RequirementFaculty;

class FacultyController extends Controller
{
    public function index()
    {
        $faculties = Faculty::with('clusters', 'institution')
            ->orderBy('id_number', 'asc')->paginate(10);

        return view('faculty.index', compact('faculties'));
    }

    public function getFaculties(){
        $faculties = Faculty::with('clusters', 'institution')
            ->get();
        
        return $faculties;
    }

    public function getClusters(){
        $clusters = Cluster::get();
        return $clusters;
    }

    public function saveEditFaculty(Request $request){

        $this->validate($request,[
            'last_name' => 'required',
            'first_name' => 'required',
            'contact_number' => 'required',
            'status' => 'required',
        ]);

        $faculty = Faculty::find($request['id']);
        $faculty->id_number = $request['id_number'];
        $faculty->first_name = $request['first_name'];
        $faculty->middle_name = $request['middle_name'];
        $faculty->last_name = $request['last_name'];
        $faculty->contact_number = $request['contact_number'];
        $faculty->email = $request['email'];
        $faculty->status = $request['status'];
        $faculty->institution_id = $request['institution'];
        $faculty->save();
        $faculty_id = DB::table('cluster_faculty')
        ->where('faculty_id',$request['id'])
        ->delete();
        if(count($request['clusterF'])>0){
            foreach($request['clusterF'] as $req){
                $create_faculty_cluster = ClusterFaculty::Create([
                    'cluster_id' => $req,
                    'faculty_id' => $request['id']
                ]);
            }
        }
        return 'Success';
    }

    public function checkReqFaculty(Request $request){
        $req_fac = RequirementFaculty::where('faculty_id',$request['id'])
        ->join('step_requirements','step_requirements.id','requirement_faculties.step_requirement_id')
        ->select('requirement_faculties.role','step_requirements.tracking_step_id')
        ->get();
        return $req_fac;
    }

    public function newFaculty(Request $request){
        $faculty = Faculty::where('id_number',$request['id_number'])
        ->get();
        $auto_id = Faculty::orderBy('id_number','DESC')
        ->pluck('id_number')
        ->first();
        $auto_id = $auto_id+1;
        $faculty_id = $request['id_number'];
        if($faculty->count()>0){
            return 'This ID Number already exists.';
        }
        if(empty($faculty_id)){
            $faculty_id = $auto_id;
        }
        $new_faculty = Faculty::Create([
            'id_number' => $faculty_id,
            'institution_id' => $request['institution'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'middle_name' => $request['middle_name'],
            'email' => $request['email'],
            'contact_number' => $request['contact_number'],
            'status' => $request['status']
        ]);
        if(count($request['cluster'])>0){
            foreach($request['cluster'] as $req){
                $cluster_new = ClusterFaculty::Create([
                    'cluster_id' => $req,
                    'faculty_id' => $new_faculty->id
                ]);
            }
        }
    }

    public function getInstitutions(){
        $institutions = Institution::get();
        return $institutions;
    }

    public function create(Faculty $faculty)
    {
        $institutions = Institution::orderBy('institution', 'asc')->get();
        $courses = Course::orderBy('course_number')->get(); // needs revision must be dependent on clusters

        return view('faculty.create', compact('faculty', 'institutions', 'courses'));
    }


    public function store(StoreFaculty $request)
    {
        // Create Personal Information of Faculty
        $faculty = Faculty::create($request->except('clusters', 'courses'));

        // Attach clusters
        $faculty->clusters()->sync($request->clusters);
        // Attach courses that can be handled by the faculty
        $faculty->courses()->sync($request->courses);

        return redirect(route('faculties.show', $faculty->id))
            ->with('message', 'Faculty has been created successfully.');
    }


    public function show(Faculty $faculty)
    {
        // Get enrolled courses wherein the faculty is the adviser
        $adviserCourses = EnrolledCourse::whereHas('trackings.trackingSteps.stepRequirements.requirementFaculties', function ($query) use($faculty) {
            return $query->whereHas('stepRequirement.trackingStep.tracking', function ($query) {
                return $query->where('status', 1);
            })
                ->where('faculty_id', $faculty->id)
                ->where('current', 1)
                ->where('role', 1);
        })
            ->get();
        // Group the enrolled courses by their semester_id
        $groupedAdviserCourses = $adviserCourses->groupBy('semester_id');


        // Get enrolled courses wherein the faculty is the panel
        $panelCourses = EnrolledCourse::whereHas('trackings.trackingSteps.stepRequirements.requirementFaculties', function ($query) use($faculty) {
            return $query->whereHas('stepRequirement.trackingStep.tracking', function ($query) {
                return $query->where('status', 1);
            })
                ->where('faculty_id', $faculty->id)
                ->where('current', 1)
                ->where('role', 2);
        })
            ->get();
        // Group the enrolled courses by their semester_id
        $groupedPanelCourses = $panelCourses->groupBy('semester_id');


        return view('faculty.show', compact('faculty', 'groupedAdviserCourses', 'groupedPanelCourses'));
    }


    public function edit(Faculty $faculty)
    {
        $this->authorize('update', $faculty);

        $institutions = Institution::orderBy('institution', 'asc')->get();
        $courses = Course::orderBy('course_number')->get(); // needs revision must be dependent on clusters

        return view('faculty.edit', compact('faculty', 'institutions', 'courses'));
    }


    public function update(Faculty $faculty, UpdateFaculty $request)
    {
        $this->authorize('update', $faculty);

        $faculty->update($request->except('clusters', 'courses'));

        $faculty->clusters()->sync([]);
        $faculty->clusters()->sync($request->clusters);

        $faculty->courses()->sync([]);
        $faculty->courses()->sync($request->courses);

        return redirect(route('faculties.show', $faculty->id))
            ->with('message', "$faculty->fullname has been updated successfully.");
    }


    public function activate(Faculty $faculty)
    {
        $faculty->update([
            'status' => 1,
        ]);

        return back()->with('message', "$faculty->fullname has been activated.");
    }


    public function deactivate(Faculty $faculty)
    {
        $faculty->update([
            'status' => 0,
        ]);

        return back()->with('message', "$faculty->fullname has been deactivated.");
    }


    public function deleteCourse(Faculty $faculty, Course $course)
    {
        $faculty->courses()->detach($course->id);

        return back()->with('message', "$course->fullcourse has been removed.");
    }
}
