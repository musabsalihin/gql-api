<?php

namespace App\Http\Controllers;

use app\Http\Requests\PostCreateRequest;
use App\Models\Posts;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $posts = Posts::all();
        foreach ($posts as $post) {
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'post_title' => 'required',
            'post_description' => 'required',
            'post_publish_date' => 'required',
            'post_status' => 'required',
        ]);
        $title = [
            'default' => $request['post_title'],
            'bm' => $request['bm_title'],
            'en' => $request['en_title'],
            'cn' => $request['cn_title'],
        ];
        $data['post_title'] = $title;
//        dd($data);
        $post = Posts::create($data);

        return "Created Successfully";
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
        $post = Posts::firstWhere('id', $request['id']);

        return $post;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $post = Posts::firstWhere('id', $request['id']);

//        $data = $request->validate([
//            'post_description' => 'string, min:10',
//            'post_status' => 'string',
//            'post_publish_date' => 'date',
//        ]);
        if (isset($request['post_description'])) {
            $post->post_description = $request['post_description'];
        }
        if (isset($request['post_status'])) {
            $post->post_status = $request['post_status'];
        }
        if (isset($request['post_publish_date'])) {
            $post->post_publish_date = $request['post_publish_date'];
        }
        $post->save();

        return [
            'status' => "Updated Successfully",
            'post' => $post
        ];

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $post = Posts::firstWhere('id', $request['id']);
        $post->delete();

        return [
            'status' => "Deleted Successfully",
        ];
    }
}
