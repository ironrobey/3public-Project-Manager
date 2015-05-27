<br><br>
<div class="row">

	<div class="col-sm-3">
		<a href="<?php echo base_url();?>index.php?admin/client">
			<div class="tile-stats tile-red">
				<div class="icon"><i class="entypo-users"></i></div>
				<h3><?php echo get_phrase('manage_clients');?></h3>
			</div>
		</a>
	</div>

	<div class="col-sm-3">
		<a href="<?php echo base_url();?>index.php?admin/staff">
			<div class="tile-stats tile-green">
				<div class="icon"><i class="entypo-user"></i></div>
				<h3><?php echo get_phrase('manage_staffs');?></h3>
			</div>
		</a>
	</div>
	
	<div class="col-sm-3">
		<a href="<?php echo base_url();?>index.php?admin/message">
			<div class="tile-stats tile-aqua">
				<div class="icon"><i class="entypo-mail"></i></div>
				<h3><?php echo get_phrase('view_messages');?></h3>
			</div>
		</a>		
	</div>
	
	<div class="col-sm-3">
		<a href="<?php echo base_url();?>index.php?admin/system_settings">
			<div class="tile-stats tile-blue">
				<div class="icon"><i class="entypo-tools"></i></div>
				<h3><?php echo get_phrase('system_settings');?></h3>
			</div>
		</a>
	</div>
</div>

<div class="row">

	<!-- charts-->
	<div class="col-sm-6">
	
		<div class="panel panel-primary" id="charts_env">
			<div class="panel-heading">
				<div class="panel-title">
					<i class="entypo-chart-bar"></i>
					<?php echo get_phrase('lead_graph');?> (last 30 days)
				</div>
				<div class="panel-options">
					<a href="<?php echo base_url();?>index.php?admin/report_project" class="btn btn-default tooltip-primary" 
						data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('view_reports');?>"> 
							<i class="entypo-right-open-mini"></i></a>
				</div>
			</div>
	
			<div class="panel-body" >
				<div id="bar_chartdiv" style="width: 100%; height: 200px;"></div>
				<center><?php echo get_phrase('leads');?></center>
				<!--<div id="line-chart-demo" class="morrischart" style="height: 200px"></div>-->
			</div>
		</div>
	</div>

	<!-- stats-->
	<div class="col-sm-3">
	
		<div class="panel panel-primary" id="charts_env">
			<div class="panel-heading">
				<div class="panel-title">
					<i class="entypo-chart-pie"></i>
					<?php echo get_phrase('statistics');?>
				</div>
			</div>
	
			<div class="panel-body" style="height:230px;" >
				<table class="table table-responsive">
					
					
					<tbody>
						<tr>
							<td style="border-top:0px;">
								<i class="entypo-dot"></i> 
								<?php echo get_phrase('total_client');?>
							</td>
							<td style="border-top:0px;"><?php echo $this->db->get('client')->num_rows();?></td>
						</tr>
						<tr>
							<td>
								<i class="entypo-dot"></i> 
								<?php echo get_phrase('total_lead');?>
							</td>
							<td><?php echo $this->db->get('lead')->num_rows();?></td>
						</tr>
						<tr>
							<td>
								<i class="entypo-dot"></i> 
								<?php echo get_phrase('total_staff');?>
							</td>
							<td><?php echo $this->db->get('staff')->num_rows();?></td>
						</tr>
						<tr>
							<td>
								<i class="entypo-dot"></i> 
								<?php echo get_phrase('total_project');?>
							</td>
							<td><?php echo $this->db->get('project')->num_rows();?></td>
						</tr>
						<tr>
							<td>
								<i class="entypo-dot"></i> 
								<?php echo get_phrase('total_invoice');?>
							</td>
							<td><?php echo $this->db->get('invoice')->num_rows();?></td>
						</tr>
						<tr>
							<td>
								<i class="entypo-dot"></i> 
								<?php echo get_phrase('total_ticket');?>
							</td>
							<td><?php echo $this->db->get('ticket')->num_rows();?></td>
						</tr>
	
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- calculator-->
	<div class="col-sm-3">
	
		<div class="panel panel-primary" id="charts_env">
			<div class="panel-heading">
				<div class="panel-title">
					<i class="entypo-doc-text"></i>
					<?php echo get_phrase('calculator');?>
				</div>
			</div>
			<style type="text/css">
			.calc{
				width: 30px !important;
				text-align: center !important;
				margin: 1px;}
			.calc_clear{
				width: 136px;
				margin: 1px;
			}
			</style>
			<div class="panel-body" style="text-align:left;" >
				<form name="form1" onsubmit="return false"> 
				  <input type="text" name="t1" style="width:135px; margin:1px 0px; text-align:right;" class="form-control">
			      <button class="btn btn-default calc_clear" onclick="reset()">Clear</button>
			      <br>
			      <button class="btn btn-default calc" onclick="displaynum(7)">7</button>
			      <button class="btn btn-default calc" onclick="displaynum(8)">8</button>
			      <button class="btn btn-default calc" onclick="displaynum(9)">9</button>
			      <button class="btn btn-default calc" onclick="operator(&quot;+&quot;)">+</button>
			    <br>
			      <button class="btn btn-default calc" onclick="displaynum(4)">4</button>
			      <button class="btn btn-default calc" onclick="displaynum(5)">5</button>
			      <button class="btn btn-default calc" onclick="displaynum(6)">6</button>
			      <button class="btn btn-default calc" onclick="operator(&quot;-&quot;)">-</button>
			    <br>
			      <button class="btn btn-default calc" onclick="displaynum(1)">1</button>
			      <button class="btn btn-default calc" onclick="displaynum(2)">2</button>
			      <button class="btn btn-default calc" onclick="displaynum(3)">3</button>
			      <button class="btn btn-default calc" onclick="operator(&quot;*&quot;)">x</button>
			    <br>
			      <button class="btn btn-default calc" onclick="displaynum(0)">0</button>
			      <button class="btn btn-default calc" onclick="displaynum(&quot;.&quot;)">.</button>
			      <button class="btn btn-default calc" onclick="equals()">=</button>
			      <button class="btn btn-default calc" onclick="operator(&quot;/&quot;)">/</button>
			</form>

			</div>
		</div>
	</div>
