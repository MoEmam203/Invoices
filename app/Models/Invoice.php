<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Invoice extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    public function section(){
        return $this->belongsTo(Section::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function details(){
        return $this->hasMany(Invoice_details::class);
    }

    public function attachments(){
        return $this->hasMany(Invoice_attachment::class);
    }
}
