<?php
$heyuvar = "heyu -c /home/pi/.heyu/x10config ";
if (isset($_POST['hu'])) {
if (isset($_POST['action'])) $command = $heyuvar . $_POST['action'] . ' ' . $_POST['hu'] . ' 2>&1';
if (isset($_POST['bd'])) {
$level = 22 - round($_POST['percent'] * (22 / 100));
if ($level == 0) $level = 1;
$command = $heyuvar . $_POST['bd'] . ' ' . $_POST['hu'] . ' ' . $level . ' > /dev/null 2>/dev/null &';
}
$output = shell_exec($command);
header("Location: /");
exit;
}
if (isset($_POST['sc'])) {
$command = $heyuvar . $_POST['sc'] . ' > /dev/null 2>/dev/null &';
$output = shell_exec($command);
header("Location: /");
exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<link href="startup.png" media="(device-width: 320px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">
<link rel="apple-touch-icon" href="x10switch_icon.png"/>
<title>Lighting</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap-responsive.css">
<link rel="stylesheet" href="bootstrap-theme.min.css">
</head>
<body>
<br />
<div class="container container-fluid" role="main">
<div class="row">
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Devices</h3>
</div>
<div class="panel-body">
<?php
$get_alias = $heyuvar . 'show alias';
$devices = explode(":", preg_replace('/( )+/', ' ', str_replace("alias", ":", str_replace("[Aliases]", "", shell_exec($get_alias)))) . ":");
if (!empty($devices)) {
$count = 0;
foreach ($devices as &$device) {
$count++;
list($dev_name, $dev_address, $dev_type) = explode(":", str_replace(" ", ":", trim($device)));
$get_level = $heyuvar . 'dimlevel ' . $dev_address;
if ($dev_address) {
$dev_level = trim(shell_exec($get_level));
if (($dev_type != "StdLM") && ($dev_level > 0)) $dev_level = 100;
?>
<h5><span class="label label-default"><?php echo $dev_address . ' ' . ucwords(str_replace("_", " ", $dev_name)); ?></span></h5>
<div style="margin:0 0 4px 0">
<form class="form-inline" method="post" action="">
<input type="hidden" name="hu" value="<?php echo $dev_address; ?>" />
<button type="submit" class="btn btn-sm1 btn-success" name="action" value="on">on</button>
<button type="submit" class="btn btn-sm1 btn-danger" name="action" value="off">off</button>
<?php if ($dev_type == "StdLM") { ?>
<button type="submit" class="btn btn-sm1 btn-default" name="bd" value="dim">dim</button>
<button type="submit" class="btn btn-sm1 btn-default" name="bd" value="bright">brt</button>
<input class="form-control" type="text" value="10%" style="width:56px" />
<input class="form-control" name="percent" type="range" min="10" max="90" step="10" value="10" />
<?php } ?>
</form>
</div>
<div class="progress">
<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $dev_level; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $dev_level; ?>%"><?php echo ' ' . $dev_level . '% '; ?></div>
</div>
<?php
}
if($count == ceil(count($devices)/2)) {
?>
</div>
</div>
</div>
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title">Devices</h3>
</div>
<div class="panel-body">
<?php
}
}
}
?>
</div>
<div class="panel-heading">
<h3 class="panel-title">Scenes</h3>
</div>
<div class="panel-body">
<?php
$get_scenes = $heyuvar . 'show scene';
$scenes = explode(":", preg_replace('/( )+/', ' ', str_replace("scene", ":", str_replace("[Scenes]", "", shell_exec($get_scenes)))) . ":");
if (!empty($scenes)) {
?>
<form class="myform" method="post" action="">
<div class="span4">
<select class="form-control" name="sc">
<option value="">Select Scene</option>
<?php
foreach ($scenes as &$scene) {
list($sc_name, $sc_action, $sc_group, $sc_action2, $sc_dim, $sc_dim2) = explode(":", str_replace(" ", ":", trim($scene)));
if ($sc_name) echo "<option value=\"$sc_name\">" . ucwords(str_replace("_", " ", $sc_name)) . "</option>";
}
?>
</select>
</div>
<?php
}
?>
<input type="submit" value="Submit" class="btn btn-sm1 btn-default" />
</div>
</form>
</div>
</div>
</div>
</div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js?ver=CDN"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
$("[type=range]").change(function(){
var newv=$(this).val() + '%';
$(this).prev().val(newv);
});
});
</script>
</body>
</html>
