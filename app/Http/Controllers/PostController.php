<?php

namespace App\Http\Controllers;

use App\Post;
use App\Topic;
use App\Events\UserPostedOnTopic;
use App\Mail\UserSubscribedToTopic;
use App\Mail\PostDeleted;
use App\Events\UsersMentioned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\GetMentionedUsers;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store (Request $request, Topic $topic)
    {
        $validateData = $request->validate([
            'body' => 'required|unique:posts'
        ]);
        $post = new Post();
        $post->topic_id = $topic->id;
        $post->user_id = $request->user()->id;

        // change @username to markdown link
        // I.e. @username -> [@username](APP_URL/user/profile/@username)
        $post->body = preg_replace('/\@\w+/', "[\\0](/user/profile/\\0)", $request->post);

        $post->save();

        // do @mention functionality
        $mentioned_users = GetMentionedUsers::handle($request->post);

        if (count($mentioned_users)) {
            event(new UsersMentioned($mentioned_users, $topic, $post));
        }

        event(new UserPostedOnTopic($topic, $post, $request->user()));

        return redirect()->route('forum.topics.topic.show', [
            'topic' => $topic,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit (Request $request, Topic $topic, Post $post)
    {
        $this->authorize('update', $post);

        return view('forum.topics.topic.posts.post.edit', [
            'topic' => $topic,
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update (Request $request,Topic $topic, Post $post)
    {
        $this->authorize('update', $post);

        $url = env('APP_URL');
        $post->body = $request->post;
        $post->save();

        //$mentioned_users = getMentionedUsers($request);

        //if (count($mentioned_users)) {
        //    event(new UsersMentioned($mentioned_users, $topic, $post));
        //}

        return redirect()->route('forum.topics.topic.show', [
            'topic' => $topic,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy (Request $request, Topic $topic, Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        if ($post->user->id !== $request->user()->id) {
            event(new PostDeleted($post));
            //Mail::to($post->user->email)->send(new PostDeleted($post));
        }

        return redirect()->route('forum.topics.topic.show', [
            'topic' => $topic,
        ]);
    }
}
