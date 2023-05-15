<?php
namespace Vitaliy\PhpPro2\Shorter;

use InvalidArgumentException;
use Vitaliy\PhpPro2\Shorter\CodeUrlModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Vitaliy\PhpPro2\Shorter\Interfaces\ICodeStorageInterface;


class CodeDbStorage  implements ICodeStorageInterface

{

    public function save(string $code, string $url): void
    {


         CodeUrlModel::create([
            'code' => $code,
            'url' => $url
        ]);
    }

    public function find(string $code): ?string
    {
        $pair = CodeUrlModel::where('code', $code)->first();
        if($pair === NULL){
            throw new InvalidArgumentException('Not found');
        }
        return $pair->url;

    }
}
