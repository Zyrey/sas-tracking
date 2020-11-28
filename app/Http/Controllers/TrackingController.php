<?php

namespace App\Http\Controllers;

use App\Comment;
use App\EnrolledCourse;
use App\Enrollment;
use App\Http\Requests\StoreComment;
use App\Http\Requests\StoreTracking;
use Illuminate\Http\Request;
use App\Step;
use App\TrackingStep;
use App\Student;
use App\Tracking;
use App\StepRequirement;
use App\Faculty;
use App\RequirementFaculty;
use App\RequirementTopic;
use App\RequirementSchedule;
use App\RequirementResult;

class TrackingController extends Controller
{
    public function index(Student $student, Enrollment $enrollment ,EnrolledCourse $enrolledCourse)
    {
        // Eager loading
        $enrolledCourse->load('comments', 'trackings.trackingSteps');

        return view('tracking.index', compact('student', 'enrollment', 'enrolledCourse'));
    }

    public function trackEnrollment(Request $request){
        $enrolled = Student::join('enrollments','enrollments.student_id_number','students.id_number')
        ->join('enrolled_courses','enrolled_courses.enrollment_id','enrollments.id')
        ->join('semesters','enrolled_courses.semester_id','semesters.id')
        ->join('programs','enrollments.program_id','programs.id')
        ->where('enrolled_courses.id',$request['id'])
        ->select('students.first_name','students.last_name','students.middle_name','students.id_number','semesters.year_end','semesters.year_start','semesters.term','programs.program','enrolled_courses.enrollment_id','enrolled_courses.enrollment_status','enrolled_courses.course_status','enrolled_courses.grade')
        ->groupBy('enrolled_courses.semester_id','students.id_number')
        ->get();
        $e_courses = EnrolledCourse::join('courses','courses.id','enrolled_courses.course_id')
        ->join('course_levels','course_levels.id','courses.course_level_id')
        ->select('courses.course_number','courses.descriptive_title','course_levels.course_level','enrolled_courses.course_status','enrolled_courses.enrollment_status','enrolled_courses.id','enrolled_courses.created_at','enrolled_courses.updated_at')
        ->where('enrolled_courses.id',$request['id'])
        ->get();
        
        return ['student'=>$enrolled,'courses'=>$e_courses];
    }

    public function getExternalPanel(){
        $external = Faculty::join('institutions','institutions.id','faculties.institution_id')
        ->where('institutions.type','2')
        ->select('faculties.id','faculties.institution_id','faculties.id_number','faculties.first_name','faculties.middle_name','faculties.last_name','faculties.email','faculties.contact_number','faculties.status')
        ->get();
        return $external;
    }

    public function getInternalPanel(){
        $internal = Faculty::join('institutions','institutions.id','faculties.institution_id')
        ->where('institutions.type','1')
        ->select('faculties.id','faculties.institution_id','faculties.id_number','faculties.first_name','faculties.middle_name','faculties.last_name','faculties.email','faculties.contact_number','faculties.status')
        ->get();
        return $internal;
    }

    public function getTrack(Request $request){
        $trackList = Tracking::where('enrolled_course_id',$request['id'])
        ->orderBy('status','DESC')
        ->get();
        return ['trackList'=>$trackList];
    }

    public function enrollmentStatus(Request $request){
        $status = EnrolledCourse::where('id',$request['id'])
        ->pluck('enrollment_status');
        if($status[0]=="Dropped" || $status[0]=="Withdrawn" || $status[0]=="Completed"){
            return 1;
        }
        return 0;
    }

    public function getTrackData(Request $request){
        $track = Tracking::where('trackings.id',$request['id'])
        ->get();
        $track_steps = Tracking::where('trackings.id',$request['id'])
        ->join('tracking_steps','tracking_steps.tracking_id','trackings.id')
        ->select('tracking_steps.step_name','tracking_steps.status','tracking_steps.complete')
        ->get();
        return ['track_data'=>$track,'track_steps'=>$track_steps];
    }

