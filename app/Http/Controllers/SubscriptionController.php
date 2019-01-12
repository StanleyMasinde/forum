<?php

namespace App\Http\Controllers;

use App\Subscription;
use App\Mail\UserSubscribedToTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Topic;

class SubscriptionController extends Controller
{
    /**
     * Returns a user's subscription status, regarding a given Topic.
     * Utilized by SubscribeButtonComponent Vue component.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  App\Topic                $topic
     * @return Illuminate\Http\Response
     */
    public function getSubscriptionStatus (Request $request, Topic $topic)
    {
        $user = $request->user();
        $subscription = $user->isSubscribedTo($topic);

        if ($subscription !== null) {
            // was already a subscription, send back the subscription status
            return $subscription->subscribed;
        } else {
            // was no subscription..
            return null;
        }
    }

    /**
     * Subscribes or unsubscribes a User from a Topic (SubscribeButtonComponent Vue component).
     *
     * @param  Illuminate\Http\Request  $request
     * @param  App\Topic                $topic
     * @return Illuminate\Http\Response
     */
    public function handleSubscription (Request $request, Topic $topic)
    {
        $user = $request->user();
        $subscription = $user->isSubscribedTo($topic);

        if ($subscription !== null) {
            // subscription exists, but can be either subscribed or unsubscribed
            if ($subscription->subscribed === 0) {
                $subscription->subscribed = 1;
            } else if ($subscription->subscribed === 1) {
                $subscription->subscribed = 0;
            }
        } else {
            // wasn't subscribed
            $subscription = new Subscription;
            $subscription->topic_id = $topic->id;
            $subscription->user_id = $user->id;
            $subscription->subscribed = 1;
        }
        $subscription->save();
        if ($subscription->subscribed === 1) {
            //event(new UserSubscribedToTopic($topic));
            //Mail::to($topic->user->email)->queue(new UserSubscribedToTopic($topic));

        }

        return response()->json(null, 200);
    }
}
