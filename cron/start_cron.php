#! /usr/bin/php

<?php
//WORKS: cat temp.txt | crontab 
// CURRENT ISSUE:
// 1) it sends to crontab properly but it overwrites old
// 2) not sure if cron actually works
    // DEFINE PATH
    $username = "";
    $password = "";
    $full_path = "/var/www/html";
    $path = realpath("");
    // DEFINE FILES TO SCHEDULE
    $day = "/cron_day.php";
    $mth = "/cron_mth.php";
    $week = "/cron_week.php";
    $year = "/cron_year.php";
    $quater = "/cron_quater.php";

    $time = "* * * * *";
    //TRIGGER FROM JS
    if ($_POST == NULL){
        //echo $path;
        
    
        function append_cronjob(){
                //test
                echo exec('who');
                echo exec('python cron.py');
            // //1) STORE IN HOLDING
            // echo exec('crontab -l > holding.txt');
            // //2) APPEND HOLDING WITH MY_CRON
            // echo exec('cat my_cron.txt >> holding.txt');
            // //3) REPLACE CRONTAB with holding
            // echo exec('cat holding.txt | crontab ');
            // //get OLD cron





            // $old_crons = exec('crontab -l');
            // $cron_file = 'temp.txt';
            // $revised_cron = exec($old_crons.'>> temp.txt'); 
            // echo exec('cat temp.txt | crontab');
            //  4) CHECK CHANGES
            echo exec('crontab -l');
        }
        append_cronjob();
        // echo $test;

        // exec('echo -e "`crontab -l`\n30 9 * * * /path/to/script" | crontab -');
        // echo exec('crontab -l');

    }

?>