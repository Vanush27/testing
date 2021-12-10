<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use phpDocumentor\Reflection\DocBlock\TagFactory;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

//        $posts = Post::find(1);
//        $tags = Tag::find(1);

//        $posts = Post::where('category_id',$category->id)->get();
//        dd($posts);

//       dd($posts->tags);
//        dd($tags->posts);

        return view('post.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('post.create', compact('categories','tags'));
    }

    public function store()
    {
        $data = request()->validate([
            'title' => 'required|string',
            'content' => 'string',
            'image' => 'string',
            'category_id' => '',
            'tags' => ' ',
        ]);
        $tags = $data['tags'];
        unset($data['tags']);

        $post = Post::create($data);

        $post->tags()->attach($tags);


        return redirect()->route('post.index');

    }

    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('post.edit', compact('post','categories','tags'));
    }

    public function update(Post $post)
    {

        $data = request()->validate([
            'title' => 'string',
            'content' => 'string',
            'image' => 'string',
            'category_id' => '',
            'tags' => '',
        ]);

        $tags = $data['tags'];
        unset($data['tags']);

        $post->update($data);
        $post->tags()->sync($tags);
        return redirect()->route('post.show', $post->id);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('post.index');
    }

    /*
     lesson 5
    public function create()
{
    $postsArr = [
        [
            'title' => 'title of post from phpstorm',
            'content' => 'some interesting content',
            'image' => 'imageblable.jpg',
            'likes' => 20,
            'is_published' => 0,
        ],
        [
            'title' => 'another of post from phpstorm',
            'content' => 'another some interesting content',
            'image' => 'another imageblable.jpg',
            'likes' => 50,
            'is_published' => 1,
        ]
    ];

    foreach ($postsArr as $item) {
        Post::create($item);

    }
    dd('created');
    }



    public function update()
    {

        $post = Post::find(1);
        dd($post->title);

        $post->update(
            [
                'title' => 'up',
                'content' => 'some interesting content',
                'image' => 'imageblable.jpg',
                'likes' => 120,
                'is_published' => 0,
            ]
        );
    }
*/


    public function delete()
    {

        $post = Post::withoutTrashed()->find(2);  //delete in garbage collector
        $post->restore();
        dd($post->title);
//        $post->delete();
    }

    // firstOnCreate
    public function firstOrCreate()
    {
        $anotherPost =
            [
                'title' => 'some post',
                'content' => 'some content',
                'image' => 'some imageblable.jpg',
                'likes' => 20000,
                'is_published' => 1,
            ];

        $post = Post::firstOrCreate(
            ['likes' => 5],
            [
                'title' => 'title 22 of post from phpstorm',
                'content' => 'some content',
                'image' => 'some imageblable.jpg',
                'likes' => 5,
                'is_published' => 1,
            ]);
        dump($post->content);
        dd("finish");

    }

    public function updateOrCreate()
    {
        $anotherPost =
            [
                'title' => 'some post',
                'content' => 'some content',
                'image' => 'some imageblable.jpg',
                'likes' => 20000,
                'is_published' => 1,
            ];

        $post = Post::updateOrCreate(
            ['title' => 'title 22 not of post from phpstorm'],
            [
                'title' => 'update on some post',
                'content' => 'some content',
                'image' => 'update image.jpg',
                'likes' => 451100,
                'is_published' => 1,
            ]);
        dump($post->image);
        dd(222);
    }
}
