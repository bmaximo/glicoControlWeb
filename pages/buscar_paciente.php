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
		<div class="container-fluid" >
			<?php
				include('menu.php');
			?>
			<div class="row-white">
			<div class="container">
			<div class="row row-space">
				<div class="col-md-3">
					<br />
					<a class="btn btn-primary btn-xs" href="minha_area.php" role="button">
						<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Voltar a minha área
					</a>
				</div>
				<div class="col-md-12">
					<h1>Buscar Pacientes</h1>
					<br /><br />
				</div>
				<div class="col-md-12">
					<h3 class="text-primary">Pesquise pelo e-mail ou nome do paciente</h3><br />
					<form name="busca" method="post" action="?go=pesquisar" class="form-inline">
            <div class="form-group">
						<label>E-mail: </label>
            <br />
            <input type="email" name="email" id="email" class="form-control" />
						</div>
						<div class="form-group">
						<label>Nome: </label>
            <br />
            <input type="text" name="nome" id="nome" class="form-control" />
						</div>
						<br /><br />
						<button type="submit" name="Pesquisar" id="Pesquisar" value="Pesquisar" class="btn btn-primary">Pesquisar</button>
          </form>
					<br /><br />
          <?php
						if(@$_GET['go'] == 'pesquisar'){
							$sql = "";
							$e = $_POST["email"];
							$n = $_POST["nome"];
							if(!empty($e) || $e != ""){
								$sql = "select * from paciente where email = '$e'";
							}elseif(!empty($n) || $n != ""){
								$nomebusca = "%".$n."%";
								$sql = "select * from paciente where nome like '$nomebusca'";
							}
							require 'connection_mysql.php';
							$r = mysqli_query ($mysqli, $sql) or die (mysqli_error($mysqli));
							while ($dados = mysqli_fetch_array($r)){
								if(!empty($dados)){
									$nasc = date_create($dados["data_nascimento"]);
									echo "Nome do paciente: ".$dados['nome']."<br />";
									echo "Data de nascimento: ".date_format($nasc, 'd/m/Y')."<br />";
									echo "Sexo: ".$dados['sexo']."<br />";
									echo "Diabetes ".$dados['tipo_diabetes']."<br />";
									echo "E-mail: ".$dados['email']."<br />";
									echo "<a href='adiciona_paciente.php?id_paciente= $dados[id_paciente]' class='btn btn-primary btn-lg' role='button'>Adicionar</a>";
									echo "<br /><br /><br />";
								}
								else{
									echo "Nenhum paciente encontrado.";
								}
							}
						}
          ?>
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
