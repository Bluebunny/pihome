<?php require_once("st_inc/session.php"); ?>
<?php confirm_logged_in(); ?>
<?php require_once("st_inc/connection.php"); ?>
<?php require_once("st_inc/functions.php"); ?>
<?php
if (isset($_POST['submit'])) {
 		$sc_en = isset($_POST['sc_en']) ? $_POST['sc_en'] : "0";
		$start_time = mysql_prep($_POST['start_time']);
		$end_time = mysql_prep($_POST['end_time']);
		$query = "INSERT INTO schedule_daily_time( status, start, end) VALUES ('{$sc_en}', '{$start_time}','{$end_time}')"; 
		$result = mysql_query($query, $connection);

		$schedule_daily_time_id = mysql_insert_id();

		if ($result) {
			$message_success = "Schedule Time Added Successfully!!!";
			header("Refresh: 3; url=schedule.php");
		} else {
			$error = "<p>{$LANG['username_create_failed']}</p><p>" . mysql_error() . "</p>";
		}
	
	foreach($_POST['id'] as $id){
		$id = $_POST['id'][$id];
		$status = isset($_POST['status'][$id]) ? $_POST['status'][$id] : "0";
		$status = $_POST['status'][$id];
		$temp = $_POST['temp'][$id];
		$query = "INSERT INTO schedule_daily_time_zone(status, schedule_daily_time_id, zone_id, temperature) VALUES ('{$status}', '{$schedule_daily_time_id}','{$id}','{$temp}')"; 
		$zoneresults = mysql_query($query, $connection);
	}
}
?>
<?php include("header.php"); ?>
<?php include_once("notice.php"); ?>
        <div id="page-wrapper">
<br>
            <div class="row">
                <div class="col-lg-12">
				<div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> Add Schedule 
						<div class="pull-right"> <div class="btn-group"><?php echo date("H:i"); ?></div> </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                <form data-toggle="validator" role="form" method="post" action="<?php $_SERVER['PHP_SELF'];?>" id="form-join">

				<div class="checkbox checkbox-default checkbox-circle">
                <input id="checkbox0" class="styled" type="checkbox" name="sc_en" value="1" <?php if(isset($_POST['sc_en'])){ echo "checked";}?>>
                <label for="checkbox0"> Enable Schedule</label>
                <div class="help-block with-errors"></div></div>

		
				<div class="form-group" class="control-label"><label>Start Time</label>
				<input class="form-control input-sm" type="time" id="start_time" name="start_time" value="<?php if(isset($_POST['start_time'])) { echo $_POST['start_time']; } ?>" placeholder="Start Time" required>
                <div class="help-block with-errors"></div></div>
				
				<div class="form-group" class="control-label"><label>End Time</label>
				<input class="form-control input-sm" type="time" id="end_time" name="end_time" value="<?php if(isset($_POST['end_time'])) { echo $_POST['end_time']; } ?>" placeholder="End Time" required>
                <div class="help-block with-errors"></div></div>				
<?php 
$query = "select * from zone";
$results = mysql_query($query, $connection);	
while ($row = mysql_fetch_assoc($results)) {
?>

	<input type="hidden" name="id[<?php echo $row["id"];?>]" value="<?php echo $row["id"];?>">
	
	<div class="checkbox checkbox-default  checkbox-circle">
    <input id="checkbox<?php echo $row["id"];?>" class="styled" type="checkbox" name="status[<?php echo $row["id"];?>]" value="1" onclick="$('#<?php echo $row["id"];?>').toggle();">
    <label for="checkbox<?php echo $row["id"];?>"><?php echo $row["name"];?></label>
    <div class="help-block with-errors"></div></div>

	<div id="<?php echo $row["id"];?>" style="display:none !important;"><div class="form-group" class="control-label">
	<select class="form-control input-sm" type="number" id="<?php echo $row["id"];?>" name="temp[<?php echo $row["id"];?>]" placeholder="Ground Floor Temperature" >
	<option>0</option>
	<option>16</option>
	<option>17</option>
	<option>18</option>
	<option>19</option>
	<option>20</option>
	<option>21</option>
	<option>22</option>
	<option>23</option>
	<option>24</option>
	<option>25</option>
	<option>26</option>
	<option>27</option>
	<option>28</option>
	<option>29</option>
	<option>30</option>
	<option>31</option>
	<option>32</option>
	<option>33</option>
	<option>34</option>
	
	
	</select>
    <div class="help-block with-errors"></div></div></div>

<?php }?>				
                <a href="schedule.php"><button type="button" class="btn btn-primary btn-sm" >Cancel</button></a>
                <input type="submit" name="submit" value="Submit" class="btn btn-default btn-sm login">
				</form>
						</div>
                        <!-- /.panel-body -->
						<div class="panel-footer">
<?php 
$query="select * from weather";
$result = mysql_query($query, $connection);
//confirm_query($result);
$weather = mysql_fetch_array($result);
?>

Outside: <?php //$weather = getWeather(); ?><?php echo $weather['c'] ;?>&deg;C
<span><img border="0" width="24" src="images/<?php echo $weather['img'];?>.png" title="<?php echo $weather['title'];?> - 
<?php echo $weather['description'];?>"></span> <span><?php echo $weather['title'];?> - 
<?php echo $weather['description'];?></span>
                        </div>
                    </div>
                </div>

                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
		<?php include("footer.php"); ?>
