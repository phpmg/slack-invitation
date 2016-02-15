<?php require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use Phpmg\Slack\Invitation as SlackInvitation;
use Vluzrmos\SlackApi\SlackApi;
use GuzzleHttp\Client;
use Dotenv\Dotenv;

/*
 * init dotenv stuff
 */
$dotenv = new Dotenv(__DIR__ . '/../');
$dotenv->load();
// this will throw an exception if these aren't set
$dotenv->required(['SLACK_NAME', 'SLACK_TOKEN']);
// the env vars will be used in the config
$config = require __DIR__.'/../config.php';

$app = new Application();

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../app/views',
));

$app['slack_name'] = $config['slack_name'];
$app['debug'] = $config['debug'];

$app['flashbag'] = $app->share(function (Application $app) {
    return $app['session']->getFlashBag();
});

$app->get('/', function () use ($app) {
    return $app['twig']->render('invite.twig');
});

$app->post('/invite', function (Request $request) use ($app, $config) {

    $user = new \Phpmg\Slack\User(
        $request->get('name'),
        $request->get('email')
    );

    if (! $user->isValid()) {
        $app['flashbag']->add('user', $user);
        $app['flashbag']->add('fail', true);
        return $app->redirect('/');
    }

    $invitation = new SlackInvitation(
        $user,
        new SlackApi(new Client(), $config['slack_token'])
    );

    $invitation->send();

    $app['flashbag']->add('success', true);
    return $app->redirect('/');
});

$app->run();
