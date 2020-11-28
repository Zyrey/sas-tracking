<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClusterStudent extends Model
{
    protected $table = 'cluster_student';
    protected $fillable = ['cluster_id','student_id_number'];
    public $timestamps = false;
}
