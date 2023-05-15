<?php
namespace Vitaliy\PhpPro2\Shorter;

use Illuminate\Database\Eloquent\Model;

class CodeUrlModel extends Model
{
    protected $fillable = ['code', 'url'];
    protected $table = 'code_url';
    public $timestamps = false;

}