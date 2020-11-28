<?php


namespace App\Repositories;


use App\Semester;

class SemesterRepository
{
    public function current()
    {
        // returns the current semester
        return Semester::where('current', 1)->first();
    }
}
