<?php declare(strict_types=1);

namespace App\GraphQL\Queries;
use App\Models\Posts;

class GetPosts
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver
        $posts = Posts::all();
        foreach($posts as $post){
            $title = $post->post_title;

            $data = [
                'default' => $title['default'],
                'en' => $title['en'],
                'bm' => $title['bm'],
                'cn' => $title['cn']
            ];

            $post->post_title = $data;
        }

        return $posts;
    }
}
