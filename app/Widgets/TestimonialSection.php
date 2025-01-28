<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\Testimonial;

class TestimonialSection extends AbstractWidget
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
        $query = Testimonial::where('is_featured', 1)->latest();
        if(isset($this->config['testimonial_count']) && $this->config['testimonial_count'] != null)
        {
            $query->take($this->config['testimonial_count']);
        }else {
        $query->orderBy('id', 'desc');
        }
        $testimonial = $query->get();
        $data['testimonials'] = $testimonial;

        return view('widgets.testimonial_section', [
            'config' => $this->config,
            'data' => $data
        ]);
    }
}
