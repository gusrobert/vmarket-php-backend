<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Produtos</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container py-5">
        <h1 class="text-center mb-4">Sistema de Gerenciamento de produtos</h1>
        <p class="text-center text-muted mb-5">Escolha uma opção abaixo para começar:</p>

        <div class="row justify-content-center g-4">
            <!-- Card Produtos -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Produtos</h5>
                        <p class="card-text text-muted">Gerencie os produtos cadastrados no sistema.</p>
                        <a href="views/produtos/listar.php" class="btn btn-primary">Ver Produtos</a>
                    </div>
                </div>
            </div>

            <!-- Card Fornecedores -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Fornecedores</h5>
                        <p class="card-text text-muted">Gerencie os fornecedores disponíveis.</p>
                        <a href="views/fornecedores/listar.php" class="btn btn-success">Ver Fornecedores</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
