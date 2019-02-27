<?php if(!isset($this)) die();?> 
<div class="container"> 
	<div class="row text-center ">
		<div class="col-md-8 col-md-offset-2 bg6">
		Czy na pewno chcesz usunąć 
			<?php  if($wtd == 'expense'):?> 
			wydatek? <br /> <br /> </br>
			<?php endif;?>
			<?php if($wtd == 'income'):?>
			przychód? <br /> <br /> </br>
			<?php endif;?>
			
		<?php if($wtd == 'expense'):?>
		<?php echo $strOneEnteryExpense ?>
		<?php endif;?>	
		<?php if($wtd == 'income'):?>
		<?php echo $strOneEnteryIncome ?>
        <?php endif;?>	
		</div>
		<div class="col-md-2"></div>
	</div>
	
	<div class="row text-center">
	<div class="col-md-8 col-md-offset-2 bg6">
		<div class="col-sm-4 col-sm-offset-2">
			<a href="index.php?action=deleteEntery&amp;wtd=<?=$wtd?>&amp;id=<?=$id ?>" class="btnSetting" role="button"> Usuń </a>
		</div>
		<div class="col-sm-4">
			<a href="index.php?action=viewBalance" class="btnSetting" role="button"> Anuluj </a>
		</div>
	</div>
	</div>	
	
	
	
	
	
</div>