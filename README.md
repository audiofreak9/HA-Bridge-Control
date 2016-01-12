# PHP-X10-Control
Phone, Tablet &amp; Desktop PHP X10 control

Code written in PHP that allows control X10 devices with a phone, tablet or desktop.  

Save the code as index.php on the Apache server in the /var/www/html/ folder. It uses twitter bootstrap for mobile compatibility and fluidity. I’ve saved the Twitter bootstrap responsive and theme CSS files locally to the RPi.  The code gets your configured heyu devices and displays their state and gives control of each.  It also gets your configured scenes and displays them as well. 

<h3>Prerequisite components</h3>
<ul>
  <li>Linux box, preferably a Raspberry Pi</li>
  <li><a href="http://www.heyu.org/">HEYU</a> installed</li>
  <li>Apache installed</li>
  <li>PHP installed</li>
</ul>

You’ll need to get some CSS and image files for this to look nice and work properly.  Save the extra CSS and image files by doing the following.

$ sudo wget http://www.camwebwp.com/x10_files/bootstrap-theme.min.css

$ sudo wget http://www.camwebwp.com/x10_files/bootstrap-responsive.css

$ sudo wget http://www.camwebwp.com/x10_files/startup.png

$ sudo wget http://www.camwebwp.com/x10_files/x10switch_icon.png
