for i in `cat Monday.csv | grep '8$'`
do
fname=`echo $i | cut -d',' -f1`;
lname=`echo $i | cut -d',' -f2`;
echo $fname $lname;
done
