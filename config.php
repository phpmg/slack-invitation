<?php

return [

    /**
     * The slack token
     * Unique for user and team
     */
    'slack_token' => getenv('SLACK_TOKEN'),

	/**
     * The slack name
     * Name of the slack team
     */
    'slack_name' => getenv('SLACK_NAME') ? getenv('SLACK_NAME') : "PHPMG",

    /**
     * Enable/Disable debug mode
     */
    'debug' => getenv('SLACK_DEBUG') ? getenv('SLACK_DEBUG') : false,
];
