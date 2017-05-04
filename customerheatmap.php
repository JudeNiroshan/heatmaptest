<?php
require("includefiles/settings.php");
require("session_check.php");

//print_r($LocIdrowaccess);
foreach($LocIdrowaccess as $CompCode)
{
$q.="LocationID = '$CompCode' or ";
}
$y = substr($q,0,-3);
?>



<?php
	if(isset($_REQUEST['submit'])){
		
	  $from_date=$_REQUEST['from'];
	 $to_date=$_REQUEST['to'];
	 $loc=$_REQUEST['loc'];
	 $locto=$_REQUEST['locto'];
     $zonefrom=$_REQUEST['zonefrom'];
     $zoneto=$_REQUEST['zoneto'];
	 
	 $from = date("Y-m-d", strtotime($from_date) );
	 $to = date("Y-m-d", strtotime($to_date) );
	
	if(!empty($loc)){ 	
	$l_name=mysql_query("SELECT LocationID, LocationName from location Where LocationName like '%".$loc."%'");
	while($loc_name=mysql_fetch_assoc($l_name)){
	$alllocationid[]=$loc_name['LocationID'];
	}
	$alllocationid=implode(",",$alllocationid);
	if($alllocationid){}else{$alllocationid=0;}
    $locatinquery=" and (l.LocationID IN (".$alllocationid.") or l.LocationID='".$loc."')"; 
	}
	
	if(!empty($locto)){ 	
	$l_name=mysql_query("SELECT LocationID, LocationName from location Where LocationName like '%".$locto."%'");
	while($loc_name=mysql_fetch_assoc($l_name)){
	$alllocationid[]=$loc_name['LocationID'];
	}
	$alllocationid=implode(",",$alllocationid);
	if($alllocationid){}else{$alllocationid=0;}
    $locatinquery=" and (l.LocationID IN (".$alllocationid.") or l.LocationID='".$locto."')"; 
	}
	
	if(!empty($loc) && !empty($locto)){ 	
	$l_name=mysql_query("SELECT LocationID, LocationName from location Where LocationName like '%".$locto."%'");
	while($loc_name=mysql_fetch_assoc($l_name)){
	$alllocationid[]=$loc_name['LocationID'];
	}
	$alllocationid=implode(",",$alllocationid);
	if($alllocationid){}else{$alllocationid=0;}
    $locatinquery=" and l.LocationID BETWEEN '".$loc."' and '".$locto."'"; 
	}
	
	
	
	if(!empty($from_date) && !empty($to_date)){
	  $datequery=" and z.TransactionDate BETWEEN '".$from."' and '".$to."'"; 
	}
	
	//When zone from is only selected by the user
	if(!empty($zonefrom) && empty($zoneto)){
	  $zonequery=" and (z.zoneID IN ($zonefrom) OR z.zoneID = $zonefrom)"; 
	}
	
	//When zone to is only selected by the user
	if(empty($zonefrom) && !empty($zoneto)){
	  $zonequery=" and (z.zoneID IN ($zoneto) OR z.zoneID = $zoneto)"; 
	}
	
	if(!empty($zonefrom) && !empty($zoneto)){
	  $zonequery=" and z.zoneID BETWEEN $zonefrom AND $zoneto"; 
	}
}
if(isset($_REQUEST['DownloadSubmit'])){
header("Location: exporthourlycustomercount.php?from=".$_REQUEST['from']."&to=".$_REQUEST['to']."&loc=".$_REQUEST['loc']."&locto=".$_REQUEST['locto']);
	 
	}
	
	?>		  
	

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
	
	<!---date range picker css------------->
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://jqueryui.com/datepicker/resources/demos/style.css">
	
	<!---date range picker css------------->

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0; text-align:center; height:105px; margin-top:10px; ">
              <a href="dashboard.php" class="site_title" style="height:105px;padding:0;"><img src="images/Credo.jpg" style="height:100px;"></a>
            </div>

            <div class="clearfix"></div>

            <br />

            <!-- sidebar menu -->
            <?php include_once("main_navigation.php");?>
            <!-- /sidebar menu -->

          </div>
        </div>

        <!-- top navigation -->
		
        <?php include_once("header.php");?>
		
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3> Hourly customer Count Report </h3>
              </div>			  
			  
              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <span class="input-group-btn">
                   
                    </span>
                  </div>
                </div>
				
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">			  
				<div class="col-md-10">
 				<div style="margin-left:10%;">
 
			  <form class="form-horizontal" method="GET" action="">
                 <fieldset>
                    <div class="control-group">
					<?php if($_REQUEST){ ?>
                        <label for="from">From</label>
						<input type="text" id="from" name="from" value="<?php echo $from_date; ?>">
						<label for="to">to</label>
						<input type="text" id="to" name="to" value="<?php echo $to_date; ?>">
						<label>Location From </label>
						<input type="text" id="loc" name="loc" value="<?php echo $loc; ?>">
						
						<label>Location To</label>
						<input type="text" id="locto" name="locto" value="<?php echo $locto; ?>">
						<input type="submit" name="submit" value="Search" />
						
												&nbsp;&nbsp;<input type="submit" name="DownloadSubmit" value="Download">

						<?php }else{ ?>
						 <label for="from">From</label>
						<input type="text" id="from" name="from" value="<?php echo $from_date; ?>">
						<label for="to">to</label>
						<input type="text" id="to" name="to" value="<?php echo $to_date; ?>">
						
						<label>Location From</label>
						<input type="text" id="loc" name="loc" value="<?php echo $loc; ?>">
						
						<label>Location To</label>
						<input type="text" id="locto" name="locto" value="<?php echo $locto; ?>">
						<label>Zone From</label>
						<input type="text" id="zonefrom" name="zonefrom" value="<?php echo $zone; ?>">
						<label>Zone To</label>
						<input type="text" id="zoneto" name="zoneto" value="<?php echo $zone; ?>">
						
						<input type="submit" name="submit" value="Search" />
						
												&nbsp;&nbsp;<input type="submit" name="DownloadSubmit" value="Download">
						
				<?php	} ?>
                       </div>
                   </fieldset>
                </form>
			  
				<div style="clear:both;"></div>
				
				 
				 <div class="x_panel">
                  <div class="x_title">
                    <h2>Hourly Wise graph</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
				  
                  <div class="x_content">
                    <canvas id="mybarChart"></canvas>
                  </div>
                </div>
				  </div></div>
			  
          <div class="x_panel">               
                  <div class="x_content">
                    <?php
                        $blob_result = mysql_query("SELECT z.ZoneImage as blob, z.locationID as lid, z.zoneID as zid FROM location l, zonemaster z WHERE l.locationID = z.locationID $locatinquery $zonequery $datequery");
                        
						if(mysql_num_rows($blob_result) == 0){
							//No results are there. let the user to know about it.
							echo "<p>No matching images found</p>";
						}else{
							$unique_id = 1;
							while($single_blob_record = mysql_fetch_array($blob_result)){
								
							  $img_obj = $single_blob_record['blob'];
							  $locationID = $single_blob_record['lid'];
							  $zoneID = $single_blob_record['zid'];

							  $points = mysql_query("SELECT h.FirstAxis, h.SecondAxis, h.ValueInSec FROM heatmapinfo h WHERE h.locationID = $locationID AND h.zoneID = $zoneID");
							  
							  $X = [];
							  $Y = [];
							  $C = [];
							  
							  while($point_record = mysql_fetch_assoc($points)){

									array_push($X, $point_record['FirstAxis']);
									array_push($Y, $point_record['SecondAxis']);
									array_push($Y, $point_record['ValueInSec']);
							  }
							  $js_X = json_encode($X);
							  $js_Y = json_encode($Y);
							  $js_C = json_encode($C);
							  ?>
							  <script type="text/javascript">
									var X = [];
									var Y = [];
									var C = [];
									<?php
										echo "X = ". $js_X . ";\n";
										echo "Y = ". $js_Y . ";\n";
										echo "C = ". $js_C . ";\n";
									?>
									
									var JSONData_holder = {};
									
									
									
							  </script>
							  <div class="grid_row">
									<div id="ImageWrapper" class="grid_col-xs">
										
										<?php if(mysql_num_rows($blob_result) == 1){?>
						
													
													<div id="unq<?php echo"$unique_id"; ?>" style="background-image: url(img/retailshop.jpg);background-size:100%;width: 100%;height: 0;padding-top: 66.64%;" >
													</div>					
													
										<?php }else{?>
										
													
													<div id="parentID" style="background-image: url(img/retailshop.jpg);background-size:100%;width: 100%;height: 0;padding-top: 66.64%;" >
													</div>					
													
													
													<div id="parentID" style="background-image: url(img/retailshop.jpg);background-size:100%;width: 100%;height: 0;padding-top: 66.64%;" >
													</div>					
													
										<?php } ?>
										
									</div>
							  </div>
							<?php
							$unique_id = unique_id + 1;
							}
						
						}
						?>
						
						
							
							
						
                  </div>
          </div>
			  
                <div class="x_panel">               
                  <div class="x_content">  

                  <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Location Code</th>
                          <th>Location Name</th>
                          <th>Date</th>
						              <th>Shift Name</th>
						              <th>Hour</th>
                          <th>Customer Visited</th>           
                        </tr>
                      </thead>

                      <tbody>

                      </tbody>
                    </table>
                                      
                				  
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Location Code</th>
                          <th>Location Name</th>
                          <th>Date</th>
						  <th>Shift Name</th>
						  <th>Hour</th>
                          <th>Customer Visited</th>           
                        </tr>
                      </thead>

                      <tbody>
							<?php $i=1;	
							
		//echo "SELECT LocationID, TransactionDate, ObjectEntryTime, count(ObjectIdentifyID) From objecttransactiondetails  where Status='Active' $locatinquery  $datequery  Group by TransactionDate, LocationID order by LocationID, TransactionDate";
							
		$count=mysql_query("SELECT LocationID, TransactionDate, ObjectEntryTime, HOUR(objectentrytime), count(ObjectIdentifyID) From facetransactiondetails where ($y) $locatinquery  $datequery Group by HOUR(objectentrytime), TransactionDate, LocationID order by LocationID, TransactionDate, HOUR(objectentrytime)");
		
					 while($objectcount=mysql_fetch_assoc($count)){	
					 
					  $locationcount=mysql_query("SELECT LocationName FROM `location` WHERE LocationID='".$objectcount['LocationID']."'");
					  $loc=mysql_fetch_assoc($locationcount);	
					  
					  $GetObjectEntryTime = $objectcount['ObjectEntryTime'];
					  $GetObjectExitTime = $objectcount['ObjectEntryTime'];
					  
					  //echo $query = "SELECT ShiftName FROM shiftmaster WHERE `LocationID`='".$objectcount['LocationID']."' and  StartTime < TIME('".$GetObjectEntryTime."')"; 
					  
					  $GetShiftTime = mysql_query("SELECT ShiftName FROM shiftmaster WHERE StartTime < TIME('".$GetObjectEntryTime."') AND EndTime > TIME('".$GetObjectExitTime."')");
					  $ShiftNameRow=mysql_fetch_assoc($GetShiftTime);	
					  
					   $Hourtime = date("H",strtotime($GetObjectEntryTime));
					  
					  $GetHourDetail = mysql_query("SELECT * FROM hour_master WHERE HourDetail='".$Hourtime."'");
					  $GetHourDetailRow=mysql_fetch_assoc($GetHourDetail);	
					  
					?>
					
                        <tr>					
                          <td><?php echo $i;?> </td>
                          <td><?php echo $objectcount['LocationID']; ?></td>
                          <td><?php echo $loc['LocationName']; ?></td>
                          <td><?php echo $objectcount['TransactionDate']; ?></td>
						  <td><?php echo $ShiftNameRow['ShiftName'];  
						  //echo "SELECT ShiftName FROM shiftmaster WHERE StartTime < TIME('".$GetObjectEntryTime."') AND EndTime > TIME('".$GetObjectExitTime."')";
						  ?></td>
						  <td><?php  echo $GetHourDetailRow['time'];?></td>
                          <td><?php echo round($objectcount['count(ObjectIdentifyID)']/1,0,PHP_ROUND_HALF_UP); ?></td>
                        </tr>
                     <?php $i++;  } ?>	
                        
                       
                      </tbody>
                    </table>
					
                  </div>
                </div>
              </div></div></div>			
                
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
         <?php require("footer.php"); ?>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- Datatables -->
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
    <script src="vendors/jszip/dist/jszip.min.js"></script>
    <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="vendors/pdfmake/build/vfs_fonts.js"></script>
	
	 <script src="vendors/Chart.js/dist/Chart.min.js"></script>
	 
	 <script src="js/moment/moment.min.js"></script>
    <script src="js/datepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>

    <!-- Datatables -->
    <script>
      $(document).ready(function() {
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable();

        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        var $datatable = $('#datatable-checkbox');

        $datatable.dataTable({
          'order': [[ 1, 'asc' ]],
          'columnDefs': [
            { orderable: false, targets: [0] }
          ]
        });
        $datatable.on('draw.dt', function() {
          $('input').iCheck({
            checkboxClass: 'icheckbox_flat-green'
          });
        });

        TableManageButtons.init();
      });
    </script>
    <!-- /Datatables -->



