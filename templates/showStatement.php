<?php if(!isset($this)) die();?> 
<class="container"> 
	<div class="row text-center ">
		<div class="col-md-4 col-md-offset-4 bg6">
		<h3> Usunięcie nie powiodło się!</h3>
	        <div class="statement">
            <?php
                if($statement):
                    echo $statement;
			     endif ?>
         
			</div>								
		</div>
		<div class="col-md-4"></div>
	</div>
</div>