<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class Footer_about_section extends AbstractWidget
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

        return view('widgets.footer_about_section', [
            'config' => $this->config,
        ]);
    }
}
