<?php

$ts=microtime(true);

require_once("config.php");
$vote_a=0;
$vote_b=0;
$worker_loop_time="???";

$redis = new Redis();
$redis->connect($redis_addr, 6379, 1);

// add vote
if (isset($_REQUEST['a']))
  $redis->rpush('votes', 'a');

elseif (isset($_REQUEST['b']))
  $redis->rpush('votes', 'b');

// read votes
$vote_a=$redis->get('vote_a');
if (!$vote_a) $vote_a=0;
$vote_b=$redis->get('vote_b');
if (!$vote_b) $vote_b=0;

$worker_loop_time=$redis->get("worker_loop_time");

header('Content-Type: application/json');

$data=Array(
  "a"=>$vote_a,
  "b"=>$vote_b,
  "worker_loop_time"=>$worker_loop_time
);

print(json_encode($data));