</div>





<div class="row">
	
	<!-- pending running projects -->
	<?php
	$this->db->where('progress_status <' , 100);
	$this->db->order_by('project_id' , 'desc');
	$projects	=	$this->db->get('project' )->result_array();
	?>
	<div class="col-sm-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title">
					<i class="entypo-paper-plane"></i>
					<?php echo get_phrase('pending_projects');?> (<?php echo count($projects);?>)
				</div>
				<div class="panel-options">
					<a href="<?php echo base_url();?>index.php?admin/project" class="btn btn-default tooltip-primary" 
						data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('view_projects');?>"> 
							<i class="entypo-right-open-mini"></i></a>
				</div>
			</div>
				
			<div class="panel-body with-table">
				<table class="table table-bordered table-responsive">
					<thead>
						<tr>
							<th><div><?php echo get_phrase('project');?></div></th>
							<th><div><?php echo get_phrase('client');?></div></th>
							<th><div><?php echo get_phrase('progress');?></div></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach($projects as $row):
						?>
						<tr>
							<td>
								<a href="<?php echo base_url();?>index.php?admin/project_monitor/<?php echo $row['project_id'];?>">
									<?php echo $row['title'];?>
				               </a>
				           	</td>
							<td><?php echo $this->db->get_where('client' , 
									array('client_id'=>$row['client_id']))->row()->name;?>
				                    </td>
							<td>
				            	<?php 
								$status = 'info';
								if ($row['progress_status'] == 100)$status = 'success';
								if ($row['progress_status'] < 50)$status = 'danger';
								?>
				              
				              <div class="progress progress-striped <?php if ($row['progress_status']!=100)echo 'active';?> tooltip-primary" 
				                      style="height:3px !important; cursor:pointer;"  data-toggle="tooltip"  data-placement="top"
				                          title="" data-original-title="<?php echo $row['progress_status'];?>% completed" >
				                  <div class="progress-bar progress-bar-<?php echo $status;?>" 
				                  	role="progressbar" aria-valuenow="<?php echo $row['progress_status'];?>" 
				                    		aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $row['progress_status'];?>%">
				                      <span class="sr-only">40% Complete (success)</span>
				                  </div>
				              </div> 
				           </td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- current running projects -->
	<?php
	$this->db->select('B.title,A.project_id, A.timer_started_by,A.timer_starter_account_type');
	$this->db->from('project_task A');
	$this->db->join('project B', 'B.project_id = A.project_id');
	$this->db->where('A.timer_status' , 1);
	$cur_projects	=	$this->db->get()->result_array();
	?>
	<div class="col-sm-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title">
					<i class="entypo-paper-plane"></i>
					<?php echo get_phrase('whose_working_on_what?');?> (<?php echo count($cur_projects);?>)
				</div>
				<div class="panel-options"></div>
			</div>
				
			<div class="panel-body with-table">
				<table class="table table-bordered table-responsive">
					<thead>
						<tr>
							<th><div><?php echo get_phrase('project');?></div></th>
							<th><div><?php echo get_phrase('staff');?></div></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach($cur_projects as $row):
						?>
						<tr>
							<td>
								<a href="<?php echo base_url();?>index.php?admin/project_monitor/<?php echo $row['project_id'];?>">
									<?php echo $row['title'];?>
				                </a>
				           	</td>
							<td><?php echo $this->db->get_where($row['timer_starter_account_type'], 
									array($row['timer_starter_account_type'].'_id'=>$row['timer_started_by']))->row()->name;?>
				            </td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
