<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ControlM - Tu Botiquín Seguro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .hero-section {
            height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
            color: white;
        }
        .card-welcome {
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }
        .btn-start {
            padding: 15px 40px;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 50px;
            transition: transform 0.3s;
        }
        .btn-start:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-3 fw-bold mb-4">ControlM</h1>
                    <p class="lead mb-5">
                        Cuida a tu familia manteniendo tu botiquín en orden. 
                        Detecta medicamentos vencidos a tiempo y evita riesgos innecesarios en casa.
                    </p>
                    <a href="{{ route('medicamentos.index') }}" class="btn btn-light btn-start text-primary shadow">
                        Comenzar a Revisar
                    </a>
                </div>

                <div class="col-lg-5 offset-lg-1 d-none d-lg-block">
                    <div class="card card-welcome shadow-lg text-dark p-4">
                        <div class="card-body">
                            <h5 class="fw-bold text-primary">¿Qué puedes hacer hoy?</h5>
                            <ul class="list-unstyled mt-3">
                                <li class="mb-3">✅ <strong>Registrar:</strong> Tus medicinas nuevas.</li>
                                <li class="mb-3">⚠️ <strong>Alertar:</strong> Ver qué está por caducar.</li>
                                <li class="mb-3">♻️ <strong>Limpiar:</strong> Saber qué desechar de forma segura.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-4 text-center text-secondary">
        <small>&copy; 2026 ControlM - Gestión de Salud en el Hogar</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>