#!/bin/sh
day=`date '+%A'`
day=$day.csv;
day='/Users/rolfsona/Desktop/EASBothell/'"$day";
echo $day;
for i in `tail -n +2 $day`
do
recip=`echo $i|awk -F, '{print $3}'`;
recipients=$recipients$recip","
done
recipients=`echo $recipients | sed s'/.$//'`
echo `date`:$recipients >>/tmp/recipients.log;
echo $recipients
#cat /Users/rolfsona/Desktop/EASBothell/Prayer.html | mail -s "$(echo "Your Daily Prayer Reminder\nFrom: EAS Prayer Team <prayerteam@easbothell.org>\nReply-to: prayerteam@easbothell.org\nContent-Type: text/html")" -brolfsona@icloud.com,lavanyaaugustine@gmail.com rolfsona@gmail.com
cat /Users/rolfsona/Desktop/EASBothell/Prayer.html | mail -s "$(echo  "Your Daily Prayer Reminder\nFrom: EAS Prayer Team <prayerteam@easbothell.org>\nReply-to: prayerteam@easbothell.org\nContent-Type: text/html")" -b$recipients prayerteam@easbothell.org
