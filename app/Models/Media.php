<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Media extends Model
{
    protected $fillable = [
        'type',
        'title',
        'slug',
        'youtube_id',
        'audio_src',
        'thumbnail',
        'external_url',
        'is_published',
        'position',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'position'     => 'integer',
    ];

    /* -------- Scopes -------- */
    public function scopePublished($q)
    {
        return $q->where('is_published', true);
    }

    public function scopeOrdered($q)
    {
        return $q->orderBy('position')->orderByDesc('published_at')->orderByDesc('id');
    }

    public function scopeYoutube($q)
    {
        return $q->where('type', 'youtube');
    }

    public function scopeAudio($q)
    {
        return $q->where('type', 'audio');
    }

    /* -------- Accessors (helpers) -------- */
    public function getEmbedUrlAttribute(): ?string
    {
        if ($this->type === 'youtube' && $this->youtube_id) {
            return "https://www.youtube.com/embed/{$this->youtube_id}";
        }
        return null;
    }

    public function getWatchUrlAttribute(): ?string
    {
        if ($this->type === 'youtube' && $this->youtube_id) {
            return "https://www.youtube.com/watch?v={$this->youtube_id}";
        }
        return $this->external_url;
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->thumbnail) {
            return Str::startsWith($this->thumbnail, ['http://', 'https://']) ? $this->thumbnail : asset($this->thumbnail);
        }
        if ($this->type === 'youtube' && $this->youtube_id) {
            return "https://i.ytimg.com/vi/{$this->youtube_id}/hqdefault.jpg";
        }
        return null;
    }

    public function getAudioUrlAttribute(): ?string
    {
        if ($this->type === 'audio' && $this->audio_src) {
            return Str::startsWith($this->audio_src, ['http://', 'https://']) ? $this->audio_src : asset($this->audio_src);
        }
        return null;
    }
}
