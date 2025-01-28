<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\ProductService;

class ServicesSection extends AbstractWidget
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
        $service_style = '';
        $service_css = [];

        $query = ProductService::select('product_services.*','product_services.id as ser_id');
        if(isset($this->config['service_count']) && $this->config['service_count'] != null)
        {
            $query->take($this->config['service_count']);
        }
        if(isset($this->config['service_style']) && $this->config['service_style'] != null)
        {
            $service_style = $this->config['service_style'];
        }
        $services = $query->latest()->get();
        // css
        if(isset($this->config['service_title_color']) && $this->config['service_title_color'] != null)
        {
            $service_css['service_title_color'] = $this->config['service_title_color'];
        }
        if(isset($this->config['service_title_hover_color']) && $this->config['service_title_hover_color'] != null)
        {
            $service_css['service_title_hover_color'] = $this->config['service_title_hover_color'];
        }
        if(isset($this->config['service_subtitle_color']) && $this->config['service_subtitle_color'] != null)
        {
            $service_css['service_subtitle_color'] = $this->config['service_subtitle_color'];
        }
        if(isset($this->config['service_subtitle_hover_color']) && $this->config['service_subtitle_hover_color'] != null)
        {
            $service_css['service_subtitle_hover_color'] = $this->config['service_subtitle_hover_color'];
        }

        $data['services'] = $services;
        $data['service_style'] = $service_style;
        $data['service_css'] = $service_css;
        
        return view('widgets.services_section', [
            'config' => $this->config,
            'data' => $data
        ]);
    }
}
