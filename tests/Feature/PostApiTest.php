<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use App\Models\Posts;
use App\Models\User;
use function PHPUnit\Framework\isNull;

class PostApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_all_post_can_be_retrieved(): void
    {
            $query = "{
                getPosts{
                    post_title{
                        en
                        default
                    }
                    post_status
                    post_description
                    post_publish_date
                }
            }";
            $user = User::factory()->create();

            $response = $this->actingAs($user)->graphQL($query);

//            dd($response);
            $response->assertStatus(200)->assertJsonStructure([
                'data' => [
                    'getPosts' => [
                        '*' => [
                            'post_title' => [
                                'default',
                                'en',
                            ],
                            'post_status',
                            'post_description',
                            'post_publish_date'
                        ]
                    ]
                ]
            ]);

            $user->delete();
    }

    public function test_one_post_can_be_found()
    {

        $post = Posts::factory()->create();
        $user = User::factory()->create();
        $query = "{
                    post(id: " . $post->id . "){
                        post_title{
                            en
                            default
                        }
                    post_status
                    post_description
                    post_publish_date
                    }
                }";

        $response = $this
            ->actingAs($user)
            ->graphQL($query);

        $response->assertJsonStructure([
            'data' => [
                'post' => [
                    'post_title' => [
                        'default',
                        'en',
                    ],
                    'post_status',
                    'post_description',
                    'post_publish_date',
                ]
            ]
        ]);

        $post->delete();
        $user->delete();
    }

    public function test_post_can_be_created()
    {
        $post = Posts::factory()->make();
        $user = User::factory()->create();

        $query = '
        mutation ($title: String!, $status: String!, $description: String!, $date: Date!) {
            postCreate(
                input:
                {
                bm_title: "",
                en_title: $title,
                cn_title: "",
                post_title: $title,
                post_description: $description,
                post_status: $status,
                post_publish_date: $date,
                }
            )
        }
        ';

        $response = $this->actingAs($user)->graphQL($query, [
            'title' => $post->post_title['default'],
            'status' => $post->post_status,
            'description' => $post->post_description,
            'date' => $post->post_publish_date->format('Y-m-d'),
        ]);

        $this->assertDatabaseHas('posts', [
            'post_description' => $post->post_description,
        ]);

        $created_post = Posts::firstWhere('post_description', $post->post_description);

        $created_post->delete();

        $response->assertJsonFragment([
            'postCreate' => 'Created Successfully'
        ]);


        $user->delete();
    }

    public function test_invalid_input_post_cannot_be_created()
    {
        $post = Posts::factory()->make();
        $user = User::factory()->create();

        $query = '
        mutation ($title: String!, $status: String!, $description: String!, $date: Date!) {
        postCreate(
            input:{
                bm_title: "",
                en_title: $title,
                cn_title: "",
                post_title: "",
                post_description: $description,
                post_status: $status,
                post_publish_date: $date,
            }
            )
        }
    ';
        $response = $this->actingAs($user)->graphQL($query, [
            'title' => $post->post_title['default'],
            'status' => $post->post_status,
            'description' => $post->post_description,
            'date' => $post->post_publish_date->format('Y-m-d'),
        ]);



        $this->assertDatabaseMissing('posts', [
            'post_description' => $post->post_description,
        ]);
        $created_post = Posts::firstWhere('post_description', $post->post_description);
        if(isset($created_post)){
            $created_post->delete();
        }
        $user->delete();
    }

    public function test_post_description_can_be_updated()
    {
        $post = Posts::factory()->create();
        $user = User::factory()->create();
        $new_post = Posts::factory()->make();

        $this->assertModelExists($post);

        $query = '
            mutation ($id:ID!, $description: String!) {
                    updatePost(
                    input:{
                        id: $id,
                        post_description: $description
                    })
                    {
                    status
                        post{
                            id
                            post_title{
                            default
                            }
                            post_description
                    }
                }
            }
        ';

        $response = $this->actingAs($user)->graphQL($query, [
            'id' => $post->id,
            'description' => $new_post->post_description,
        ]);

        $this->assertDatabaseHas('posts', [
            'post_description' => $new_post->post_description,
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'updatePost' => [
                    'status',
                    'post' =>[
                        'id',
                    'post_title' => [
                        'default',
                    ],
                    'post_description',
                        ]
                ]
            ]
        ]);

        $post->delete();
        $user->delete();
    }
    public function test_invalid_input_post_description_cannot_be_updated()
    {
        $post = Posts::factory()->create();
        $user = User::factory()->create();
        $new_post = Posts::factory()->make();

        $this->assertModelExists($post);

        $query = '
            mutation ($id:ID!, $description: String!) {
                updatePost(
                input:{
                    id: $id,
                    post_description: $description
                })
                {
                status
                    post{
                        id
                        post_title{
                            default
                        }
                        post_description
                    }
                }
            }
        ';

        $response = $this->actingAs($user)->graphQL($query, [
            'id' => $post->id,
            'description' => '',
        ]);

        $this->assertDatabaseMissing('posts', [
            'post_description' => $new_post->post_description,
        ]);

//        Log::info($response);
//        $response->assertInvalid('post_description');

//        $response->assertStatus(200)->assertJsonStructure([
//            'data' => [
//                'updatePost' => [
//                    'status',
//                    'post' =>[
//                        'id',
//                        'post_title' => [
//                            'default',
//                        ],
//                        'post_description',
//                    ]
//                ]
//            ]
//        ]);

        $post->delete();
        $user->delete();
    }


    public function test_post_can_be_deleted()
    {
        $post = Posts::factory()->create();
        $user = User::factory()->create();

        $this->assertModelExists($post);

        $query = '
        mutation ($id: ID!) {
                deletePost(id: $id){
                    status
                }
            }
        ';

        $response = $this->actingAs($user)->graphQL($query, [
            'id' => $post->id,
        ]);

        $this->assertModelMissing($post);
//        dd($response);
        $response->assertStatus(200)->assertJsonFragment([
            'status' => 'Deleted Successfully'
        ]);
        $user->delete();
    }
}
