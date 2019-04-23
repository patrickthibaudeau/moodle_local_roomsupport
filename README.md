


# Room Support System
The system will be used at York University's Glendon Campus. It is a system that displays help instructions for the technology in the room. It also allows users to quickly call the help desk by pressing a button on the device. 

## Room support kiosk
The room support kiosk is built using Touchscreen Raspberry Pi's that communicate through web services to a server.  When a user requires assistance, they will click the request assistance button. They will then be provided with help in the form of an FAQ for the technology within the room. If that help does not work, there will be a button to call for help. When pressed, it send's a call to the server which will then dispatch a notification to a web application and SMS so that a technician can go to the room and help. There is an interactive PDF Mockup (classroomsupport.pdf) of the kiosk in the mockup folder of the project.

### Technologies used
The server portion of the app is developed in Moodle as a local plugin. I use Moodle as a framework. It has everything built-in: Authentication, Roles, Capabilities, Security, Charts, DB API, Webservice API and so much more.
The Classroom support kiosks are Raspberry Pi with a Touchscreen.

 ### Installation
 I am presuming that you already have a Moodle server installed. If not, follow [these instructions](https://docs.moodle.org/36/en/Installing_Moodle)
 
 Download the repository and unzip in the *moodle_root*/local/ folder. Rename the folder to roomsupport.
 Login to your Moodle instance as an adminsitrator. The plugin installation should start. Press the install button.

Once the plugin is installed, it will ask you to fill in some parameters. Skip this step for now by pressing the save button. We'll set these parameters later once we have other settings created..

 #### Setting up the Web service
##### Enable web services
1. In the nav drawer, click Site administration
2. Click on Advanced features
3. If not checked, click "Enable web services"
4. Save changes

##### Enabled Web services authentication

 1. In the nav drawer, click Site administration
 2. Click on the "Plugins" tab
 3. Scroll down to Authentication
 4. Click on Manage authentication
 5. Click the closed eye for Web services authentication
 
 ##### Create a user for the web service 

 1. Go to Site administrations and click the Users tab
 2. Click add a new user
 3. Enter a username
 4. Select Web services authentication from the "Choose an authentication method" drop down.
 5. Password field is disabled. (Web services use tokens)
 6. Enter First name, Surname and email (The email can be a fake address)
 7. Click on the "Create user" button

##### Create a role for the web service

 1. In the nav drawer, click Site administration
 2. Click the users tab
 3. Click "Define roles"
 4. Click "Add a new role"
 5. Do not select anything, simply click "Continue"
 6. Enter a short name : roomsupport
 7. Enter a Custom full name: Room Support System
 8. Click on the checkbox for System for the "Context types where this role may be assigned"
 9. Scroll down to the filter field and enter selfeserve.
 10. Click the "Allow" checkbox for Raspberry PI access
 11. In the filter field, type rest protocol
 12. Click the "Allow" checkbox for "Use REST protocol 
 13. Click the "Create this role" button

#####  Add newly created user to new role

 1. In the nav drawer, click Site administration
 2. Click the users tab
 3. Click "Assign system roles
 4. Click "Room Support System"
 5. Select the user you created above from Potential users and click the "Add" button

##### Create an external service

  1. In the nav drawer, click Site administration
 2. Click on the "Plugins" tab
 3. Scroll down to Web services ( at the bottom)
 4. Click External services. (I usually right-click and open in a new tab as I will need to return to this exact page for the next few steps)
 5. Click "add"
 6. Enter a name and short name. (I use the same as the role.)
 7. Click enable
 8. Click Authorised users only
 9. Click the "Add service" button.
 10. In the new page, click "Add functions"
 11. In the search field type roomsupport_
 12. Add all roomsupport_ functions that pop up
 13. Click the "Add functions" button

##### Add authorized user to external service
  1. In the nav drawer, click Site administration
 2. Click on the "Plugins" tab
 3. Scroll down to Web services ( at the bottom)
 4. Click External services. 
 5. Click Authorized users for the External service you just created (Should be called Room Support System)
 6. Select the user you created previously from the Not authorised users box
 7. Click "Add"

##### Enable REST protocol
 1. In the nav drawer, click Site administration
 2. Click on the "Plugins" tab
 3. Scroll down to Web services ( at the bottom)
 4. Click "Manage protocols"
 5. Click the closed eye for REST protocol to enable.

#####  Create a Token
 1. In the nav drawer, click Site administration
 2. Click on the "Plugins" tab
 3. Scroll down to Web services ( at the bottom)
 4. Click "Manage tokens"
 5. Click "Add"
 6. Select the user you created previously.
 7. Select "Room Support System" from the drop down menu for the service field
 8. Click "Save changes"
 9. Copy the Token. You will need to add it to your Raspberry Pi's

All web service calls are done to the following address
https://your_moodle.server/webservice/rest/server.php?wstoken=your_token&wsfunction=your_function
You will also need to add any other query parameters required by the function.
Optionally, you can add &moodlewsrestformat=json to receive the reply in json format. Otherwise XML is used.
Example

    https://localhost/moodle/webservice/rest/server.php?wstoken=d766a1dbaea861cf7934088dfea065b6&wsfunction=roomsupport_get_raspberry_pi&mac=00:BB:00:00:00&ip=192.168.5.5

## Set plugin parameters
Remember those setting parameters we skipped during the install process? Well, here they are. 
The plugin communicates with the Raspberry Pi's through two methods.

 1. SSH
 2. Web services

### SSH
To setup ssh for php, you must install php_ssh2 on your server.

    sudo apt install php_ssh2
    service apache2 restart

### Web services
The token you created in the earlier steps will be required
### Agent Site URL
"Wait a second, you said two methods earlier on!" I did, but the third parameter has nothing to do with the Raspberry Pi. the agent site URL is the URL to your ticketing system. The agent page uses an iframe to display the ticketing system page on the left. The right side of the agent page displays incoming help requests form the classroom support Raspberry Pi's.

To get to the settings do the following
 3. Click on "Site administration"
 4. Click on plugins and scroll down to "Local plugins"
 5. Click on "Room Support System"
 6. Modify the values accordingly and save the changes.

> Note: The iframe may not work if Access-Control-Allow-Origin on the ticketing system server is not set to allow your site.
 
Written with [StackEdit](https://stackedit.io/).
