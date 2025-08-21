<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SchoolSection extends Model
{
    protected $fillable = ['name', 'description', 'category'];

    protected $with = ['topics', 'topics.resources', 'topics.messages', 'topics.messages.attachments', 'topics.messages.reacts', 'topics.messages.highligths'];

    public function topics()
    {
        return $this->hasMany(SchoolTopic::class, 'section_id')->orderBy('order');
    }

    protected static function booted()
    {
        static::deleting(function ($section) {
            foreach ($section->topics as $t) {
                $t->deleteResourceFromDisk();
            }
        });
    }

    public function scopeType($query, $type)
    {
        return $query->where('category', $type);
    }

    public function getTotalTime()
    {
        $id = $this->id;
        return DB::table('school_resources')
            ->join('school_topics', function ($join) use ($id) {
                $join->on('school_resources.topic_id', '=', 'school_topics.id')
                    ->where('school_topics.section_id', $id);
            })
            ->where('school_resources.principal', true)
            ->sum(DB::raw('TRUNCATE(school_resources.duration_number, 0)'));
    }

    public function getTotalTimeAccessByUser($user)
    {
        $topics = SchoolTopic::where('section_id', $this->id)->get();
        $ids = [];
        foreach ($topics as $t) {
            if ($t->hasAccessForUser($user)) {
                $ids[] = $t->id;
            }
        }
        return SchoolResource::whereIn('topic_id', $ids)->where('principal', true)->sum(
            DB::raw('TRUNCATE(duration_number, 0)')
        );
    }

    public function getTotalTimeViewByUser($user)
    {
        $id = $this->id;
        return DB::table('school_users_videos')
            ->join('school_resources', function ($join) {
                $join->on('school_users_videos.resource_id', '=', 'school_resources.id');
            })
            ->join('school_topics', function ($join) use ($id) {
                $join->on('school_resources.topic_id', '=', 'school_topics.id')
                    ->where('school_topics.section_id', $id);
            })
            ->where('school_users_videos.user_id', '=', $user->id)
            ->sum(
                DB::raw('TRUNCATE(school_users_videos.last_time, 0)')
            );
    }

    public function getPercentByUser($user)
    {
        $time_view = $this->getTotalTimeViewByUser($user);
        $time_access = $this->getTotalTimeAccessByUser($user);
        $total_time = $this->getTotalTime();
        if ($total_time == 0) return 0;
        if ($time_access == 0 && $total_time > 0) return 0;
        return ($time_view / $total_time) * 100;
    }

    public function getNameByCategory()
    {
        $name = $this->category;
        switch ($name) {
            case 'conference':
                $name = 'conferencia';
                break;
            case 'learning':
                $name = 'aprender a liberar';
                break;
            case 'reality':
                $name = 'crear la realidad';
                break;
            default:
                $name = 'vivir en plenitud';
                break;
        }
        return $name;
    }
}
