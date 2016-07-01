read cf < /sys/class/power_supply/BAT0/charge_full 
echo $cf
cn0=$(( $cf / 1000 ))
i=20
c=$((( $cn0 / 100 ) *$i ))
full()
{
	notify-send Battery"\nBattery Full"
    bf=0
    bf=$bf+1
}
z=0

timeout=10
while true
do
	
	echo $cn0
	echo $c
	read cn < /sys/class/power_supply/BAT0/charge_now
	ck=$(( $cn / 1000 ))
	echo $ck
	echo "------"
	if [ $ck -le $c ]
	then 
		notify-send "Battery Level $i% !"
		i=$i-10
        bf=$bf-1
	fi
    if [ $ck -eq $cn0 ]
    then
        if [ $bf -eq $z ]
	    then
		full
	    fi
    fi
sleep $timeout
done

