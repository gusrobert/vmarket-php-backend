<?php 

require_once __DIR__ . '/../../config.php';
global $conn;
if (!$conn) {
	die('Erro: conexão com o banco de dados não foi estabelecida.');
}

require_once __DIR__ . '/../../controllers/ProdutosController.php';
require_once __DIR__ . '/../../controllers/FornecedoresController.php';
require_once __DIR__ . '/../../DTO/ProdutoCreateDTO.php';

$fornecedoresController = new FornecedoresController($conn);
$fornecedores = $fornecedoresController->listarFornecedores();

$controller = new ProdutosController($conn);

$sucesso = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$nome = $_POST['nome'];
	$descricao = $_POST['descricao'];
	$quantidade = $_POST['quantidade'];
	$preco = $_POST['preco'];
	$fornecedores = $_POST['fornecedores_id'];

	$resultado = $controller->cadastrarProduto(new ProdutoCreateDTO(
		$nome,
		$descricao,
		$quantidade,
		$preco,
		$fornecedores
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
	<title>Cadastrar Produto</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
</head>
<body>

	<?php if ($sucesso): ?>
		<script>
			Swal.fire({
				icon: 'success',
				title: 'Produto cadastrado com sucesso!',
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
				title: 'Erro ao cadastrar produto.',
				showConfirmButton: false,
				timer: 1500
			});
		</script>
	<?php endif; ?>

	<div class="container py-5">
		<h1 class="text-center mb-4">Cadastrar Produto</h1>

		<a href="listar.php" class="btn btn-secondary mb-3">Voltar</a>

		<form action="" method="POST">
			<div class="mb-3">
				<label for="nome" class="form-label">Nome <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="nome" name="nome" required>
			</div>
			<div class="mb-3">
				<label for="descricao" class="form-label">Descrição</label>
				<textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
			</div>

			<div class="mb-3">
				<label for="quantidade" class="form-label">Quantidade <span class="text-danger">*</span></label>
				<input type="number" class="form-control" id="quantidade" name="quantidade" required>
			</div>

			<div class="mb-3">
				<label for="preco" class="form-label">Preço <span class="text-danger">*</span></label>
				<input type="number" class="form-control" id="preco" name="preco" step="0.01" required>
			</div>
			<div class="mb-3">
				<label for="fornecedores" class="form-label">Fornecedores <span class="text-danger">*</span></label>
				<select class="form-select" id="fornecedores" name="fornecedores_id[]" multiple required>
					<?php foreach ($fornecedores as $fornecedor): ?>
						<option value="<?= htmlspecialchars($fornecedor['id']) ?>"><?= htmlspecialchars($fornecedor['nome']) ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<button type="submit" class="btn btn-primary">Cadastrar</button>
		</form>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const fornecedoresSelect = document.getElementById('fornecedores');
			if (fornecedoresSelect) {
				new Choices(fornecedoresSelect, {
					removeItemButton: true,
					searchResultLimit: 10,
					placeholder: true,
					placeholderValue: 'Selecione um ou mais fornecedores'
				});
			}
		});
	</script>
</body>
</html>