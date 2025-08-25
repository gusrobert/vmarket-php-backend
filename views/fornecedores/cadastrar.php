<?php 

require_once __DIR__ . '/../../config.php';
global $conn;
if (!$conn) {
	die('Erro: conexão com o banco de dados não foi estabelecida.');
}

require_once __DIR__ . '/../../controllers/FornecedoresController.php';
require_once __DIR__ . '/../../DTO/FornecedorCreateDTO.php';

$controller = new FornecedoresController($conn);

$sucesso = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$telefone = $_POST['telefone'];

	$resultado = $controller->cadastrarFornecedor(new FornecedorCreateDTO(
		$nome,
		$email,
		$telefone
	));

	if ($resultado) {
		$sucesso = true;
	}
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cadastrar Fornecedor</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

	<?php if ($sucesso): ?>
		<script>
			Swal.fire({
				icon: 'success',
				title: 'Fornecedor cadastrado com sucesso!',
				showConfirmButton: false,
				timer: 1500
			}).then(() => {
				window.location.href = 'listar.php';
			});
		</script>
	<?php endif; ?>

	<?php if (!$sucesso && $_SERVER['REQUEST_METHOD'] === 'POST'): ?>
		<script>
			Swal.fire({
				icon: 'error',
				title: 'Erro ao cadastrar fornecedor.',
				showConfirmButton: false,
				timer: 1500
			});
		</script>
	<?php endif; ?>

	<div class="container py-5">
		<h1 class="text-center mb-4">Cadastrar Fornecedor</h1>
		
		<a href="listar.php" class="btn btn-secondary mb-3">Voltar</a>

		<form action="cadastrar.php" method="POST">
			<div class="mb-3">
				<label for="nome" class="form-label">Nome <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="nome" name="nome" required>
			</div>
			<div class="mb-3">
				<label for="email" class="form-label">E-mail <span class="text-danger">*</span></label>
				<input type="email" class="form-control" id="email" name="email" required>
			</div>
			<div class="mb-3">
				<label for="telefone" class="form-label">Telefone <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="telefone" name="telefone" required>
			</div>
			<button type="submit" class="btn btn-primary">Cadastrar</button>
		</form>
	</div>

</body>
</html>
