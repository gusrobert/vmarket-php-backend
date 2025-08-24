<?php 

require_once __DIR__ . '/../../controllers/FornecedoresController.php';

$fornecedor = null;
if (!empty($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
	$id = (int)$_GET['id'];
	$controller = new FornecedoresController();
	$fornecedor = $controller->buscarPorId($id);
}

$sucesso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$id = (int)$_POST['id'];
	$nome = trim($_POST['nome']);
	$email = trim($_POST['email']);
	$telefone = trim($_POST['telefone']);

	$controller = new FornecedoresController();
	$sucesso = $controller->atualizarFornecedor($id, $nome, $email, $telefone);
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Editar Fornecedor</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

	<div class="container py-5">
		<h1 class="text-center mb-4">Editar Fornecedor</h1>

		<?php if ($sucesso): ?>
			<script>
				Swal.fire({
					icon: 'success',
					title: 'Sucesso!',
					text: 'Fornecedor atualizado com sucesso.',
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
					title: 'Erro!',
					text: 'Erro ao atualizar fornecedor.',
					showConfirmButton: false,
					timer: 1500
				}).then(() => {
					window.location.href = 'listar.php';
				});
			</script>
		<?php endif; ?>

		<a href="listar.php" class="btn btn-secondary mb-3">Voltar</a>

		<?php if ($fornecedor): ?>
			<form method="POST" action="">
				<input type="hidden" name="id" value="<?= $fornecedor['id'] ?>">
				<div class="mb-3">
					<label for="nome" class="form-label">Nome</label>
					<input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($fornecedor['nome']) ?>" required>
				</div>
				<div class="mb-3">
					<label for="email" class="form-label">E-mail</label>
					<input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($fornecedor['email']) ?>" required>
				</div>
				<div class="mb-3">
					<label for="telefone" class="form-label">Telefone</label>
					<input type="text" class="form-control" id="telefone" name="telefone" value="<?= htmlspecialchars($fornecedor['telefone']) ?>" required>
				</div>
				<button type="submit" class="btn btn-primary">Salvar</button>
			</form>
		<?php else: ?>
			<script>
				Swal.fire({
					icon: 'error',
					title: 'Erro!',
					text: 'Fornecedor não encontrado.',
					showConfirmButton: false,
					timer: 1500
				}).then(() => {
					window.location.href = 'listar.php';
				});
			</script>
		<?php endif; ?>
	</div>

</body>
</html>