</div>

<div class="row">
	
	<!-- opened tickets -->
	<?php

	$this->db->where('status' , 'opened');
	$this->db->order_by('ticket_id' , 'desc');
	$tickets	=	$this->db->get('ticket' )->result_array();
	?>
	<div class="col-sm-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title">
					<i class="entypo-ticket"></i>
					<?php echo get_phrase('opened_tickets');?> (<?php echo count($tickets);?>)
				</div>
				<div class="panel-options">
					<a href="<?php echo base_url();?>index.php?admin/support_ticket/opened" class="btn btn-default tooltip-primary" 
						data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('view_tickets');?>"> 
							<i class="entypo-right-open-mini"></i></a>
				</div>
			</div>
				
			<div class="panel-body with-table">
				<table class="table table-bordered table-responsive" >
					<thead>
						<tr>
							<th><div><?php echo get_phrase('title');?></div></th>
							<th><div><?php echo get_phrase('client');?></div></th>
							<th><div><?php echo get_phrase('status');?></div></th>
							<th><div><?php echo get_phrase('priority');?></div></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach($tickets as $row):
						?>
						<tr>
							<td>
								<a href="<?php echo base_url();?>index.php?admin/support_ticket_view/<?php echo $row['ticket_code'];?>">
									<?php echo $row['title'];?>
				               </a>
				           	</td>
							<td><?php echo $this->crud_model->get_type_name_by_id('client',$row['client_id']);?></td>
							<td>
								<div class="label label-<?php if ($row['status'] == 'closed')echo 'primary';
																	else if ($row['status'] == 'opened')echo 'success'?>">
									<?php echo $row['status'];?></div>
							</td>
							<td>
								<div class="label label-<?php if ($row['priority'] == 'high')echo 'danger';
																	else if ($row['priority'] == 'medium')echo 'info';
																		else if ($row['priority'] == 'low')echo 'default'?>">
									<?php echo $row['priority'];?></div>
							</td>
							
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>

			</div>
		</div>
	</div>

</div>

<?php $timestamp_start = strtotime( "-30 days" ); ?>
<?php $timestamp_end = strtotime( "-1 day" ); ?>

<script>

