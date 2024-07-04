<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class PostMutator
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver
    }



    public function create($rootvalue, array $args, GraphQLContext $context){
//        dd($args);
        return app()->call('App\Http\Controllers\PostsController@store',[
            'Request' => request()->merge($args),
        ]);
    }

    public function getPosts($rootvalue, array $args, GraphQLContext $context)
    {
        return app()->call('App\Http\Controllers\PostsController@index',[
            'Request' => request()->merge($args),
        ]);
    }

    public function getOnePost($rootvalue, array $args, GraphQLContext $context)
    {
        return app()->call('App\Http\Controllers\PostsController@show',[
            'Request' => request()->merge($args),
        ]);
    }

    public function update($rootvalue, array $args, GraphQLContext $context)
    {
        return app()->call('App\Http\Controllers\PostsController@update',[
            'Request' => request()->merge($args),
        ]);
    }

    public function delete($rootvalue, array $args, GraphQLContext $context)
    {
        return app()->call('App\Http\Controllers\PostsController@destroy',[
            'Request' => request()->merge($args),
        ]);
    }
}
