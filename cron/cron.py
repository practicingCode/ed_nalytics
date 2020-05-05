 #!/usr/bin/env python2
import os
import time

day = 2
y = False
while y == False:
    time.sleep(day)
    #os.system('php cron_day.php')
    os.system('python index_csv.py')
    y = True


print ('done')