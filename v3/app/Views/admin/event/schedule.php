<?php if ($titulo != '') { ?>
	<div class="col-lg-3 col-1" style="font-size: 0.8rem;">
	</div>
	<div class="col-lg-9 col-11 mb-1" style="font-size: 0.8rem; border-left: 5px solid #000; padding: 5px;">
		<b><?php echo $titulo; ?></b>
		<br>
		<i>
			<?php
			if ($w_autores == '') {
				echo $nome_autor1 . ' ' . $sobrenome_autor1;
			} else {
				echo $w_autores;
			}
			?>
		</i>
	</div>
<?php } ?>
