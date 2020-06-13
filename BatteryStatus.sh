read cf < /sys/class/power_supply/BAT0/charge_full 
echo $cf
read online < /sys/class/power_supply/AC/online
echo $online
cn0=$(( $cf / 1000 ))
i=20
c=$((( $cn0 / 100 ) *$i ))
ten=0
twenty=0
f=0
j=10
charger_plug=0
timeout=10
while true
do
	echo $ten
	echo $twenty
	echo $f
    echo $charger_plug
	read cn < /sys/class/power_supply/BAT0/charge_now
	ck=$(( $cn / 1000 ))
	c1=$((( $cn0 / 100 ) *$j ))
	read online < /sys/class/power_supply/AC/online
	if [ $ck -lt $cn0 ] && [ $f -eq 1 ]
	then
		f=0
	fi
	if [ $ck -gt $c1 ] && [ $ten -eq 1 ]
	then
		ten=0
	fi
	if [ $ck -gt $c ] && [ $twenty -eq 1 ]
	then
		twenty=0
	fi
	echo $cn0
	echo $c
	echo $ck
	if [ $ck -eq $cn0 ] && [ $f -ne 1 ]
    then
        notify-send "Battery Full"
        f=1
    fi
	if [ $ck -le $c ] && [ $twenty -ne 1 ]
	then 
		notify-send "Battery Level $i% !"
		twenty=1
	fi
    if [ $ck -le $c1 ] && [ $ten -ne 1 ]
    then
        notify-send "Battery Critical $j% !"
        ten=1
    fi
    if [ $online -eq 1 ] && [ $charger_plug -eq 0 ]
    then
        notify-send "Charger Plugged In"
        charger_plug=1
    fi
    if [ $online -eq 0 ] && [ $charger_plug -eq 1 ]
    then
        notify-send "Charger Unplugged"
        charger_plug=0
    fi
    echo $ten
	echo $twenty
	echo $f
    echo $charger_plug
	echo "------"
sleep $timeout
done