    public function deactivateTrack(Request $request){
        $track = Tracking::find($request['id']);
        $track->status=0;
        $track->save();
        return $track;
    }

    public function activateTrack(Request $request){
        $track = Tracking::where('id',$request['id'])
        ->pluck('enrolled_course_id');
        $getAllTrack = Tracking::where('enrolled_course_id',$track)
        ->where('id','!=',$request['id'])
        ->where('status','1')
        ->pluck('id');
        if($getAllTrack->count()>0){
            $close_track = Tracking::find($getAllTrack[0]);
            $close_track->status=0;
            $close_track->save();
        }
        $activate_track = Tracking::find($request['id']);
        $activate_track->status=1;
        $activate_track->save();
        return 'Success';
    }

    public function getStepsPerTrack(Request $request){
        $steps = TrackingStep::where('tracking_id',$request['id'])
        ->orderBy('status','DESC')
        ->get();
        return $steps;
    }

    public function viewStep(Request $request){
        $id = $request['id'];
        return view('enrollment.viewStep', compact('id'));
    }

    public function getStepData(Request $request){
        $step_data = TrackingStep::where('id',$request['id'])
        ->get();
        $step_requirements = StepRequirement::where('tracking_step_id',$request['id'])
        ->get();
        $track_id = TrackingStep::where('id',$request['id'])
        ->pluck('tracking_id');
        $track_status = Tracking::where('trackings.id',$track_id)
        ->join('enrolled_courses','enrolled_courses.id','trackings.enrolled_course_id')
        ->select('trackings.status','trackings.enrolled_course_id','enrolled_courses.enrollment_status')
        ->get();
        return ['step_data'=>$step_data,'step_req'=>$step_requirements,'track_status'=>$track_status];
    }

    public function completeStep(Request $request){
        $step_data = TrackingStep::find($request['id']);
        $step_data->complete = '1';
        $step_data->save();
        return $step_data;
    }

    public function incompleteStep(Request $request){
        $step_data = TrackingStep::find($request['id']);
        $step_data->complete = '0';
        $step_data->save();
        return $step_data;
    }

    public function duplicateStep(Request $request){
        $step_data = TrackingStep::find($request['id']);
        $replicate = $step_data->replicate();
        $replicate->take_number = $replicate->take_number+1;
        $replicate->save();
        $old_step = TrackingStep::find($request['id']);
        $old_step->status=0;
        $old_step->save();
        $get_step_reqs = StepRequirement::where('tracking_step_id',$request['id'])
        ->pluck('id');
        $test = 0;
        if($get_step_reqs->count()>0){
            foreach($get_step_reqs as $g){
                $find_req = StepRequirement::find($g);
                $rep = $find_req->replicate();
                $rep->tracking_step_id=$replicate->id;
                $rep->save();  
            }
        }
        return $replicate->id;
    }

    public function getSchedReq(Request $request){
        $req_sched = RequirementSchedule::where('step_requirement_id',$request['id'])
        ->get();
        return $req_sched;
    }

    public function saveRes(Request $request){
        $save_res = RequirementResult::Create([
            'step_requirement_id' => $request['requirement_id'],
            'result' => $request['r_result'],
            'remarks' => $request['r_remarks']
        ]);
        return "Success";
    }

    public function getResultReq(Request $request){
        $res_req = RequirementResult::where('step_requirement_id',$request['id'])
        ->get();
        return $res_req;
    }

    public function deacStep(Request $request){
        $step_data = TrackingStep::find($request['id']);
        $step_data->status = '0';
        $step_data->save();
        return $step_data;
    }

    public function saveFile(Request $request){
        return $request;
    }

    public function activateStep(Request $request){
        $step_data = TrackingStep::find($request['id']);
        $step_data->status = '1';
        $step_data->save();
        return $step_data;
    }

    public function saveSched(Request $request){
        $save_sched = RequirementSchedule::Create([
            'step_requirement_id' => $request['requirement_id'],
            'date' => $request['s_date'],
            'start_time' => $request['s_start'],
            'end_time' => $request['s_end'],
            'room' => $request['s_room']
        ]);
        return "Success";
    }

