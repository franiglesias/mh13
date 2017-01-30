<?php
# Load the EventManager
App::import('Lib', 'events/EventManager');

$EventManager = new EventManager(new SplObjectStorage());
ClassRegistry::addObject('EventManager', $EventManager);

# Init and register Observers


App::import('Lib', 'School.ApplicationObserver');
$AO = new ApplicationObserver();
$AO->useMailer($Mailer);
$AO->listen('school.application.new', 'received');
// $AO->listen('school.application.opened', 'opened');
$EventManager->attach($AO);

App::import('Lib', 'Resumes.ResumeObserver');
$RO = new ResumeObserver();
$RO->useMailer($Mailer);
$RO->listen('resumes.resume.new', 'received');
$EventManager->attach($RO);

App::import('Lib', 'Access.UserObserver');
$UO = new UserObserver();
$UO->useMailer($Mailer);
$UO->listen('access.user.login', 'login');
$UO->listen('access.user.logout', 'logout');
$UO->listen('access.user.register', 'register');
$UO->listen('access.user.activate', 'activate');
$UO->listen('access.user.deactivate', 'deactivate');
$UO->listen('access.user.forgot', 'forgot');
$EventManager->attach($UO);
?>