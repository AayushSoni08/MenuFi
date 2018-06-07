<?php
    $conn = mysqli_connect("localhost","root", "", "menufi");
    $s = "SELECT * FROM menu";
    $r = $conn -> query($s);
    $categories = array();
    while($rf = $r -> fetch_assoc()){
        array_push($categories, $rf['Category']);
    }
    $categories = array_unique($categories);
	//echo $latest;
	$ye = 0;
    if(isset($mobno) && isset($tableno)){
        //echo $address;
         //echo $mobno;
        
            $ye = 1;
        
        //$_SESSION['isredirect']=1;
        //header("Location: create_orderH?mobno=$mobno&address=$address&table=-1&CreateOrder=Create+Order");
    }
	// Pending Cash Order
	$q = $this->db->query("SELECT order_status.Order_id as Order_id,sales.net_total as net_total from order_status ,sales where day(order_status.TIMESTAMP)= day(curdate()) and order_status.status=3 and sales.Order_id = order_status.Order_id")->result_array();
    $pendingOrders = $q;
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

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

		<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>


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
							<i class="fa fa-user fa-fw"></i>
							<i class="fa fa-caret-down"></i>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<li>
								<a href="<?php echo base_url(); ?>index.php/Admin/changePwd">
									<i class="fa fa-sign-out fa-fw"></i> Change Password</a>
							</li>
							<li>
								<a href="<?php echo base_url(); ?>index.php/Admin/logout">
									<i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
			<div class="row" style="padding-top:30px;padding-bottom:30px;">
            <div class="col-sm-3">

            <a href="<?php echo base_url('index.php/Admin/DineIn'); ?>" style="font-size:40px;" class="btn btn-info btn-lg">Dine In</a>
            </div>
            
            <div class="col-sm-3">

            <a href="<?php echo base_url('index.php/Admin/TakeAway'); ?>" style="font-size:40px;" class="btn btn-info btn-lg">Take Away</a>
            </div>
            <div class="col-sm-3">

            <a href="<?php echo base_url('index.php/Admin/HomeDelivery'); ?>" style="font-size:40px;" class="btn btn-info btn-lg">Home Delivery</a>
            </div>
                                        </div>
            <div class="row">
				
								<div class="col-lg-12">
									<h1 class="page-header">Manual Order</h1>
									<div class="form-body">
										<!-- JAVASCRIPT ADD ITEM TO ORDER CONTENT WILL BE HERE -->
										<?php if(!(isset($_SESSION['order_id']))){ ?>
										<div class="col-lg-5" style="color: white">
											<form method="post" action="create_orderD">
												<div class="form-group">Mobile No.
													<input id="nu" pattern="[7-9]{1}[0-9]{9}" type="text" name="mobno" class="form-control" required>
												</div>
												<br>
												<div class="form-group">Table No.
													<input id="tbl" type="number" name="table" class="form-control" value="<?php if(isset($tid)){echo $tid;}?>" required>
												</div>
												<br>
												<div class="form-group">
													<input id="some" class="form-control" type="submit" name="CreateOrder" class="form-control" value="Create Order">
													<br>
												</div>
											</form>
										</div>
										<?php }
                        else{ ?>
										<div class="col-md-12">
											<div class="col-lg-6">
												<div>
													<h4 style="color:white;">
														<?php $oid=$_SESSION['order_id']; echo "Order No.:".$oid;?>
													</h4>
													<h4 style="color: white"> Search Menu Item</h4>
													<form method="post" action="searchD">
														<input name="search" class="form-control" id="search">
														<br>
														<input type="submit" id="sch_btn" value="Search" class="form-control" />
														<div class="row" style="padding:5px;margin-left:0px;">
															<input style="margin-top:5px;margin-right:5px; width:140px;height:50px;" type="button" value="Show All" onclick="filter('')" class="btn btn-primary">
															<?php foreach($categories as $category){ ?>
															<input style="margin-top:5px;margin-right:5px; width:140px;height:50px;" type="button" value="<?php echo $category; ?>" onclick="filter('<?php echo $category ?>')"
															class="btn btn-primary">
															<?php } ?>
														</div>

													</form>
												</div>
												<br>
												<hr>
												<br>

											</div>
											<div class="col-md-6">
												<div align="center">
													<div class="panel panel-info" style="color:black;">
														<div class="panel panel-primary panel-heading">ORDER(Set Quantity Zero to Remove)</div>
														<div class="panel-body">
															<div class="table-responsive">
																<form action="complete_orderD" method="post">
																	<table class="table table-bordered">
																		<tr>
																			<th>Item ID</th>
																			<th>Item Name</th>
																			<th class="col-md-4">Quantity</th>
																			<th> Addons </th>
																			<th> Batter </th>
																		</tr>
																		<?php 
                                                if(isset($fake) && !empty($fake)){
                                                    foreach ($fake as $value) {
                                                ?>
																		<tr>
																			<td>
																				<?php echo $value['Menu_id']; ?>
																				<input type="hidden" name="Menu_id[]" value="<?php echo $value['Menu_id']?>" class="form-control">
																			</td>
																			<td>
																				<?php echo $value['name']; ?>
																				<input type="hidden" name="name[]" value="<?php echo $value['name']?>" class="form-control">
																			</td>
																			<td>
																				<div class="input-group">
																					<input type="number" id="quantity" name="quantity[]" class="form-control input-number" value="<?php echo $value['quantity']?>"
																					min="0" max="100">
																				</div>
																			</td>
																			<td>
																				<?php $he = $value['Menu_id'];
                                                            $v = $value['quantity'];
                                                        $ssql = "SELECT * FROM fake_order WHERE Menu_id='$he' AND Quantity='$v'";
                                                        $req = $conn -> query($ssql);
                                                        $raw = $req -> fetch_assoc();
                                                        ?>
																				<input type="hidden" name="addon[]" value="<?php echo $raw['addon']; ?>" class="form-control">

																				<?php
                                                        //$x = substr($raw['addon'], 0, -1);
                                                        //echo $x;
                                                        $arr = explode(',',$raw['addon']);
                                                        if(count($arr)>0){
                                                            foreach($arr as $val){
                                                                $sq = "SELECT * FROM ingredients WHERE Ingredients_id = '$val'";
                                                                $ress = $conn -> query($sq);
                                                                $ra = $ress -> fetch_assoc();
                                                                echo $ra['Name']."<br>";
                                                            }
                                                            
                                                        }
                                                      ?>
																			</td>
																			<td>
																			<input type="hidden" name="batter[]" value="<?php echo $raw['batter']; ?>" class="form-control">
																			<?php
																				$batter_id = $raw['batter'];
																				$sql = "SELECT * FROM batter WHERE id='$batter_id'";
																				if($res = $conn -> query($sql)){
																					echo $res -> fetch_assoc()['name'];
																				}
																			?>
																			</td>
																		</tr>
																		<?php }
                                                }else{
                                                    echo "No Item added Yet";
                                                }?>

																	</table>
																	<button type="submit" name="place_order" class="form-control btn btn-success">Place Order</button>
																</form>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										
									</div>
								</div>
							</div>
							
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Update Cash Orders</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
            <?php
            
            ?>
           
            <div class="row" id="div_offlineOrders">
                <?php if(!empty($pendingOrders)){
                                     foreach ($pendingOrders as $value) {
//    echo '<option value="'.$value["id"].'">'.$value['Order_id'].'</option>';
                                        
                        $idr = $value['Order_id'];
                        $sq3 = "SELECT * FROM customer_order WHERE Order_id='$idr'";
                        $ress = $conn -> query($sq3);
                        // print_r($ress);
                        if(mysqli_num_rows($ress) == 0 ){
                            continue;
                        }
                                        ?>  
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12" >
                                    <input type="hidden" name="id" value="<?php echo $value['Order_id'];?>">
                                    <span id="printspan<?php echo $value['Order_id']; ?>">
                                    <h3 class="text-center">Order No.<?php echo $value['Order_id']; ?></h3>
                                    <?php while($raw = $ress -> fetch_assoc()){ ?>
                    <p><strong ><?php 
                        //print_r($raw);
                        $q = $raw['Quantity'];
                        echo $raw['Quantity']." x "; ?>
                        
                    </strong>
                    <?php
                            $mid = $raw['Menu_Id'];
                            $sq4 = "SELECT * FROM menu WHERE Menu_Id='$mid'";
                            $ra = $conn -> query($sq4);
                            $rs = $ra -> fetch_assoc();    
                            echo $rs['Name'].": ".($q*$rs['Price']); 
                            ?>
                </p>
                        <?php } ?>
                        <p><strong>CGST: </strong><?php 
                    
                    $sq = "SELECT * FROM sales WHERE Order_id='$idr'";
                    $r = $conn -> query($sq);
                    $r2 = $r -> fetch_assoc();
                    
                    echo $r2['cgst']; ?></p>
                    <p><strong>SGST: </strong><?php echo $r2['sgst']; ?></p>
                                    <h4>Bill Amount :<?php echo $value['net_total'];
                                        if($r2['coupon_apply']){
                                            echo "<br><small> (coupon applied)</small>";
                                        }
                                    
                                    ?>
                                        
                                        
                                </h4>
                                    </span>
                                    <?php
                                        if(!$r2['coupon_apply']){
                                    ?>
                                    <input id="code" class="form-control" placeholder="Coupon Code" >
                                    <br>
                                    <input type="submit" value="Apply Coupon" class="btn btn-success form-control" onclick="apply_code('<?php echo $idr; ?>')" >
                                    <br>
                                    <?php 
                                        }
                                    ?>
                                    <div>
                                        <br>
                                        <input type="submit" value="Pay" class="btn btn-success form-control" onclick="pay_it('<? echo $idr; ?>');print('<?php echo $idr; ?>');" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                            
                        
                    </div>
                </div>
                <?php
                }
                                  }
                                  
                                  else{
                                      echo '<div class="col-lg-12">No Offline Orders.</div>';
                                  }
?>

					</div>
						<br/><br/>
							<div class="col-lg-12">
								<div class="panel panel-info">
									<div class="panel-heading">
										Menu
									</div>
									<!-- /.panel-heading -->
									<div class="panel-body">

										<div class="table-responsive">

											<table class="table table-bordered">
												<tr>
													<th>Menu Id</th>
													<th>Name</th>
													<th>Category</th>
													<th>Quantity</th>
													<th>Addon</th>
													<th>Addons Added</th>
													<th>Batter</th>
													<th>Add Item</th>
												</tr>
												<?php 
                                                if(isset($query2) && !empty($query2)){
                                                    foreach ($query2 as $value) {
                                                ?>
												<tr id="<?php echo $value['Menu_Id']; ?>" class="menu-item <?php echo str_replace(' ','',$value['Category']); ?>">
													<form action="addfakeD" method="post">
														<td>
															<input type="text" name="Menu_id" class="form-control" value='<?php echo $value['Menu_Id'];?>'>
														</td>
														<td>
															<?php echo $value['Name']; ?>
														</td>
														<td>
															<?php echo $value['Category'];?>
														</td>
														<td>
															<input type="number" name="quantity" class="form-control">
														</td>
														<td>
															<?php
                                                    $m = $value['Menu_Id'];
                                                    echo "<select onchange='addon(".$m.")' id="."'ad".$m."'>";
                                                    echo "<option value='-1'> No addons</option>";
                                                     $sql = "SELECT * FROM menu_ingridient_rel WHERE addons = '1' AND Menu_id = '$m'";
                                                     $result = $conn->query($sql);
                                                     if($result->num_rows >0){
                                                        while($row = $result -> fetch_assoc()){
                                                            $ix = $row['Ingredients_id'];
                                                            $sql = "SELECT * FROM ingredients WHERE Ingredients_id = '$ix'";
                                                            $res = $conn -> query($sql);
                                                            $ro = $res -> fetch_assoc();
                                                            echo "<option value=".$ro['Ingredients_id'].">" .$ro['Name']."</option>";
                                                        }
                                                     }else{
                                                            
                                                     }
                                                     
                                                     
                                                    
                                                    ?></select>
																<input class="hidden" name='addon_list' id="addonv<?php echo $value['Menu_Id'] ?>">
														</td>
														<td id="addon<?php echo $value['Menu_Id'] ?>">

														</td>
														<td>
															<select name="batter">
																<?php 
																	$sql = "SELECT * FROM batter";
																	$res = $conn -> query($sql);
																	while($row = $res -> fetch_assoc()){
																		?> 
																		<option value="<?php echo $row['id']; ?>">
																		<?php
																		echo $row['name'];
																		?>
																	</option>
																		
																		<?php
																	}
																
																?>
															</select>
															

														</td>
														<td>
															<input type="submit" name='add' value="Add Item" class="btn btn-primary">
														</td>
													</form>
												</tr>

												<?php }
                                                
                                                }
                                                else{                
                                                        echo 'Data not available at this moment.';
                                                }
                                                ?>
											</table>
										</div>
									</div>
                                </div>
                               
                                


                            </div>
                                           
                            <?php }?>
				<div class="row">
					<div class="col-md-12" style="padding-top:20px;">
                            
                                
                                
                                
                                
    
                                
                                        </div>
                                        </div>
                                        </div>
                                    
                                						<!-- /.row -->
						
							</div>
                            </div>
                            
							
						</div>

					</div>
					<!-- /#wrapper -->

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
					<script>
						function addon(idOfMenu) {
							console.log(idOfMenu);
							if ($('#ad' + idOfMenu).val() == -1) {
								//alert("here");
								$('#addonv' + idOfMenu).val('');
								$('#addon' + idOfMenu).html('');
								return;
							}
							let data = $('#' + idOfMenu + " option:selected").html();
							console.log(data);
							$('#addon' + idOfMenu).append(data + "<br>");
							let x = $("#addonv" + idOfMenu).val();
							console.log(x);
							x += $('#ad' + idOfMenu).val() + ",";
							console.log(x);
							$('#addonv' + idOfMenu).val(x);
						}

						function filter(category) {
							if (category == '') {
								$(".menu-item").removeClass('hidden');
								return;
							}
							category = category.replace(/\s/g, "");
							$('.menu-item').addClass('hidden');
							$('.' + category).removeClass('hidden');


						}
						if(<?php echo $ye ?>){
            
            $('#nu').val('<?php if(isset($mobno)){
                echo $mobno;
            } ?>'); 
			$('#tbl').val('<?php if(isset($tableno)){
				echo $tableno;
			} ?>')
            $('#some').click();
        }   

						

