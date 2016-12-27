<?php
extract($_POST);
$heyuvar = "heyu -c /home/pi/.heyu/x10config ";
$heyuend = " > /dev/null 2>/dev/null &";
if((isset($hu)) && (isset($action))) {
        if (is_numeric($action)) {
                $level = (22 - round($action * (22 / 100)) == 0) ? 1 : 22 - round($action * (22 / 100));
                $heyuvar .= 'obdim ' . $hu . ' ' . $level . $heyuend;
        }else{
                $heyuvar .= $action . ' ' . $hu . $heyuend;
        }
        exec($heyuvar);
        header("Location: /");
        exit;
}
if (isset($sc)) {
        $heyuvar .= $sc . $heyuend;
        exec($heyuvar);
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
<link href="images/startup.png" media="(device-width: 320px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">
<link rel="apple-touch-icon" href="images/x10switch_icon.png"/>
<title>X10 Lighting</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-responsive.css">
<link rel="stylesheet" href="css/bootstrap-theme.min.css">
</head>
<body>
<div class="container container-fluid" role="main">
        <div class="row">
                <div class="col-md-6">
                        <div class="panel panel-default">
                                <div class="panel-heading">Devices</div>
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
                                        <form class="form-inline" id="form<?php echo $dev_address; ?>" method="post">
                                        <input type="hidden" name="hu" value="<?php echo $dev_address; ?>" />
                                        <button type="submit" class="btn btn-sm1 btn-success" name="action" value="on">On</button>
                                        <button type="submit" class="btn btn-sm1 btn-danger" name="action" value="off">Off</button>
<?php
if ($dev_type == "StdLM") { 
        for ($x = 30; $x < 100; $x+=10) { ?>
                                        <button type="submit" class="btn btn-sm1 btn-default" name="action" value="<?php echo $x; ?>"><?php echo $x; ?></button>
<?php
        }
}
?>
                                        </form>
                                        <div style="margin-top:4px">
                                                <div class="col-xs-3 label label-info"><?php echo ucwords(str_replace("_", " ", $dev_name)); ?></div>
                                                <div class="col-xs-9">
                                                        <div class="progress">
                                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $dev_level; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $dev_level; ?>%">
                                                                        <?php echo ' ' . $dev_level . '% '; ?>
                                                                </div>
                                                        </div>
                                                </div>
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
                                <div class="panel-heading">Devices</div>
                                <div class="panel-body">
<?php
}
}
}
?>
                                </div>
<?php
$get_scenes = $heyuvar . 'show scene';
$scenes = explode(":", preg_replace('/( )+/', ' ', str_replace("scene", ":", str_replace("[Scenes]", "", shell_exec($get_scenes)))) . ":");
if ((!empty($scenes)) && (trim($scenes[0]) != "-none-")) {
?>
                                <div class="panel-heading">Scenes</div>
                                <div class="panel-body">
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
                                        <input type="submit" value="Submit" class="btn btn-sm1 btn-default" /> 
                                        </form>
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
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js?ver=CDN"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>
