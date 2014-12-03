<?php
require_once __DIR__.'/../vendor/autoload.php';

$config = json_decode(file_get_contents(__DIR__.'/../config.json'),true);
$app = new Silex\Application();

#region config
$app['debug'] = $config['debug'];
$app['swiftmailer.options'] = $config['swiftmailer']['options'];
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

$app->post('/contact', function(\Symfony\Component\HttpFoundation\Request $request)use($mailer, $twig, $config){
    $name = $request->get('name');
    $email = $request->get('email');
    $phone = $request->get('phone');
    $message = $request->get('message');
    $viewParams = compact('name', 'email', 'phone', 'message');

    $body = $twig->render('mail/contact.twig', $viewParams);

    $swiftMessage = Swift_Message::newInstance($config['message']['subject'], $body, 'text/html');
    $swiftMessage->setFrom($config['system_email']);
    $swiftMessage->setTo($config['system_email']);

    $mailer->send($swiftMessage);


    return $twig->render('front/thanks.twig');
});

$app->run();