<?php

//echo "SELECT LocationID, TransactionDate, ObjectEntryTime, HOUR(objectentrytime), count(ObjectIdentifyID) From objecttransactiondetails where Status='Active' AND ($y) $locatinquery  $datequery Group by HOUR(objectentrytime), TransactionDate, LocationID order by LocationID, TransactionDate, HOUR(objectentrytime)";

$LocationSetQuery = mysql_query("SELECT LocationID, TransactionDate, ObjectEntryTime, HOUR(objectentrytime), count(ObjectIdentifyID) From facetransactiondetails where ($y) $locatinquery  $datequery Group by HOUR(objectentrytime), TransactionDate, LocationID order by LocationID, TransactionDate, HOUR(objectentrytime)"); 

$one = 0;
$two = 0;
$twentythree = 0;

while($LocationGetRow = mysql_fetch_array($LocationSetQuery))
{}


//$TotalHourValue_array = $one.','. $two.','. $twothree;


$GetHourTime = mysql_query("SELECT * FROM hour_master ORDER by id ASC");
while($GetHourTimeRow=mysql_fetch_array($GetHourTime))
{
$HourName_array[] = "\"".$GetHourTimeRow['time']."\""; 

//echo "select mycount, sum(mycount) as sumcount from ( SELECT count(ObjectIdentifyID) AS mycount From objecttransactiondetails where Status='Active' AND ($y) $locatinquery  $datequery and HOUR(objectentrytime)='".$GetHourTimeRow['HourDetail']."'  Group by HOUR(objectentrytime), TransactionDate, LocationID order by LocationID, TransactionDate, HOUR(objectentrytime))counttable"; 


/*select mycount, sum(mycount) as sumcount from (SELECT count(ObjectIdentifyID) AS mycount From objecttransactiondetails where Status='Active' AND (LocationID = '1001' or LocationID = '1002' ) and HOUR(objectentrytime)='23' Group by HOUR(objectentrytime), TransactionDate, LocationID order by LocationID, TransactionDate, HOUR(objectentrytime)) counttable*/



$LocationSetQuerynaming = mysql_query("select mycount, sum(mycount) as sumcount from ( SELECT count(ObjectIdentifyID) AS mycount From facetransactiondetails where ($y) $locatinquery  $datequery and HOUR(objectentrytime)='".$GetHourTimeRow['HourDetail']."'  Group by HOUR(objectentrytime), TransactionDate, LocationID order by LocationID, TransactionDate, HOUR(objectentrytime))counttable"); 

$GetAllCountData=mysql_fetch_assoc($LocationSetQuerynaming);


if($GetAllCountData['sumcount']){
$TotalHourValue_array[] =$GetAllCountData['sumcount'];
}else{
$TotalHourValue_array[] ='0';
}

}



$HourName_array = implode(", ", $HourName_array);
$TotalHourValue_array = implode(", ", $TotalHourValue_array);

?>
	<script type="text/javascript">
      Chart.defaults.global.legend = {
        enabled: false
      };
	  // Bar chart
      var ctx = document.getElementById("mybarChart");
      var mybarChart = new Chart(ctx, {
        type: 'bar',
        data: {
           labels: [<?=$HourName_array?>],
          datasets: [{
            label: 'Hourly',
            backgroundColor: "#26B99A",
            data: [<?=$TotalHourValue_array?>]
          }]
        },

        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });

     
    </script>
	
	
<!---------------date range picker---------->
     
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

	 <script>
  $( function() {
    var dateFormat = "mm/dd/yy",
      from = $( "#from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
  </script>
  <!------Date range picker------------->
	
	
	</body>
</html>