    public function deleteStep(Request $request){
        $tracking_id = TrackingStep::join('trackings','trackings.id','tracking_steps.tracking_id')
        ->where('tracking_steps.id',$request['id'])
        ->pluck('trackings.enrolled_course_id');
        $step_data = TrackingStep::find($request['id']);
        $step_data->delete();
        return $tracking_id[0];
    }

    public function saveEditStep(Request $request){
        $check = StepRequirement::where('tracking_step_id',$request['tracking_step_id'])
        ->get();;
        if($check->count()>0){
            $old_req = StepRequirement::where('tracking_step_id',$request['tracking_step_id'])
            ->delete();
        }
        $requirements = $request['requirements'];
        $new_req = StepRequirement::create([
            'tracking_step_id' => $request['tracking_step_id'],
            'requirement' => $requirements
        ]);
        return $request;
    }

    public function deleteReq(Request $request){
        $requirement = StepRequirement::where('id',$request['id'])->
        delete();
        return "Deleted";
    }

    public function getAdvisers(){
        $faculty = Faculty::get();
        return $faculty;
    }

    public function saveAdviser(Request $request){
        $req_adviser = RequirementFaculty::Create([
            'step_requirement_id' => $request['requirement_id'],
            'faculty_id' => $request['a_adviser'],
            'role' => 1
        ]);
        return "Success";
    }

    public function savePanel(Request $request){
        $req_panel = RequirementFaculty::Create([
            'step_requirement_id' => $request['requirement_id'],
            'faculty_id' => $request['e_panel'],
            'role' => 2
        ]);
        $req_panel = RequirementFaculty::Create([
            'step_requirement_id' => $request['requirement_id'],
            'faculty_id' => $request['i_panel'],
            'role' => 2
        ]);
        return "Success";
    }

    public function saveTopic(Request $request){
        $req_topic = RequirementTopic::Create([
            'step_requirement_id' => $request['requirement_id'],
            'topic' => $request['topic'],
            'remarks' => $request['t_remarks']
        ]);
        
        return "Success";
    }

    public function getFacultyReq(Request $request){
        $req_faculty = RequirementFaculty::where('step_requirement_id',$request['id'])
        ->join('faculties','faculties.id','requirement_faculties.faculty_id')
        ->select('faculties.first_name','faculties.middle_name','faculties.last_name','faculties.contact_number','faculties.email')
        ->get();
        return $req_faculty;
    }

    public function getTopicReq(Request $request){
        $req_topic = RequirementTopic::where('step_requirement_id',$request['id'])
        ->get();
        return $req_topic;
    }

    public function saveNewStep(Request $request){
        $tracking = Tracking::where('enrolled_course_id',$request['id'])
        ->where('status','1')
        ->pluck('id');
        if($tracking->count()>0){
            $newStep = TrackingStep::create([
                'tracking_id' => $tracking[0],
                'step_number' => $request['step_number'],
                'step_name' => $request['step']
            ]);
            $newStep->save();
            $nId=$newStep->id;
            if(!empty($request['requirements'])){
                $newStepReq = StepRequirement::create([
                    'tracking_step_id' => $nId,
                    'requirement' => $request['requirements']
                ]);
            }
        };
        return 'Success';
    }

    public function newTracking(Request $request){
        $getAllTrack = Tracking::where('enrolled_course_id',$request['id'])
        ->where('status','1')
        ->pluck('id');
        if($getAllTrack->count()>0){
            $close_track = Tracking::find($getAllTrack[0]);
            $close_track->status=0;
            $close_track->save();
        }
        $newTrack = Tracking::create([
            'enrolled_course_id' => $request['id'],
            'status' => '1'
        ]);
        return $newTrack;
    }
    // public function index()
    // {
    //     // Eager loading
    //     // $enrolledCourse->load('comments', 'trackings.trackingSteps');

