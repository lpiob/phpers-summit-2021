<?php

$fh=fopen("log.txt", "w+");
require("config.php");
$redis = new Redis();
$redis->connect($redis_addr, 6379, 1);

for ($i=100; $i>0; $i--) {
  $ts=microtime(true);

  $vote_a=0;
  $vote_b=0;

  $votes=$redis->lrange('votes', 0, -1);    // fetch all votes in list

  if ($votes)
    foreach ($votes as $vote)
      if ($vote=='a') $vote_a++;
      elseif ($vote=='b') $vote_b++;

  $redis->set('vote_a', $vote_a);
  $redis->set('vote_b', $vote_b);

  // logging

  fwrite($fh, sprintf("%s worker: A votes: %d, B votes: %d\n", date("c"), $vote_a, $vote_b));



  $redis->set('worker_loop_time', sprintf("%.2fms", (microtime(true)-$ts)*1000));

}

fclose($fh);
sleep(0.1); 
