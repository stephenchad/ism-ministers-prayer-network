<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'country_id',
        'city_id',
        'address',
        'description',
        'image',
        'user_id',
        'max_members',
        'current_members',
        'status',
        'category_id',
        'group_type_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function group_type()
    {
        return $this->belongsTo(GroupType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'group_user');
    }

    public function leaders()
    {
        return $this->belongsToMany(User::class, 'group_leader', 'group_id', 'user_id');
    }

    public function rules()
    {
        return $this->hasMany(GroupRule::class);
    }

    public function events()
    {
        return $this->hasMany(GroupEvent::class);
    }

    public function photos()
    {
        return $this->hasMany(GroupPhoto::class);
    }

    public function resources()
    {
        return $this->hasMany(GroupResource::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
