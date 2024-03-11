<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Posts;

class CreatePost
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {

        // $args['post_publish_date'] = $args['post_publish_date']."T00:00:00.000Z";
        // TODO implement the resolver

        $title = [
            'default' => $args['post_title'],
            'bm' => $args['bm_title'],
            'en' => $args['en_title'],
            'cn' => $args['cn_title'],
        ];
        $post = Posts::create([
            'post_title' => $title,
            // 'slug' => $args['post_title'],
            'post_description' => $args['post_description'],
            'post_publish_date' => $args['post_publish_date'],
            'post_status' => $args['post_status'],
        ]);


        return "Post has been saved";
    }
}
