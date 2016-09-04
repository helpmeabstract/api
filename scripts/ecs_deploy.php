#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Assert\Assertion;
use Aws\Ecs\EcsClient;

Assertion::eq(count($argv), 5);

$aws_profile = $argv[1];
$aws_region = $argv[2];
$cluster = $argv[3];
$task_family = $argv[4];

Assertion::string($aws_profile);
Assertion::string($aws_region);
Assertion::string($cluster);
Assertion::string($task_family);

$aws_options = [
    'region' => $aws_region,
    'version' => '2014-11-13',
];

if (getenv('AWS_ACCESS_KEY') && getenv('AWS_SECRET_ACCESS_KEY')) {
    $aws_options['AWS_ACCESS_KEY'] = getenv('AWS_ACCESS_KEY');
    $aws_options['AWS_SECRET_ACCESS_KEY'] = getenv('AWS_SECRET_ACCESS_KEY');
} else {
    $aws_options['profile'] = $aws_profile;
}

$client = EcsClient::factory(
    $aws_options
);

$definition = $client->describeTaskDefinition(['taskDefinition' => $task_family])->toArray();

$newDefinition = $client->registerTaskDefinition(
    [
        'family' => $task_family,
        'containerDefinitions' => $definition['taskDefinition']['containerDefinitions'],
    ]
)->toArray();

$instances = $client->listContainerInstances(['cluster' => $cluster])->toArray();

$tasks = $client->listTasks(['cluster' => $cluster])->toArray();
$client->stopTask(['cluster' => $cluster, 'task' => $tasks['taskArns'][0]]);
$client->startTask(
    [
        'cluster' => $cluster,
        'taskDefinition' => $newDefinition['taskDefinition']['taskDefinitionArn'],
        'containerInstances' => $instances['containerInstanceArns'],
    ]
);
