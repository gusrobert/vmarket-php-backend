<?php
require_once __DIR__ . '/../../controllers/produtosController.php';

require_once __DIR__ . '/../../controllers/FornecedoresController.php';
$controller = new ProdutosController();
$fornecedoresController = new FornecedoresController();
$fornecedores = $fornecedoresController->listarFornecedores();

$nomeBusca = $_GET['busca_nome'] ?? '';
$fornecedorBusca = $_GET['busca_fornecedor'] ?? '';

$fornecedorBusca = $fornecedorBusca !== '' ? (int)$fornecedorBusca : 0;
$produtos = $controller->buscarProdutoPorNomeOuFornecedor($nomeBusca, $fornecedorBusca);

$deleteSuccess = false;
$deleteAllSuccess = false;
if (isset($_GET['delete'])) {
	$id = (int)$_GET['delete'];
	if ($controller->deletarProduto($id)) {
		$deleteSuccess = true;
	}
}

// Exclusão múltipla via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['excluir_multiplos']) && isset($_POST['produtos']) && is_array($_POST['produtos'])) {
		$ids = array_map('intval', $_POST['produtos']);
		$ok = true;
		foreach ($ids as $id) {
			if (!$controller->deletarProduto($id)) {
				$ok = false;
			}
		}
		if ($ok) {
			$deleteSuccess = true;
		}
	}
	if (isset($_POST['excluir_todos'])) {
		$ok = true;
		foreach ($produtos as $f) {
			if (!$controller->deletarProduto($f['id'])) {
				$ok = false;
			}
		}
		if ($ok) {
			$deleteAllSuccess = true;
		}
	}
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Listar Produtos</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>


	<div class="container py-5">
		<h1 class="text-center mb-4">Lista de Produtos</h1>
		<div class="mb-4">
			<div class="row g-2 align-items-end">
				<div class="col-auto">
					<a href="/" class="btn btn-secondary">Voltar</a>
				</div>
				<div class="col">
					<form class="d-flex gap-2" method="GET" action="">
						<input type="text" class="form-control" name="busca_nome" placeholder="Buscar por nome" value="<?= htmlspecialchars($nomeBusca) ?>">
						<select class="form-select" name="busca_fornecedor">
							<option value="">Todos os fornecedores</option>
							<?php foreach ($fornecedores as $fornecedor): ?>
								<option value="<?= htmlspecialchars($fornecedor['id']) ?>" <?= $fornecedorBusca == $fornecedor['id'] ? 'selected' : '' ?>><?= htmlspecialchars($fornecedor['nome']) ?></option>
							<?php endforeach; ?>
						</select>
						<button type="submit" class="btn btn-outline-primary">Buscar</button>
					</form>
				</div>
				<div class="col-auto">
					<a href="cadastrar.php" class="btn btn-primary">Cadastrar Produto</a>
				</div>
			</div>
		</div>

		<form id="form-excluir-multiplos" method="POST" action="">
			<div class="mb-2 d-flex gap-2">
				<button 
					type="button" 
					class="btn btn-danger btn-sm"
					id="btn-excluir-selecionados" 
				>Excluir Selecionados</button>
				<button 
					type="submit" 
					class="btn btn-danger btn-sm"
					id="btn-excluir-todos"
				>Excluir Todos</button>
			</div>

			<table class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th><input type="checkbox" id="check-todos"></th>
						<th>ID</th>
						<th>Nome</th>
						<th>Descrição</th>
						<th>Quantidade</th>
						<th>Preço</th>
						<th>Fornecedores</th>
						<th>Ações</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($produtos as $produto): ?>
						<tr>
							<td class="text-center">
								<input 
									type="checkbox" 
									class="check-produto" 
									name="produtos[]" 
									value="<?= $produto['id'] ?>">
							</td>
							<td><?= htmlspecialchars($produto['id']) ?></td>
							<td><?= htmlspecialchars($produto['nome']) ?></td>
							<td><?= htmlspecialchars($produto['descricao']) ?></td>
							<td><?= htmlspecialchars($produto['quantidade']) ?></td>
							<td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
							<td><?= htmlspecialchars($produto['fornecedores_nomes'] ?? '') ?></td>
							<td class="text-center">
								<button 
									type="button"
									onclick="window.location.href='editar.php?id=<?= $produto['id'] ?>'" 
									class="btn btn-sm btn-warning" data-id="<?= $produto['id'] ?>"
								>Editar</button>
								<button class="btn btn-sm btn-danger btn-excluir" data-id="<?= $produto['id'] ?>">Excluir</button>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</form>
	</div>


	<?php if ($deleteSuccess): ?>
		<script>
			Swal.fire({
				icon: 'success',
				title: 'Produto deletado com sucesso!',
				showConfirmButton: false,
				timer: 1500
			}).then(() => {
				window.location.href = 'listar.php';
			});
		</script>
	<?php endif; ?>

	<?php if ($deleteAllSuccess): ?>
		<script>
			Swal.fire({
				icon: 'success',
				title: 'Todos os produtos deletados com sucesso!',
				showConfirmButton: false,
				timer: 1500
			}).then(() => {
				window.location.href = 'listar.php';
			});
		</script>
	<?php endif; ?>

	<script>
		// Seleção de todos
		document.getElementById('check-todos').addEventListener('change', function() {
			document.querySelectorAll('.check-produto').forEach(cb => {
				cb.checked = this.checked;
			});
		});

		// Excluir individual
		document.querySelectorAll('.btn-excluir').forEach(btn => {
			btn.addEventListener('click', function(e) {
				e.preventDefault();
				const id = this.getAttribute('data-id');
				Swal.fire({
					title: 'Tem certeza que deseja excluir este produto?',
					text: 'Esta ação não poderá ser desfeita!',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#d33',
					cancelButtonColor: '#3085d6',
					confirmButtonText: 'Sim, deletar!',
					cancelButtonText: 'Cancelar'
				}).then((result) => {
					if (result.isConfirmed) {
						window.location.href = 'listar.php?delete=' + id;
					}
				});
			});
		});

		// Excluir selecionados
		document.getElementById('btn-excluir-selecionados').addEventListener('click', function(e) {
			e.preventDefault();
			const selecionados = Array.from(document.querySelectorAll('.check-produto:checked')).map(cb => cb.value);
			if (selecionados.length === 0) {
				Swal.fire('Selecione pelo menos um produto para excluir.');
				return;
			}
			Swal.fire({
				title: `Excluir ${selecionados.length} produto(s)?`,
				text: 'Esta ação não poderá ser desfeita!',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#d33',
				cancelButtonColor: '#3085d6',
				confirmButtonText: 'Sim, deletar!',
				cancelButtonText: 'Cancelar'
			}).then((result) => {
				if (result.isConfirmed) {
					// Envia via POST para exclusão múltipla
					const form = document.getElementById('form-excluir-multiplos');
					const input = document.createElement('input');
					input.type = 'hidden';
					input.name = 'excluir_multiplos';
					input.value = '1';
					form.appendChild(input);
					form.submit();
				}
			});
		});

		// Excluir todos
		document.getElementById('btn-excluir-todos').addEventListener('click', function(e) {
			e.preventDefault();
			Swal.fire({
				title: 'Tem certeza que deseja excluir TODOS os produtos?',
				text: 'Esta ação não poderá ser desfeita!',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#d33',
				cancelButtonColor: '#3085d6',
				confirmButtonText: 'Sim, deletar todos!',
				cancelButtonText: 'Cancelar'
			}).then((result) => {
				if (result.isConfirmed) {
					// Envia via POST para exclusão de todos
					const form = document.getElementById('form-excluir-multiplos');
					const input = document.createElement('input');
					input.type = 'hidden';
					input.name = 'excluir_todos';
					input.value = '1';
					form.appendChild(input);
					form.submit();
				}
			});
		});
	</script>

</body>
</html>