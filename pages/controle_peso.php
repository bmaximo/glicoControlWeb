<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GlicoControl</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
  </head>
  <body>
    <div class="container-fluid">
      <?php
        include('menu.php');
      ?>
      <div class="row-white">
				<div class="container">
        <div class="row row-space">
					<div class="col-md-3">
						<br />
						<a class="btn btn-primary btn-xs" href="area_paciente.php" role="button">
							<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Voltar ao paciente
						</a>
					</div>
          <div class="col-md-12">
            <h1>Controle de Peso</h1>
					</div>
          <div class="col-md-12">
						<?php
							$p = $_SESSION['id_paciente'];
							$sql = "select nome from paciente where id_paciente = '$p'";
							require 'connection_mysql.php';
							$r = mysqli_query ($mysqli, $sql) or die (mysqli_error($mysqli));
							$dados = mysqli_fetch_array($r);
							echo "<h4 class='text-center text-primary'><p class='text-center'>Paciente: ".$dados['nome']."</p></h4>";
						?>
						<br /><br />
					</div>
        </div>
        <div class="row row-space">
					<div class ="col-md-12">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Data</th>
									<th>Peso</th>
									<th>Altura</th>
									<th>IMC</th>
									<th>Descrição</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$descricao="";
									$id = $_SESSION['id_paciente'];
									$sql = "select * from imc where fk_paciente = '$id' order by data_imc desc";
									require 'connection_mysql.php';
									try{
										$r = mysqli_query ($mysqli, $sql) or die (mysqli_error($mysqli));
										while ($a = mysqli_fetch_array ($r)){
											$imc = $a["peso"]/($a["altura"]^2);
											if($imc < 18.50){
												$descricao = "Baixo Peso";
											}
											elseif($imc >=18.50 && $imc <25.00){
												$descricao = "Peso Adequado";
											}
											elseif($imc >=25.00 && $imc<30.00){
												$descricao = "Sobrepeso";
											}
											elseif($imc >=30.00 && $imc <35.00){
												$descricao = "Obesidade I";
											}
											elseif($imc >=35.00 && $imc <40.00){
												$descricao = "Obesidade II";
											}
											else{
												$descricao = "Obesidade III";
											}
											$date = date_create($a["data_imc"]);
											echo "<tr>";
											echo "<td>".date_format($date, 'd/m/Y')."</td>";
											echo "<td>".$a["peso"]."</td>";
											echo "<td>".$a["altura"]."</td>";
											echo "<td>".round($imc,2)."</td>";
											echo "<td>".$descricao."</td>";
											echo "</tr>";
										}
									}catch(Exception $e){
										echo "Erro ao gerar relatório: ".  $e->getMessage();
									}
								?>
							</tbody>
						</table>
					</div>
      </div>
		</div>
    </div>
		<?php
		include('rodape.php');
		?>
		</div>
		<script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/scripts.js"></script>
  </body>
</html>