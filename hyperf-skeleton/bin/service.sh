#!/bin/bash

while getopts c:t:n:  opt
do
        case $opt in
                t)
                        type=$OPTARG
                        ;;
                n)
                		name=$OPTARG
                		;;
                ?)
                        echo "unkonwn"
                        exit
                        ;;
        esac
done

function start()
{
		 php -f hyperf.php start &
		 echo 'start done'
		 exit
}

function stop()
{
		if [[ ! -n $name ]];then
		        echo ".sh [-t start|stop|restart|reload] -n [ACCOUNT]"
		        exit
		fi

        a=`ps aux|grep ${name} |grep -v 'grep'|grep -v 'service.sh'|wc -l`
        if [ $a -gt 0 ]; then
            ps -eaf |grep ${name} | grep -v "grep"|grep -v 'service.sh'|awk '{print $2}'|xargs kill -9
        fi

        while true
        do
        	local a=`ps aux|grep ${name} |grep -v 'grep'|grep -v 'service.sh'|wc -l`
        	if [[ $a -gt 0 ]];then
        		sleep 1;
        	else
        		break;
        	fi
        done
        echo 'stop success'
        exit
}

case $type in
        'start')
                start;
                ;;
        'stop')
                stop;
                ;;
        'restart')
                stop;
                start;
                ;;
esac
