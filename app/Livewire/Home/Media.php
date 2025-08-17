<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Media as MediaModel;

class Media extends Component
{
    public array $items = [];

    public function mount(): void
    {
        $this->items = MediaModel::published()
            ->ordered()
            ->take(8)
            ->get()
            ->map(function ($m) {
                if ($m->type === 'youtube') {
                    return [
                        'type'  => 'youtube',
                        'id'    => $m->youtube_id,
                        'title' => $m->title,
                    ];
                }
                if ($m->type === 'audio') {
                    return [
                        'type'  => 'audio',
                        'src'   => $m->audio_url ?? $m->audio_src, 
                        'title' => $m->title,
                    ];
                }
                return null;
            })
            ->filter()
            ->values()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.home.media');
    }
}