    //     return view('tracking.index');
    // }


    public function store(Student $student, Enrollment $enrollment ,EnrolledCourse $enrolledCourse)
    {
        $this->validateAction($enrolledCourse);

        // Before creating a new Tracking, it will check if there is an active Tracking.
        // It will set the active to inactive because only one Tracking can be active
        $this->deactivateActiveTrackings($enrolledCourse);

        // Create a tracking for the enrolled course with a default status of active
        $tracking = $enrolledCourse->trackings()->create();
        // Get all the steps of the course's level

        $courseLevel = $enrolledCourse->course->courseLevel;
        $steps = Step::with('requirements')->where('course_level_id', $courseLevel->id)->get();

        // Store step and its requirements
        if ($steps->count() > 0) {
            foreach ($steps as $step) {
                $trackingStep = $tracking->trackingSteps()->create([
                    'step_name' => $step->step,
                    'step_number' => $step->step_number,
                    'default' => 1
                ]);
                foreach ($step->requirements as $requirement) {
                    $trackingStep->stepRequirements()->create([
                        'requirement' => $requirement->getAttributes()['requirement']
                    ]);
                }
            }
        }

        return redirect(route('trackings.index', [$student->id_number, $enrollment->id, $enrolledCourse->id]))
            ->with('message', 'Tracking created successfully.');
    }


    public function show(Student $student, Enrollment $enrollment ,EnrolledCourse $enrolledCourse, Tracking $tracking)
    {
        $tracking->load('trackingSteps', 'comments');

        return view('tracking.show', compact('student', 'enrollment', 'enrolledCourse', 'tracking'));
    }


    public function activate(Student $student, Enrollment $enrollment ,EnrolledCourse $enrolledCourse, Tracking $tracking)
    {
        $this->validateAction($enrolledCourse);

        // Before creating a new Tracking, it will check if there is an active Tracking.
        // It will set the active to inactive because only one Tracking can be active
        $this->deactivateActiveTrackings($enrolledCourse);

        $tracking->update([
            'status' => 1,
        ]);

        return back()->with('message', 'Tracking has been activated.');
    }


    public function deactivate(Student $student, Enrollment $enrollment ,EnrolledCourse $enrolledCourse, Tracking $tracking)
    {
        $this->validateAction($enrolledCourse);

        $tracking->update([
            'status' => 0,
        ]);

        return back()->with('error', 'Tracking has been deactivated.');
    }


    public function storeComment(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, StoreComment $request)
    {
        $this->validateAction($enrolledCourse);
        // Prevent action if tracking is inactive
        if (!$tracking->isActive()) {
            abort(403, 'This action is forbidden. Tracking is inactive.');
        }

        $this->createComment($tracking, $request);

        return back()->with('message', 'Comment Saved!');
    }


    public function deleteComment(Student $student, Enrollment $enrollment, EnrolledCourse $enrolledCourse, Tracking $tracking, Comment $comment)
    {
        $this->validateAction($enrolledCourse);
        // Prevent action if tracking is inactive
        if (!$tracking->isActive()) {
            abort(403, 'This action is forbidden. Tracking is inactive.');
        }

        $comment->delete();
        return back()->with('message', 'Comment Deleted!');
    }


    private function createComment($tracking, $request)
    {
        $tracking->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);
    }


    private function deactivateActiveTrackings($enrolledCourse)
    {
        $enrolledCourse->trackings()->whereStatus(1)->update([
            'status' => 0,
        ]);
    }


    private function validateAction($enrolledCourse)
    {
        // If not in current semester, updating enrolled course details is forbidden
        if (!$enrolledCourse->semester->isCurrent()) {
            abort(403, 'Action is forbidden. You are not in the current semester.');
        }

        // Prevent access if the enrollment status is not set as enrolled or incomplete.
        if (!$enrolledCourse->isEditable()) {
            abort(403, 'Action is Forbidden. Only enrolled and incomplete courses can be edited.');
        }
    }
}
