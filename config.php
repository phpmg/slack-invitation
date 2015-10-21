<?php return [

    /**
     * The slack token
     * Unique for user and team
     */
    'slack_token' => getenv('SLACK_TOKEN'),

	/**
     * The slack name
     * Name of the slack team
     */
    'slack_name' => "PHPMG",

    /**
     * Enable/Disable debug mode
     */
    'debug' => true,
];