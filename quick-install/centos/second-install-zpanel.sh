#!/usr/bin/expect -f

set dest [lindex $argv 0]

spawn bash /root/10_1_1.sh

expect "Would you"
send "y\r"


expect "#?"
send "2\r"


expect "#?"
send "49\r"

expect "#?"
send "1\r"

expect "#?"
send "1\r"

expect "FQDN"
send "\r"

expect "IP"
send "\r"

expect "ready"
send "y\r"


expect "Install"
send "y\r"
interact
