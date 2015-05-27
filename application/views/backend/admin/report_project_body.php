<?php
for ($i = 1 ; $i <= 25 ; $i++)
{
			$data2['type']					=	'income';
			$data2['amount']				=	rand(10,1000);
			$data2['title']					=	'random title' . rand(0,50);
			$data2['description']			=	'test';
			$data2['payment_method']		=	'paypal';
			$data2['invoice_number']		=	rand(1000 , 10000);
			$data2['project_id']			=	rand(1,10);
			$data2['timestamp']				=	strtotime($i . " October, 2014");
			
			
			//$this->db->insert('payment' , $data2);
			//echo strtotime($i . " October, 2014");
}?>
	
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
                    "lead": "<?php echo 'Week ' . date('W', $row['date_added']); ?>",
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

<script>
var chart = AmCharts.makeChart("chartdiv",{
	"type"			: "pie",
	"titleField"	: "project",
	"valueField"	: "amount",
	"radius"		: "30",
	"innerRadius"	: "35%",
	"angle"			: "15",
	"depth3D"		: 10,
	"pathToImages"	: "<?php echo base_url();?>assets/js/amcharts/images/",
	"amExport": {
					"top": 0,
                    "right": 0,
                    "buttonColor": '#EFEFEF',
                    "buttonRollOverColor":'#DDDDDD',
					"imageFileName"	: "Project Report",
                    "exportPNG":true,
                    "exportJPG":true,
                    "exportPDF":true,
                    "exportSVG":true
	},
	"dataProvider"	: [
		<?php
		$this->db->select_sum('budget');
		$this->db->where( 'progress_status <', 100 );
		$budget_total = $this->db->get('project')->result()[0]->budget;

		$this->db->where( 'progress_status <', 100 );
		$query_budget = $this->db->get('project')->result_array();

		foreach ($query_budget as $row):
			$budget_percentage = ( $row['budget'] / $budget_total ) * 100;
		?>
		{
			"project": "<?php echo substr($this->db->get_where('project',array('project_id' => $row['project_id']))->row()->title , 0,20);?>",
			"amount": <?php echo $budget_percentage; ?>
		},
		<?php endforeach;?>
	]
});
</script>
<div class="row">
	<!-- BAR DIAGRAM STARTS-->
   	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title">
					<i class="entypo-chart-bar"></i>
					<?php echo get_phrase('Lead Bar');?> (<?php echo date("d F, Y" , $timestamp_start) . " - " . date("d F, Y" , $timestamp_end);?>)
				</div>
			</div>
			<div class="panel-body">
				<div id="bar_chartdiv" style="width: 100%; height: 350px;"></div>
			</div>
		</div>
	</div>
	<!-- BAR DIAGRAM FINISHES-->
	<!-- AM CHART STARTS-->
   	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title">
					<i class="entypo-chart-pie"></i>
					<?php echo get_phrase('project_percentage');?> (<?php echo date("d F, Y" , $timestamp_start) . " - " . date("d F, Y" , $timestamp_end);?>)
				</div>
			</div>
			<div class="panel-body">
				<div id="chartdiv" style="width:100%; height:350px;"></div>
			</div>
		</div>
	</div>
	<!-- AM CHART FINISHES-->
</div>
<center>

<h4><?php echo get_phrase('summary_report');?> (<?php echo date("d F, Y" , $timestamp_start) . " - " . date("d F, Y" , $timestamp_end);?>)</h4>
</center>
<table class="table table-bordered datatable" id="table_export">
	<thead>
		<tr>
        	<th></th>
			<th><div><?php echo get_phrase('date');?></div></th>
			<th><div><?php echo get_phrase('project');?></div></th>
			<th><div><?php echo get_phrase('amount');?></div></th>
			<th><div><?php echo get_phrase('payment_method');?></div></th>
		</tr>
	</thead>
	<tbody>
		
		<?php 
		$grand_total	=	0;
		$this->db->order_by('timestamp' , 'desc');
		
		$this->db->where('timestamp >=' , $timestamp_start);
		$this->db->where('timestamp <=' , $timestamp_end);
		$payments	=	$this->db->get('payment')->result_array();
		foreach ($payments as $row):
			$grand_total	+=	$row['amount'];
			?>
			<tr>
            	<td></td>
				<td><?php echo date("d F, Y" , $row['timestamp']);?></td>
				<td><?php echo $this->db->get_where('project',array('project_id' => $row['project_id']))->row()->title;?></td>
				<td><?php echo $row['amount'];?></td>
				<td><?php echo $row['payment_method'];?></td>
			</tr>

		<?php endforeach;?>
	</tbody>
</table>


<div class="row">
	<div class="col-sm-5 col-md-offset-4">
		
		<div class="tile-stats tile-white tile-white-primary">
			<div class="icon"><i class="entypo-suitcase"></i></div>
			<div class="num" data-start="0" data-end="<?php echo $grand_total;?>" data-prefix="<?php echo $currency_symbol;?>" data-postfix="" data-duration="1500" data-delay="0">
				0
			</div>
			
			<h3><?php echo get_phrase('total_income');?></h3>
			<p>(<?php echo date("d F, Y" , $timestamp_start) . " - " . date("d F, Y" , $timestamp_end);?>)</p>
		</div>
		
	</div>
</div>

<script type="text/javascript">


	
	jQuery(document).ready(function($)
	{
		//convert all checkboxes before converting datatable
		replaceCheckboxes();
		var datatable = $("#table_export").dataTable({
			"sPaginationType": "bootstrap",
			"sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
			
			"aoColumns": [
				{ "bSortable": false}, 
				{ "bSortable": true}, 	
				{ "bVisible": true},		
				{ "bVisible": true},		
				{ "bVisible": true},		
			],
			
		});
		// Highlighted rows
		$("#table_export tbody input[type=checkbox]").each(function(i, el)
		{
			var $this = $(el),
				$p = $this.closest('tr');
			
			$(el).on('change', function()
			{
				var is_checked = $this.is(':checked');
				
				$p[is_checked ? 'addClass' : 'removeClass']('highlight');
			});
		});
		
		//customize the select menu 
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
		
	});
	


		
</script>



        
