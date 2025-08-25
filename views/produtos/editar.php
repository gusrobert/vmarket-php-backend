<?php 

require_once __DIR__ . '/../../config.php';
global $conn;
if (!$conn) {
	die('Erro: conexão com o banco de dados não foi estabelecida.');
}

require_once __DIR__ . '/../../controllers/ProdutosController.php';
require_once __DIR__ . '/../../controllers/FornecedoresController.php';
require_once __DIR__ . '/../../dto/ProdutoUpdateDTO.php';

$id = $_GET['id'] ?? null;

$produto = null;
if (!empty($id) && is_numeric($id) && $id > 0) {
	$controller = new ProdutosController($conn);
	$produto = $controller->buscarProdutoPorId($id);
}

$fornecedoresController = new FornecedoresController($conn);
$fornecedores = $fornecedoresController->listarFornecedores();

$sucesso = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$id = $_POST['id'];
	$nome = $_POST['nome'];
	$descricao = $_POST['descricao'];
	$quantidade = $_POST['quantidade'];
	$preco = $_POST['preco'];
	$fornecedores = $_POST['fornecedores_id'];

	if ($controller->atualizarProduto(new ProdutoUpdateDTO(
		$id,
		$nome,
		$descricao,
		$quantidade,
		$preco,
		$fornecedores
	))) {
		$sucesso = true;
	}
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Editar Produto</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
</head>
<body>
	<?php if ($sucesso): ?>
		<script>
			Swal.fire({
				icon: 'success',
				title: 'Produto atualizado com sucesso!',
				showConfirmButton: false,
				timer: 1500
			}).then(() => {
				window.location.href = 'listar.php';
			});
		</script>
	<?php endif; ?>

	<div class="container py-5">
		<h1 class="text-center mb-4">Editar Produto</h1>

		<a href="listar.php" class="btn btn-secondary mb-3">Voltar</a>

		<?php if ($produto): ?>

			<form action="" method="POST">
				<input type="hidden" name="id" value="<?= htmlspecialchars($produto['id']) ?>">
				<div class="mb-3">
					<label for="nome" class="form-label">Nome <span class="text-danger">*</span></label>
					<input value="<?= htmlspecialchars($produto['nome']) ?>" type="text" class="form-control" id="nome" name="nome" required>
				</div>
				<div class="mb-3">
					<label for="descricao" class="form-label">Descrição</label>
					<textarea class="form-control" id="descricao" name="descricao" rows="3"><?= htmlspecialchars($produto['descricao']) ?></textarea>
				</div>
				<div class="mb-3">
					<label for="quantidade" class="form-label">Quantidade <span class="text-danger">*</span></label>
					<input value="<?= htmlspecialchars($produto['quantidade']) ?>" type="number" class="form-control" id="quantidade" name="quantidade" required>
				</div>
				<div class="mb-3">
					<label for="preco" class="form-label">Preço <span class="text-danger">*</span></label>
					<input value="<?= htmlspecialchars($produto['preco']) ?>" type="number" class="form-control" id="preco" name="preco" step="0.01" required>
				</div>
				<div class="mb-3">
					<label for="fornecedores" class="form-label">Fornecedores <span class="text-danger">*</span></label>
					<select class="form-select" id="fornecedores" name="fornecedores_id[]" multiple required>
						<?php foreach ($fornecedores as $fornecedor): ?>
							<option value="<?= htmlspecialchars($fornecedor['id']) ?>" <?= in_array($fornecedor['id'], $produto['fornecedores_id']) ? 'selected' : '' ?>><?= htmlspecialchars($fornecedor['nome']) ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<button type="submit" class="btn btn-primary">Salvar</button>
			</form>
		<?php else: ?>
			<script>
				Swal.fire({
					icon: 'error',
					title: 'Erro!',
					text: 'Produto não encontrado.',
					showConfirmButton: false,
					timer: 1500
				}).then(() => {
					window.location.href = 'listar.php';
				});
			</script>
		<?php endif; ?>
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