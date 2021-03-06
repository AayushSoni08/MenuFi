<?php 
    $conn = mysqli_connect("localhost","root", "", "menufi");
    $discounts = array(
        "January" => 0,
        "February" => 0,
        "March" => 0,
        "April" => 0,
        "May" => 0,
        "June" => 0,
        "July" => 0,
        "August" => 0,
        "September" => 0,
        "October" => 0,
        "November" => 0,
        "December" => 0,
      );
      $refunds = array(
        "January" => 0,
        "February" => 0,
        "March" => 0,
        "April" => 0,
        "May" => 0,
        "June" => 0,
        "July" => 0,
        "August" => 0,
        "September" => 0,
        "October" => 0,
        "November" => 0,
        "December" => 0,
      );
    $sql = "SELECT * FROM sales WHERE refund='1'";
    $res = $conn -> query($sql);
    if($res){
        while($row = $res -> fetch_assoc()){
            $r = $row['Timestamp'];
            $month = date('F',strtotime($r));
            $refunds[$month] += 1;
        }
    }
    $sql = "SELECT * FROM sales WHERE coupon_apply='1'";
    $res = $conn -> query($sql);
    if($res){
        while($row = $res -> fetch_assoc()){
            $r = $row['Timestamp'];
            $month = date('F',strtotime($r));
            $discounts[$month] += 1;
        }
    }
    

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Menu Fi</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../assets/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../assets/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../../assets/vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Menu Fi</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?php echo base_url(); ?>index.php/Admin/changePwd"><i class="fa fa-sign-out fa-fw"></i> Change Password</a>
                        </li>
                        <li><a href="<?php echo base_url(); ?>index.php/Admin/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <?php include 'nav_links.php'; ?>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Sales Execution Report</h1>
                </div>
               


                 
                 	<div class="col-lg-6">
           		 		<div class="panel panel-info">
           		 			<div class="panel-heading">Losses</div>
           		 			<div class="panel-body"> 
           		 				<canvas id="executionReport"  width="30" height="30"></canvas>
           		 			</div>	
           		 		
           		 	    </div>
           		 	</div>

<div class="col-lg-6">
                        <div class="panel panel-info">
						
                            <div class="panel-heading">Losses</div>
                            <div class="panel-body"> 
                        <table class="table table-striped table-dark">
  <thead class="thead-light">
   
      
   <tr><th>Months</th>
    <th>Discounts</th>   <th>Refunds</th></tr>
      <!-- <tr><td>January</td><td>45</td><td>35</td></tr>       -->
     <?php foreach($discounts as $k => $v){ ?>
        <tr><td><?php  echo $k; ?></td><td><?php echo $v ?></td><td><?php 
            echo $refunds[$k];
            ?></td></tr> 
     <?php } ?>
    
 
      
  </thead>
 
</table>
</div>
</div>
                        
                    </div>
                </div>
                <br><br><br><br><br><br><br><br><br><br><br><br><br>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../../assets/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../assets/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../assets/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../../assets/vendor/raphael/raphael.min.js"></script>
    <script src="../../assets/vendor/morrisjs/morris.min.js"></script>
    <script src="../../assets/data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../assets/dist/js/sb-admin-2.js"></script>

    <!--Chart.JS Javascript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>



<!--SALES EXECUTION REPORT-->
<script>
const chart4 = document.getElementById("executionReport");
Chart.defaults.global.legend.fontColor = "rgba(23,56,98,1)";
console.log(chart4);
let pieChart4 = new Chart(chart4, {
  type:'doughnut',
  data: {
    labels: ['Discounts','Refunds'],
    datasets: [
      {
        backgroundColor: ['#07B5AF','#1A8783' ],
        data:[<?php 
        $curr_m = date('F');
        echo $discounts[$curr_m];
        
        ?>,<?php 
        $curr_m = date('F');
        echo $refunds[$curr_m];
        
        ?>]
      }
    ]
  },

  options: {
    
    animation: {
      animateScale: true
    }
  }

});
</script>


   
</body>

</html>
