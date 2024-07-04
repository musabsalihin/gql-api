<?php

namespace App\GraphQL\Mutations;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CreatePost
{
    public function __invoke(null $_, array $args){

    }

    /** @param  array{}  $args */
    public function create($rootvalue, array $args, GraphQLContext $context){
//        dd($args);
        return app()->call('App\Http\Controllers\PostsController@store',[
            'Request' => request()->merge($args),
        ]);
    }
}
