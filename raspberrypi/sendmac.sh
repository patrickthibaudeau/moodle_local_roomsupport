#!/bin/bash

#Enter the host address of your moodle server
HOST=https://yourserver.com

#Enter the token from your Moodle server
TOKEN=YOURTOKEN

#######DO NOT EDIT BEYOND THIS POINT########
MAC=$(ip -o link show dev eth0 | grep -Po 'ether \K[^ ]*')
IP=$(hostname -I)
echo "$MAC"
curl "$HOST/webservice/rest/server.php" -d"wstoken=$TOKEN&wsfunction=roomsupport_get_raspberry_pi&mac=$MAC&ip=$IP"