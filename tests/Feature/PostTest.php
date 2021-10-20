<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\BlogPost;


class PostTest extends TestCase
{
    use RefreshDatabase;  //run database migrations to each test run
    

    public function testNoBlogPostWhenNothingInDatabase()
    {
        $response = $this->get('/posts');
        $response->assertSeeText('Laravel App');
        // $this->assertTrue(true);
    }

    public function testSee1BlogPostWhenThereIs1()
    {
        //Arrange. arrange what we would like to test
        $post = new BlogPost();
        $post->title = 'New post';
        $post->content = 'Content of the blog post';
        $post-> save();
        
        //Act. fetching the list of blog posts
        $response = $this->get('/posts');

        //Assert. verifying that we can see the title of the blog post on the page
        $response->assertSeeText('New post');

        // $this->assertDatabaseHas('blog_posts', [
        //     'title' => 'New'
        // ]);

    }

    // public function testStoreValid()
    // {
    //     $this->withoutExceptionHandling();
    //     $params = [
    //         'title' => 'Valid title',
    //         'content' => 'At least 10 characters',
    //         '_token' => 'test'
    //     ];


    //     $this->withSession(['_token' => 'test'])
    //         ->post('/posts', $params)
    //         ->assertStatus(302)
    //         ->assertSessionHas('status');

    //     $this->assertEquals(session('status'), 'Blog post was created!');
    // }

    public function testStoreFail(){
        $params = [
            'title' => 'x',
            'content' => 'x'
        ];

        $this->post('/posts',$params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

            // $messages = session('errors');
            // dd($messages->getMessage());

        $messages = session('errors')->getMessages();

        $this->assertEquals($messages['title'][0],'The title must be at least 3 characters.');  //[0] stands for first element of message
        $this->assertEquals($messages['content'][0], 'The content must be at least 3 characters.');
    }

    public function testUpdateValid()
    {
        $post = new BlogPost();
        $post->title = 'New title';
        $post->content = 'Content of the blog post';
        $post-> save();

        
      //  $this->assertDatabaseHas('blog_posts', $post->toArray());

        $params = [
            'title' => 'A new named title',
            'content' => 'Content was changed'
        ];

        $this->put('/posts/{$post->id}',$params)
        ->assertStatus(302)
        ->assertSessionHas('status');

        $this->assertEquals(session('status'),'Blog post was updated');
        $this->assertDatabaseMissing('blog_posts', $post->toArray());

        $this->assertDatabaseHas('blog_posts',[
            'title' => 'A new named title'
        ]);
    }

    public function testDelete()
    {
        $post = $this->createDummyBlogPost();
        $this->assertDatabaseHas('blog_posts', $post->toArray());

        $this->delete('/posts/{$post->id}')
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was deleted!');
        $this->assertDatabaseMissing('blog_posts', $post->toArray());
    }

    private function createDummyBlogPost(): BlogPost
    {
        $post = new BlogPost();
        $post->title = 'New title';
        $post->content = 'Content of the blog post';
        $post->save();

        return $post;
    }
}
