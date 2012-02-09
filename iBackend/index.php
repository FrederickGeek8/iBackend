<html><body><center><fieldset><legend>System Spec</legend>
<p><?php
echo ("Your Devices IP ");
$hostname = gethostbyaddr($_SERVER['SERVER_NAME']);
echo $hostname;
?></p>
<p><?php
echo ("Current device: ");
passthru("uname -m");
?></p>
<p><?php
echo ("Your IP is ");
$userip = gethostbyaddr($_SERVER['REMOTE_ADDR']);
echo $userip;
?></p>
<p><?php
 echo "uname: ". php_uname("s") ."\n";
 echo ("</br>");
 echo "OS: ". PHP_OS ."\n";
?></p>
<p>
<?php
echo ("CPU usage: ");
function ServerLoad()
{

$stats = explode(' ', substr(exec('uptime'), -14));
$av = round((($stats[0] + $stats[1] + $stats[2])));
return ($av);


}

echo ServerLoad() . '%';
?>
</p>




<?php
if(isset($_POST['respring'])) {
	echo exec("killall SpringBoard");
}

if(isset($_POST['restart'])) {
	echo exec("/sbin/reboot");
}

if(isset($_POST['shutdown'])) {
	echo exec("/sbin/halt");
}

if(isset($_POST['play'])) {
	echo exec("play /System/Library/Audio/UISounds/alarm.caf");
}
?>

<?php

/* get disk space free (in bytes) */
$df = disk_free_space("/private/var");
/* and get disk space total (in bytes)  */
$dt = disk_total_space("/private/var");
/* now we calculate the disk space used (in bytes) */
$du = $dt - $df;
/* percentage of disk used - this will be used to also set the width % of the progress bar */
$dp = sprintf('%.2f',($du / $dt) * 100);

/* and we formate the size from bytes to MB, GB, etc. */
$df = formatSize($df);
$du = formatSize($du);
$dt = formatSize($dt);

function formatSize( $bytes )
{
        $types = array( 'B', 'KB', 'MB', 'GB', 'TB' );
        for( $i = 0; $bytes >= 1024 && $i < ( count( $types ) -1 ); $bytes /= 1024, $i++ );
                return( round( $bytes, 2 ) . " " . $types[$i] );
}

?>
<style type='text/css'>
body
{
background-image:url('bg.png');
color:white;
font-family:"Arial";
}
.progress {
        border: 2px solid #5E96E4;
        height: 32px;
        width: 540px;
        margin: 30px auto;
}
.progress .prgbar {
        background: #A7C6FF;
        width: <?php echo $dp; ?>%;
        position: relative;
        height: 32px;
        z-index: 999;
}
.progress .prgtext {
        color: white;
        text-align: center;
        font-size: 13px;
        padding: 9px 0 0;
        width: 540px;
        position: absolute;
        z-index: 1000;
}
.progress .prginfo {
        margin: 3px 0;
}

</style>
</center>
<div class='progress'>
        <div class='prgtext'><?php echo $dp; ?>% Disk Used</div>
        <div class='prgbar'></div>
        <div class='prginfo'>
                <span style='float: left;'><?php echo "$du of $dt used"; ?></span>
                <span style='float: right;'><?php echo "$df of $dt free"; ?></span>
                <span style='clear: both;'></span>
        </div>
</div>
</fieldset>
</br>
<center>
<fieldset>
<legend>Actions</legend>
<form action="" method="post" enctype="multipart/formdata">
<input type="submit" value="Respring Device" name="respring" />
<input type="submit" value="Restart Device" name="restart" />
<input type="submit" value="Shutdown Device" name="shutdown" />
<input type="submit" value="Play Sound" name="play" />
</form>
</fieldset>
</center>


<center><form action="" method="post" enctype="multipart/formdata">
	<p>	
		<input type="text" name="cmd" placeholder="Enter Command" />
		<input type="submit" name="SendCMD" value="Send CMD" />
	</p>
</form></center>
<?php
if(isset($_POST['SendCMD'])) {
	echo exec("{$_POST['cmd']}");
}
?>




<!DOCTYPE html PUBLIC "-//W3C/DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>iBackend 1.0</title>
	</head>
	<fieldset><legend>Upload Files</legend><body>
		<center>		
		<div>
			<form action="" method="post" enctype="multipart/form-data">
				<p>
					<input type="file" name="files[]" multiple="multiple" min="1" max="9999" />
					</br>
					</br>
					</br>
					</br>
					<input type="text" name="furl" placeholder="Where to upload file" />
					<input type="submit" name="Upload" />
				</p>			
			</form>		
		</div>	
		</center>
	</body></fieldset>
</html>
<?php
if (isset($_FILES['files'])){
	foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name){
		move_uploaded_file($tmp_name, "{$_POST['furl']}/{$_FILES['files']['name'][$key]}");
	}
}

?>

