<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use  App\Http\Requests\StorePost;

class PostsController extends Controller
{

    private $posts = [
        1 => [
            'title' => 'Intro to Laravel',
            'content' => 'This is a short intro to Laravel',
            'is_new' => true,
            'has_comments' => true
        ],
        2 => [
            'title' => 'Intro to PHP',
            'content' => 'This is a short intro to PHP',
            'is_new' => false
        ],
        3 => [
            'title' => 'Intro to Golang',
            'content' => 'This is a short intro to Golang',
            'is_new' => false
        ]
    ];
    
   
    public function index()
    {
        return view('posts.index', ['posts' => BlogPost::all()]);
    }

    
    public function create()
    {
        return view('posts.create');
    }

    
    public function store(StorePost $request)
    {
        
        $validated = $request->validated();  //read the validated data using validated method. (in request class)
        // $post = new BlogPost();
        // $post->title = $validated['title'];
        // $post->content = $validated['content'];
        // $post->save();
        
        $post = BlogPost::create($validated);

        $request->session()->flash('status','The blog post was created!');

        return redirect()->route('posts.show', ['post'=>$post->id]);
    }

    public function show($id)
    {
        // abort_if(!isset($this->posts[$id]), 404);
        // return view('posts.show', [ 'posts'=>$this->posts[$id] ]);
        
        return view('posts.show', ['post' => BlogPost::findOrFail($id)]);
    }

    
    
    public function edit($id)
    {
        return view ('posts.edit', ['post' => BlogPost::findOrFail($id)] );
    }

    
    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);  //return 404 if id not found
        $validated = $request->validated();
        $post->fill($validated); //fill can be used when mass asssignabled and if there's already a model instance
        $post->save();

        $request->session()->flash('status', 'Blog post was updated');
        return redirect()->route('posts.show', ['post'=>$post->id]);
    }

    
    
    public function destroy($id)
    {
        // dd($id);
        $post = BlogPost::findOrFail($id);
        $post->delete();

        session()->flash('status', 'Blog post was deleted!');

        return redirect()->route('posts.index');
    }
}
