<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StepRequirement extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function getRequirementAttribute($attribute)
    {
        return [
            1 => 'Adviser',
            2 => 'File',
            3 => 'Panel',
            4 => 'Result',
            5 => 'Schedule',
            6 => 'Topic',
        ][$attribute];
    }

    public function isEmpty()
    {
        $relationship = $this->getRelationship();

//        return !$this->$relationship()->exists();

        if (!$this->$relationship()->exists()) {
            return true;
        } else {
            return abort(403, "Forbidden. $this->requirement already have a content.");
        }
    }

    public function hasCurrentAdviser()
    {
        return $this->requirementFaculties()->whereRole(1)->whereCurrent(1)->count() > 0;
    }

    public function hasCurrentPanel()
    {
        return $this->requirementFaculties()->whereRole(2)->whereCurrent(1)->count() > 0;
    }

    public function hasCurrentFile()
    {
        return $this->requirementFiles()->whereCurrent(1)->count() > 0;
    }

    public function hasCurrentResult()
    {
        return $this->requirementResults()->whereCurrent(1)->count() > 0;
    }

    public function hasCurrentSchedule()
    {
        return $this->requirementSchedules()->whereCurrent(1)->count() > 0;
    }

    public function hasCurrentTopic()
    {
        return $this->requirementTopics()->whereCurrent(1)->count() > 0;
    }


    public function getRelationship()
    {
        switch ($this->requirement) {

            case 'Panel':
            case 'Adviser':
                return 'requirementFaculties';
                break;

            case 'File':
                return 'requirementFiles';
                break;

            case 'Result':
                return 'requirementResults';
                break;

            case 'Schedule':
                return 'requirementSchedules';
                break;

            case 'Topic':
                return 'requirementTopics';
                break;
        }
    }

    /*
     * Relationships
     * */
    public function trackingStep()
    {
        return $this->belongsTo(TrackingStep::class);
    }

    public function requirementFaculties()
    {
        return $this->hasMany(RequirementFaculty::class);
    }

    public function requirementFiles()
    {
        return $this->hasMany(RequirementFile::class);
    }

    public function requirementResults()
    {
        return $this->hasMany(RequirementResult::class);
    }

    public function requirementSchedules()
    {
        return $this->hasMany(RequirementSchedule::class);
    }

    public function requirementTopics()
    {
        return $this->hasMany(RequirementTopic::class);
    }
}
