<?php
#! /usr/bin/php

//THINGS TO DO EACH DAY:
// 1) INDEX
// 2) AGGREGATE

//INDEXING
//START INDEXING FROM LAST NUMBER IN LAST INDEX
//TAKE FROM FULL JOIN AND INDEX ACCORDINGLY
exec('crontab -l > cron_dayworks.txt', $result);
echo json_encode($result);
exec('crontab -l');
?>