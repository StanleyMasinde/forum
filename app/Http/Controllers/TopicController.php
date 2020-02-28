<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Post;
use App\Topic;
use App\Subscription;
use App\GetMentionedUsers;
use App\Events\TopicDeleted;
use Illuminate\Http\Request;
use App\Events\UsersMentioned;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreateTopicFormRequest;
use Illuminate\Support\Str;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = Topic::orderBy('created_at', 'desc')->paginate(10);
        return view('forum.topics.index', ['topics' => $topics]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('forum.topics.topic.create.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:topics',
            'post' => 'required',
        ]);

        $topic = new Topic;
        $topic->slug = Str::slug(mb_strimwidth($request->title, 0, 255), '-');
        $topic->user_id = $request->user()->id;
        $topic->title = $request->title;
        $topic->save();

        // create the first Post of the Topic, which is the 'body' of the Topic.
        $post = new Post;
        $post->topic_id = $topic->id;
        $post->user_id = $request->user()->id;
        $post->body = $request->post;

        // change @username to markdown links
        $url = env('APP_URL');
        $post->body = preg_replace('/\@\w+/', "[\\0](/user/profile/\\0)", $request->post);

        $post->save();

        // do @mention functionality
        $mentioned_users = GetMentionedUsers::handle($request->post);

        if (count($mentioned_users)) {
            event(new UsersMentioned($mentioned_users, $topic, $post));
        }

        // create the subscription
        $subscription = new Subscription;
        $subscription->topic_id = $topic->id;
        $subscription->user_id = $request->user()->id;
        $subscription->subscribed = ($request->subscribe === null ? 0 : 1);
        $subscription->save();

        return redirect()->route('forum.topics.topic.show', [
            'topic' => $topic,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function show(Topic $topic)
    {
        $topic = $topic->load(['posts' => function ($query) {
            $query->orderBy('created_at', 'desc')->get();
        }]);
        return view('forum.topics.topic.index', ['topic' => $topic]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function edit(Topic $topic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Topic $topic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Topic $topic)
    {
        // don't need to use policy here, as auth.elevated middleware is being use for the route associated with this controller method invocation
        // we don't allow users to delete a Topic, not even their own, unless they have an elevated User role.
        $topic->delete();

        if ($topic->user->id !== $request->user()->id) {
            // don't want to send email to the owner of the topic, if they deleted it
            event(new TopicDeleted($topic));
        }

        return redirect()->route('forum.topics.index');
    }
}
