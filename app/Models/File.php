<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $driver
 * @property string $folder
 * @property string $file_name
 * @property string $file_original_name
 */
class File extends Model
{
    /** @use HasFactory<\Database\Factories\FileFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'driver',
        'folder',
        'file_name',
        'file_original_name',
    ];

    public function getFilePath(): string
    {
        return "{$this->folder}/{$this->file_name}";
    }

    public function getPathOfXmlFiles(): string
    {
        return "{$this->folder}/xmls";
    }

    public function getPathOfExtractedFiles(): string
    {
        return "{$this->folder}/extracted";
    }
}
