<?php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

#region config
$app['debug'] = true;
$app['swiftmailer.options'] = array(
    'host' => 'host',
    'port' => '25',
    'username' => 'username',
    'password' => 'password',
    'encryption' => null,
    'auth_mode' => null
);
#endregion

$app->register(new \Silex\Provider\TwigServiceProvider(),array(
    'twig.path' => __DIR__.'/../views'
));
$app->register(new Silex\Provider\SwiftmailerServiceProvider());


/** @var Twig_Environment $twig */
$twig = $app['twig'];
/** @var Swift_Mailer $mailer */
$mailer = $app['mailer'];

$app->get('/', function() use($app, $twig){
    return $twig->render('front/index.twig');
});

$app->post('/contact', function(\Symfony\Component\HttpFoundation\Request $request)use($mailer, $twig){
    $name = $request->get('name');
    $email = $request->get('email');
    $phone = $request->get('phone');
    $message = $request->get('message');
    $viewParams = compact('name', 'email', 'phone', 'message');

    $body =

    return $twig->render('front/thanks.twig', );
});

$app->run();