</script>
<script>
<script>
    
//        getOfflineOrders();
//        setInterval(function(){getOfflineOrders()},5000);
function pay_it(id){
            $.ajax({
                type: 'GET',
                url: 'ajax_payOrder',
                data:{
                    'id':id
                },
                cache:false,
                
                success: function(resp){
                    console.log(resp);
                    if(resp == 'success'){
                        window.location = '';
                    }

            }
            });

        }
        
        function getOfflineOrders(){
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>index.php/Admin/ajx_cashOrders',
                
                cache:false,
                dataType:'html',
                success: function(resp){
                    $('#div_offlineOrders').html(resp);

            }
            });
        }

        function apply_code(id){
			
            let code = $('#code').val();
            $.ajax({
                type: 'GET',
                url: 'ajax_applyCode',
                data:{
                    'id':id,
                    'code':code
                },
                cache:false,
                
                success: function(resp){
                    if(resp=='success'){
                        alert('Applied Coupon!');
                        window.location = '';
                    }else{
                        alert(resp);
                    }

            }
            });

        }

        function print(id){
            var divContents = $("#printspan"+id).html();
            var printWindow = window.open('', '', 'height=300,width=600');
            printWindow.document.write(`<html><head><style>@page {
                size: 3in 3.6in;
   margin: 30%
}
</style><title></title>`);
            printWindow.document.write('</head><body style="height:100px;width:300px;">');
            printWindow.document.write(divContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
        
        
 
        
  
</script>
</script>

	</body>

	</html>
