<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\ProjectGallery;

class OurGallery extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        //
        // dd($this->config);
        $query = ProjectGallery::where('is_publish', 1)->latest();
        if(isset($this->config['gallery_count']) && $this->config['gallery_count'] != null)
        {
            $query->take($this->config['gallery_count']);
        }else {
        $query->take(5);
        }
        $gallery = $query->get();

        $data['gallery'] = $gallery;

        return view('widgets.our_gallery', [
            'config' => $this->config,
            'data' => $data
        ]);
    }
}
