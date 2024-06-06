<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name',
        'description',
    ];

    public function contacts()
    {
        return $this->belongsToMany(Contacts::class, 'contact_group', 'groups_id', 'contacts_id');
    }
}
