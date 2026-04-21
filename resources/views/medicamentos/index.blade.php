<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ControlM - Inventario</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    :root {
      --bg-page:       #F5F4F0;
      --bg-card:       #FFFFFF;
      --bg-surface:    #F0EEE9;
      --bg-hover:      #ECEAE4;
      --text-primary:  #1A1A18;
      --text-secondary:#6B6A65;
      --text-muted:    #9B9A95;
      --border:        rgba(0,0,0,0.08);
      --border-strong: rgba(0,0,0,0.14);
      --green-bg:      #EAF3DE;
      --green-text:    #3B6D11;
      --green-dot:     #639922;
      --amber-bg:      #FAEEDA;
      --amber-text:    #854F0B;
      --amber-dot:     #EF9F27;
      --red-bg:        #FCEBEB;
      --red-text:      #A32D2D;
      --red-dot:       #E24B4A;
      --blue-accent:   #185FA5;
      --radius-sm:     6px;
      --radius-md:     10px;
      --radius-lg:     14px;
      --shadow-card:   0 1px 3px rgba(0,0,0,0.07), 0 4px 16px rgba(0,0,0,0.05);
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--bg-page);
      color: var(--text-primary);
      min-height: 100vh;
      padding: 2rem 1.5rem;
    }

    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 2rem;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .page-title {
      font-size: 22px;
      font-weight: 600;
      color: var(--text-primary);
      letter-spacing: -0.4px;
    }

    .page-subtitle {
      font-size: 14px;
      color: var(--text-secondary);
      margin-top: 3px;
    }

    .btn-primary {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      padding: 9px 18px;
      background: var(--text-primary);
      color: #fff;
      border: none;
      border-radius: var(--radius-md);
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      font-weight: 500;
      text-decoration: none;
      cursor: pointer;
      transition: opacity 0.15s;
    }

    .btn-primary:hover { opacity: 0.85; }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
      gap: 12px;
      margin-bottom: 1.5rem;
    }

    .stat-card {
      background: var(--bg-card);
      border: 0.5px solid var(--border);
      border-radius: var(--radius-lg);
      padding: 1rem 1.2rem;
      box-shadow: var(--shadow-card);
    }

    .stat-label {
      font-size: 11px;
      font-weight: 500;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      color: var(--text-muted);
      margin-bottom: 6px;
    }

    .stat-value {
      font-size: 28px;
      font-weight: 600;
      letter-spacing: -1px;
      line-height: 1;
    }

    .stat-value.total  { color: var(--text-primary); }
    .stat-value.ok     { color: var(--green-text); }
    .stat-value.warn   { color: var(--amber-text); }
    .stat-value.danger { color: var(--red-text); }

    .toolbar {
      display: flex;
      gap: 10px;
      margin-bottom: 1rem;
      flex-wrap: wrap;
      align-items: center;
    }

    .search-wrap {
      position: relative;
      flex: 1;
      min-width: 200px;
    }

    .search-wrap svg {
      position: absolute;
      left: 11px;
      top: 50%;
      transform: translateY(-50%);
      pointer-events: none;
      color: var(--text-muted);
    }

    .toolbar input[type="text"], .toolbar select {
      padding: 9px 12px;
      background: var(--bg-card);
      border: 0.5px solid var(--border-strong);
      border-radius: var(--radius-md);
      font-family: 'DM Sans', sans-serif;
      font-size: 13.5px;
      color: var(--text-primary);
      outline: none;
    }

    .toolbar input[type="text"] { padding-left: 34px; width: 100%; }

    .btn-export {
      padding: 9px 14px;
      background: var(--bg-card);
      border: 0.5px solid var(--border-strong);
      border-radius: var(--radius-md);
      font-size: 13.5px;
      color: var(--text-secondary);
      text-decoration: none;
      transition: background 0.15s;
    }

    .btn-export:hover { background: var(--bg-hover); }

    .table-card {
      background: var(--bg-card);
      border: 0.5px solid var(--border);
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-card);
      overflow: hidden;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13.5px;
    }

    thead {
      background: var(--bg-surface);
      border-bottom: 0.5px solid var(--border-strong);
    }

    th {
      padding: 11px 16px;
      text-align: left;
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      color: var(--text-muted);
    }

    td {
      padding: 11px 16px;
      border-bottom: 0.5px solid var(--border);
      vertical-align: middle;
    }

    .col-id { font-family: 'DM Mono', monospace; color: var(--text-muted); }
    .med-name { font-weight: 500; color: var(--text-primary); }
    .cat-pill {
      padding: 3px 9px;
      background: var(--bg-surface);
      border-radius: var(--radius-sm);
      font-size: 11.5px;
    }

    .qty.low { color: var(--red-text); font-weight: 500; }
    .qty.zero { color: var(--text-muted); }

    /* Estado Badge */
    .badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 4px 10px;
      border-radius: 99px;
      font-size: 11.5px;
      font-weight: 500;
    }

    .badge-dot { width: 6px; height: 6px; border-radius: 50%; }
    .badge.ok { background: var(--green-bg); color: var(--green-text); }
    .badge.ok .badge-dot { background: var(--green-dot); }
    .badge.warn { background: var(--amber-bg); color: var(--amber-text); }
    .badge.warn .badge-dot { background: var(--amber-dot); }
    .badge.danger { background: var(--red-bg); color: var(--red-text); }
    .badge.danger .badge-dot { background: var(--red-dot); }

    .accion-text {
      font-size: 12px;
      color: var(--text-secondary);
      max-width: 200px;
      display: block;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .empty-row td { text-align: center; padding: 3.5rem 1rem; color: var(--text-muted); }
    .table-footer { padding: 10px 16px; background: var(--bg-surface); font-size: 12px; color: var(--text-muted); }
  </style>
</head>
<body>

  <div class="page-header">
    <div>
      <h1 class="page-title">Inventario de Medicamentos</h1>
      <p class="page-subtitle">Panel de control para la gestión del botiquín familiar</p>
    </div>
    <a href="#" class="btn-primary">
      <span class="icon">＋</span> Nuevo medicamento
    </a>
  </div>

  <div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Total registros</div>
        <div class="stat-value total">{{ $stats['total'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Vigentes</div>
        <div class="stat-value ok">{{ $stats['vigentes'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Por caducar</div>
        <div class="stat-value warn">{{ $stats['proximos'] }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Caducados</div>
        <div class="stat-value danger">{{ $stats['caducados'] }}</div>
    </div>
  </div>

  <form action="{{ route('medicamentos.index') }}" method="GET" class="toolbar">
    <div class="search-wrap">
      <svg width="14" height="14" viewBox="0 0 16 16" fill="none">
        <circle cx="6.5" cy="6.5" r="4.5" stroke="currentColor" stroke-width="1.5"/>
        <path d="M10 10L14 14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
      </svg>
      <input type="text" name="buscar" placeholder="Buscar por nombre..." value="{{ request('buscar') }}" onchange="this.form.submit()">
    </div>

    <select name="estado" onchange="this.form.submit()">
      <option value="">Todos los estados</option>
      <option value="Vigente" {{ request('estado') == 'Vigente' ? 'selected' : '' }}>Vigente</option>
      <option value="Próximo a caducar" {{ request('estado') == 'Próximo a caducar' ? 'selected' : '' }}>Próximo a caducar</option>
      <option value="Caducado" {{ request('estado') == 'Caducado' ? 'selected' : '' }}>Caducado</option>
    </select>

    <select name="categoria" onchange="this.form.submit()">
      <option value="">Todas las categorías</option>
      @foreach($categorias as $cat)
        <option value="{{ $cat->id_categoria }}" {{ request('categoria') == $cat->id_categoria ? 'selected' : '' }}>
            {{ $cat->nombre_categoria }}
        </option>
      @endforeach
    </select>

    <a href="{{ route('medicamentos.index') }}" class="btn-export">Limpiar</a>
  </form>

  <div class="table-card">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Categoría</th>
          <th>Cantidad</th>
          <th>Caducidad</th>
          <th>Estado</th>
          <th>Acción recomendada</th>
        </tr>
      </thead>
      <tbody>
        @forelse($medicamentos as $m)
          <tr>
            <td class="col-id">#{{ str_pad($m->id, 3, '0', STR_PAD_LEFT) }}</td>
            <td><span class="med-name">{{ $m->nombre }}</span></td>
            <td><span class="cat-pill">{{ $m->categoria->nombre_categoria ?? 'Sin categoría' }}</span></td>
            <td>
                <span class="qty {{ $m->cantidad == 0 ? 'zero' : ($m->cantidad <= 10 ? 'low' : '') }}">
                    {{ $m->cantidad }}
                </span>
            </td>
            <td class="date-cell">{{ $m->fecha_caducidad->format('d/m/Y') }}</td>
            <td>
              @php
                $clase = [
                    'Vigente' => 'ok', 
                    'Próximo a caducar' => 'warn', 
                    'Caducado' => 'danger'
                ][$m->estado] ?? 'ok';
              @endphp
              <span class="badge {{ $clase }}">
                <span class="badge-dot"></span>{{ $m->estado }}
              </span>
            </td>
            <td>
                <span class="accion-text" title="{{ $m->accion_recomendada }}">
                    {{ $m->accion_recomendada }}
                </span>
            </td>
          </tr>
        @empty
          <tr class="empty-row">
            <td colspan="7">
              <span style="font-size: 24px; display: block; margin-bottom: 10px;">📦</span>
              No se encontraron medicamentos registrados.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div class="table-footer">
      Mostrando {{ $medicamentos->count() }} de {{ $stats['total'] }} registros encontrados
    </div>
  </div>

</body>
</html>