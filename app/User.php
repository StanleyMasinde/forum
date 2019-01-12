<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','avatar','role', 'password','last_activity'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * a user is identified by the name
     * 
     */
    public function getRouteKeyName()
    {
        return "name";
    }

    /**
     * Each user can have many topics
     * 
     */
    public function topics()
    {
        return $this->hasMany('App\Topic');
    }

    /**
     * Each user can have many topics
     * 
     */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    /**
     * Each user has can have many reports
     * 
     * 
     */
    public function reports()
    {
        return $this->hasMany('App\Report');
    }

    /**
     * A user can receive many messages
     * 
     * 
     */
    public function receivedMessages()
    {
        return $this->hasMany('App\Message', 'recipient_id');
    }

    /**
     * A user can send many messages
     * 
     * 
     */
    public function sentMessages()
    {
        return $this->hasMany('App\Message', 'sender_id');
    }

    /**
     * Check if the user is a moderator
     * 
     * 
     */
    public function isModerator()
    {
        return $this->role === "moderator";
    }

    /**
     * Check if user is an admin
     * 
     */
    public function isAdmin()
    {
        return $this->role === "admin";
    }

    /**
     * Check if user is elevated
     * 
     * 
     */
    public function isElevated()
    {
        return $this->role === "admin" || $this->role === "moderator";
    }

    /**
     * Get the user's role
     * 
     * 
     */
    public function role()
    {
        return $this->role;
    }

    /**
     * Each user can have many subscriptions
     * 
     * 
     */
    public function subscriptions()
    {
        return $this->hasMany('App\Subscription');
    }

    /**
     * Returns a Collection of subscriptions that a User has
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    protected function getUserSubscriptions()
    {
        return Subscription::where('user_id', $this->id)->get();
    }

    /**
     * Returns whether a user is subscribed to a Topic.
     *
     * @return mixed App\Subscription | boolean
     */
    public function isSubscribedTo(Topic $topic)
    {
        // loop through all subscriptions for current user
        foreach ($this->getUserSubscriptions() as $subscription) {
            if ($subscription->topic_id === $topic->id) {
                // has a certain subscription, let's return it
                return $subscription;
            }
        }

        // no subscriptions at all..
        return null;
    }

    /**
     * Returns whether a User is the recipient of a Message.
     *
     * @param  App\Message $user
     * @return boolean
     */
    public function isRecipient (Message $message)
    {
        return $this->id === $message->recipient_id;
    }

    /**
     * Returns whether the current User has any unread messages.
     *
     * @return boolean
     */
    public function hasUnreadMessages ()
    {
        return count(Message::where('recipient_id', $this->id)->where('read', 0)->get()) > 0;
    }

    /**
     * Returns whether the current User has any unread messages from a specific sender.
     *
     * @return boolean
     */
    public function hasUnreadMessagesFromSender (User $user)
    {
        return count(Message::where('recipient_id', $this->id)->where('sender_id', $user->id)->where('read', 0)->get()) > 0;
    }

    /**
     * Returns a Collection of messages received by the current User, from a specific sender.
     *
     * @return Illuminate\Support\Collection
     */
    public function receivedMessagesFromSender (User $user)
    {
        return Message::where('recipient_id', $this->id)->where('sender_id', $user->id)->where('read', 0)->get();
    }

    /**
     * Returns the count of unread messages for the current User.
     *
     * @return int
     */
    public function unreadMessageCount ()
    {
        return count(Message::where('recipient_id', $this->id)->where('read', 0)->get());
    }

    /**
     * Returns the count of unread messages for the current User, given a specific sender.
     *
     * @return int
     */
    public function unreadMessageCountForSender (User $user)
    {
        return count(Message::where('recipient_id', $this->id)->where('sender_id', $user->id)->where('read', 0)->get());
    }

}
