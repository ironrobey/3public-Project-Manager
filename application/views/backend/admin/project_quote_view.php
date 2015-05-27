<?php
$quote      = $this->db->get_where('quote', array('quote_id' => $param2))->result_array();
foreach ($quote as $row){
}
?>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-body">

                <b><?php echo get_phrase('title'); ?> :</b>

                <p><?php echo $row['title']; ?></p>

                <hr>

                <b><?php echo get_phrase('description'); ?> :</b>

                <p><?php echo $row['description']; ?></p>

                <hr>

                <b><?php echo get_phrase('client'); ?> :</b>

                <p>
                    <?php
                        $name   = $this->db->get_where('client' , array('client_id' => $row['user_id'] ))->row()->name;
                        echo $name; 
                    ?>
                </p>
                
                <hr>

                <b><?php echo get_phrase('date'); ?> :</b>

                <p><?php echo date("d M, Y", $row['timestamp']); ?></p>
                
                <hr>

                <b><?php echo get_phrase('amount'); ?> :</b>

                <p><?php echo $row['amount']; ?></p>

            </div>

        </div>

    </div>
</div>