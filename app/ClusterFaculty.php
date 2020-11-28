<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClusterFaculty extends Model
{
    protected $table = 'cluster_faculty';
    protected $fillable = ['cluster_id','faculty_id'];
    public $timestamps = false;
}
