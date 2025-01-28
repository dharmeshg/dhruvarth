<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\Article;

class Posts extends AbstractWidget
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
        $post_style = '';
        $post_column = '';
        $query = Article::select('articles.*','articles.id as art_id');
        if(isset($this->config['post_type']) && $this->config['post_type'] != null && $this->config['post_type'] == '0')
        {
            $query->latest();
        } 
        if(isset($this->config['post_type']) && $this->config['post_type'] != null && $this->config['post_type'] == '1')
        {
            $query->where('is_featured',1);
        }
        if(isset($this->config['post_type']) && $this->config['post_type'] != null && $this->config['post_type'] == '2')
        {
            if(isset($this->config['post_category']) && $this->config['post_category'] != null)
            {
               $categoryIds = explode(',', $this->config['post_category']);
                 $query->where(function ($query) use ($categoryIds) {
                    foreach ($categoryIds as $categoryId) {
                        $query->orWhereRaw("FIND_IN_SET(?, category_id)", [$categoryId]);
                    }
                });
            }
        }
        if(isset($this->config['post_count']) && $this->config['post_count'] != null)
        {
            $query->take($this->config['post_count']);
        }
        if(isset($this->config['post_style']) && $this->config['post_style'] != null)
        {
            $post_style = $this->config['post_style'];
        }
        if(isset($this->config['post_column']) && $this->config['post_column'] != null)
        {
            $post_column = $this->config['post_column'];
        }
        $article = $query->get();
        
        $data['articles'] = $article;
        $data['post_style'] = $post_style;
        $data['post_column'] = $post_column;

        return view('widgets.recent_posts', [
            'config' => $this->config,
            'data' => $data
        ]);
    }
}
