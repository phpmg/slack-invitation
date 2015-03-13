<?php 

namespace Phpmg\Slack;

use Vluzrmos\SlackApi\SlackApi;
use Phpmg\Slack\User;

class Invitation
{
    protected $slackApi;

    protected $user;

    public function __construct(User $user, SlackApi $slackApi)
    {
        $this->user = $user;
        $this->slackApi = $slackApi;
    }

    public function send()
	{
        $response = $this->getSlackApi()->post('users.admin.invite', [
            'body' => [
                'email' => $this->getUser()->getEmail(),
                'first_name' => $this->getUser()->getName(),
                'set_active' => true,
                'channels' => $this->getChannelsNamesToString(),
                '_attempts' => 1
            ]
         ]);
	}

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return SlackApi
     */
    public function getSlackApi()
    {
        return $this->slackApi;
    }

    public function getChannels()
    {
        $response = $this->getSlackApi()->get('channels.list');

        return array_filter($response['channels'], function($channel) {
            return ! $channel['is_archived'];
        });
    }


    public function getChannelsNamesToString()
    {
        $channels = $this->getChannels();

        $channels = array_map(function($channel) {
            return $channel['id'];
        }, $channels);

        return implode(',', $channels);
    }
}