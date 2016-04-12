<?php

namespace SdcProject\Entities;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {
    protected $fillable = [
        'owner_id',
        'client_id',
        'name',
        'description',
        'progress',
        'status',
        'due_date'
    ];

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function owner() {
        return $this->belongsTo(User::class);
    }

    public function projectTasks() {
        return $this->hasMany(ProjectTask::class);
    }

    public function projectMembers() {
        return $this->belongsToMany(User::class, 'project_members');
    }

    public function files() {
        return $this->hasMany(ProjectFile::class);
    }

}