var chart = AmCharts.makeChart("bar_chartdiv", {
    "theme": "none",
    "type": "serial",
	"startDuration": 2,
    "dataProvider": [
	<?php
		$this->db->group_by('date_added'); 
		$this->db->order_by('date_added' , 'asc');
		$this->db->select('date_added, COUNT(*) as lead_count');
		
		$this->db->where('date_added >=' , $timestamp_start);
		$this->db->where('date_added <=' , $timestamp_end);
		$payments	=	$this->db->get('lead')->result_array();

		foreach ($payments as $row):
			?>
				{
                    "lead": "<?php echo 'Week Number ' . date('W', $row['date_added']); ?>",
                    "lead_count": <?php echo $row['lead_count'];?>,
                    "color": "#455064"
                },
	<?php endforeach;?> 
	],
    "graphs": [{
        "balloonText": "[[category]]: <b>[[value]]</b>",
        "colorField": "color",
        "fillAlphas": 1,
        "lineAlpha": 0.1,
        "type": "column",
        "valueField": "lead_count"
    }],
    "depth3D": 20,
	"angle": 30,
    "chartCursor": {
        "categoryBalloonEnabled": false,
        "cursorAlpha": 0,
        "zoomable": false
    },    
    "categoryField": "lead",
    "categoryAxis": {
        "gridPosition": "start",
        "labelRotation": 30
    },
	"pathToImages"	: "<?php echo base_url();?>assets/js/amcharts/images/",
	"amExport": {
		"top": 0,
        "right": 0,
        "buttonColor": '#EFEFEF',
        "buttonRollOverColor":'#DDDDDD',
		"imageFileName"	: "Lead Report",
        "exportPNG":true,
        "exportJPG":true,
        "exportPDF":true,
        "exportSVG":true
	}
});
</script>

<script language="javascript"> 

	// calculator custom functions
	var oper=""
	var num =""

	function displaynum(n) {
		document.form1.t1.value = document.form1.t1.value + n
	}

	function operator(op) {         
		oper = op
		num= document.form1.t1.value
		document.form1.t1.value = ""
	//document.form1.t1.value += oper
	}
	 //code for equals starts here
	 function equals() {
	 	doesthejob( eval(num) , eval(document.form1.t1.value ), oper)
	 }
	 //a sub-function of equals 
	 function doesthejob(n1,n2, op) {
	 	if (op == "+" ) 
	 		document.form1.t1.value = n1 + n2
	 	else if ( op == "-" )
	 		document.form1.t1.value = n1- n2
	 	else if (op == "*")
	 		document.form1.t1.value = n1 * n2
	 	else if (op =="/")
	 		document.form1.t1.value = n1/n2 
	 	else if (op=="nCr" )
	 		document.form1.t1.value = fact2(n1)/ fact2(n1 - n2) / fact2(n2)
	 	else if (op =="nPr")
	 		document.form1.t1.value = fact2(n1) / fact2(n1-n2)
	 }
	 //code for equals ends here

	function fact2(n) {    // fact2() for nCr & nPr
		if (errorchecking(n) ==false)  
			return

		var answer = 1
		for (i = n; i >=2; i--){
			answer = answer*i
		} 
		return answer
	}

	function fact() {
		n = Number(document.form1.t1.value)
		if (errorchecking(n) ==false) 
			return
		var answer = 1
		for (i = n; i >=2; i--){
			answer = answer*i
		} 
		document.form1.t1.value = answer
	}

	function errorchecking(n) {
		if ( n < 0) {
			alert("Number shouldn't be negative" )
			return false 
		}
		var mod = n%1
		if (!mod ==0) {
			alert("The number should be an integer" )
			return false
		}
	} 

	function prime(n) {
		if (errorchecking(n) == false)
			return
		var b = true
		for ( i = 2; i<= n/2; i ++ ) {
			if (n % i == 0 ) {
				document.form1.t1.value = "Not prime; its first divided by " + i
				b = false
				break
			}
		}
		if (b)
			document.form1.t1.value = "Is prime"
	}

	function negation() {
		document.form1.t1.value = document.form1.t1.value * -1
	}

	function reset() {
		document.form1.t1.value = ""
		num = ""
	}
</script>


