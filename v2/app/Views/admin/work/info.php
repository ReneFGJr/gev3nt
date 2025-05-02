<!-- Início do bloco de trabalho -->
<?php
$class = "info";
$style = "";
switch ($w_status) {
	case 0:
		$class = "danger";
		break;
	case 1:
		$class = "success";
		break;
	case 2:
		$class = "warning";
		break;
	case 3:
		$class = "info";
		break;
	case 4:
		$class = "secondary";
		break;
	case 5:
		$class = "primary";
		break;
	case 9:
		$class = "secondary";
		$style = "opacity: 0.3";
		break;
	default:
		break;
}
$link = '<a href="/admin/work/' . $id_w . '" class="link">';
$linka = '</a>';
?>
<div class="container mb-3">
	<div class="row">
		<div class="alert alert-<?= $class; ?> col-1 h4 text-center"><?= $w_id; ?></div>
		<div class="col-11" style="<?= $style; ?>">
			<?= $link . nTitle($titulo) . $linka; ?>
			<div class="ms-5"><i><span>
						<?php
						if ($w_autores == '') {
							$nome = nbr_author($nome_autor1 . ' ' . $sobrenome_autor1, 7);
							echo $nome;
						} else {
							$nome = $w_autores;
							echo $nome;
						}
						?>
					</span></i>
				<!-- Decisão -->
			</div>
			<?php
			if ($w_status == 0) {
				echo '<br><span class="small" style="color: red">' . $decisao1 . ' | ' . $decisao2 . ' | ' . $decisao3 . ' | ' . $decisao4 . '</span>';
			}
			?>
		</div>
	</div>
</div>
