

## Raspberry PI configuration

### Create bash script in /home/pi/Documents

    cd Documents
    nano sendmac.sh
Copy paste the following code. Remember to change the HOST variable to your Moodle URL. Also remember to change the TOKEN variable .

    #!/bin/bash
    #Enter the host address of your moodle server
    HOST=https://yourserver.com
    
    #Enter the token from your Moodle server
    TOKEN=YOURTOKEN
    
    #######DO NOT EDIT BEYOND THIS POINT########
    MAC=$(ip -o link show dev eth0 | grep -Po 'ether \K[^ ]*')
    IP=$(hostname -I)
    echo "$MAC"
    curl "$HOST/webservice/rest/server.php" -d"wstoken=$TOKENwsfunction=roomsupport_get_raspberry_pi&mac=$MAC&ip=$IP"
Save and close the new file by pressing ctrl-x
Change the permissions on the file

    chmod 755 sendmac.sh
### Prepare cron

    crontab -e
If this is your first time select your preferred editor. Nano is the default.
Add the following line

    */5 * * * * /home/pi/Documents/sendmac.sh

That will run the script every five minutes. This is used as a status in the Moodle management area. If the last ping is more then five minutes, it will show the status as red (not connected.)
 

### Troubleshooting
If you created the file in Windows and then transferred to your Raspberry PI, it will probably not work. Run this command to fix the file

    sed -i -e 's/\r$//' sendmac.sh

### Set autostart file
We need chrome browser to start in kiosk mode and open the proper page

    cd ~/.config/lxsession/LXDE-pi
    nano autostart
Add the following code

    @xset s off
    @xset s noblank
    @xset -dpms
    @unclutter -idle 0.5 -root &
    @sed -i 's/"exited_cleanly":false/"exited_cleanly":true/' /home/pi/.config/chromium/Default/Preferences
    @sed -i 's/"exit_type":"Crashed"/"exit_type":"Normal"/' /home/pi/.config/chromium/Default/Preferences
    @chromium-browser --noerrdialogs --disable-infobars --kiosk --app=https://your_moodle_server/local/roomsupport/client/

### Reboot without requiring password 
The system allows us to reboot through ssh. 
Thank you to Kevin Friedberg for this solution.

    cd /etc/polkit-1/localauthority/50-local.d/
    sudo nano 10-nopasswd_pi_reboot.pkla
Copy the following code

    [Let user Pi reboot Pi device]
    Identity=unix-user:pi
    Action=org.freedesktop.login1.reboot
    ResultAny=yes
    ResultInactive=yes

 For future-proofing once Debian uses the current PolicyKit, this file should keep it working
 

    cd /etc/polkit-1
    mkdir rules.d
    cd rules.d
    sudo nano 10-nopasswd_pi_reboot.rules
Copy the following code

    polkit.addRule(function(action, subject) {
         if ((action.id == "org.freedesktop.login1.reboot" &&
             subject.user == "pi")
         {
             return polkit.Result.YES;
         }
    });

Reboot your pi the regular way. Then you will be able to simply write reboot to reboot your pi.


> Written with [StackEdit](https://stackedit.io/).