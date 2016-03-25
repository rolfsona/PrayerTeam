#!/bin/sh
>/tmp/mail.tmp
echo 'From: prayerteam@easbothell.org' > /tmp/mail.tmp
echo 'To: rolfsona@gmail.com' >> /tmp/mail.tmp
echo 'MIME-Version: 1.0' >> /tmp/mail.tmp
echo 'Subject: Prayer Warriors' >> /tmp/mail.tmp
echo 'Content-Type: multipart/mixed; boundary="FILEBOUNDARY"' >> /tmp/mail.tmp
echo >> /tmp/mail.tmp
echo '--FILEBOUNDARY' >> /tmp/mail.tmp
echo 'Content-Type: multipart/alternative; boundary="MSGBOUNDARY"' >> /tmp/mail.tmp
echo >> /tmp/mail.tmp

echo '--MSGBOUNDARY' >> /tmp/mail.tmp
echo 'Content-Type: text/html; charset=iso-8859-1' >> /tmp/mail.tmp
echo 'Content-Disposition: inline' >> /tmp/mail.tmp
echo '<html><body>' >> /tmp/mail.tmp
echo '<img src="cid:tickjpeg" /><br>' >> /tmp/mail.tmp
echo '</body></html>' >> /tmp/mail.tmp
echo '--MSGBOUNDARY--' >> /tmp/mail.tmp

echo >> /tmp/mail.tmp
echo '--FILEBOUNDARY' >> /tmp/mail.tmp
echo 'Content-Type: image/jpeg' >> /tmp/mail.tmp
echo 'Content-Disposition: inline; filename=”/Users/rolfsona/Desktop/EAS Bothell Prayer.jpg”' >> /tmp/mail.tmp
echo 'Content-Transfer-Encoding: base64' >> /tmp/mail.tmp
echo 'Content-Id: <tickjpeg>' >> /tmp/mail.tmp
echo >> /tmp/mail.tmp
base64 Prayer.jpg >> /tmp/mail.tmp
echo >> /tmp/mail.tmp
echo "--FILEBOUNDARY--" >> /tmp/mail.tmp
