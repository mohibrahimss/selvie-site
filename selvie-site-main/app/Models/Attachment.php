<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'file_path',
        'mime_type',
        'size',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachable()
    {
        return $this->morphTo();
    }

    public function getUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    public function getSizeForHumansAttribute()
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $index = 0;

        while ($bytes >= 1024 && $index < count($units) - 1) {
            $bytes /= 1024;
            $index++;
        }

        return round($bytes, 2) . ' ' . $units[$index];
    }

    public function getIconAttribute()
    {
        return match(true) {
            str_contains($this->mime_type, 'image/') => 'photograph',
            str_contains($this->mime_type, 'video/') => 'film',
            str_contains($this->mime_type, 'audio/') => 'musical-note',
            str_contains($this->mime_type, 'application/pdf') => 'document',
            str_contains($this->mime_type, 'application/msword') => 'document-text',
            str_contains($this->mime_type, 'application/vnd.ms-excel') => 'table',
            str_contains($this->mime_type, 'application/zip') => 'archive-box',
            default => 'document',
        };
    }

    public function delete()
    {
        Storage::delete($this->file_path);
        return parent::delete();
    }
} 