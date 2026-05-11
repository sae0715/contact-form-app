<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'tag_id',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
