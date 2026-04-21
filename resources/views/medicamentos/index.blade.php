<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ControlM - Inventario</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg-surface: #f0fdf4; --bg-hover: #e6f4ea;
      --text-primary: #0f172a; --text-secondary: #475569; --text-muted: #64748b;
      --border: rgba(15,23,42,0.08); --border-strong: rgba(15,23,42,0.14);
      --green-bg: #e6f9f0; --green-text: #047857; --green-dot: #10b981;
      --amber-bg: #fff8e1; --amber-text: #b45309; --amber-dot: #f59e0b;
      --red-bg: #fee2e2;   --red-text: #b91c1c;   --red-dot: #ef4444;
      --blue-accent: #0ea5e9;
      --radius-sm: 8px; --radius-md: 12px; --radius-lg: 16px; --radius-xl: 20px;
      --shadow-card: 0 1px 2px rgba(15,23,42,0.05), 0 8px 24px rgba(15,23,42,0.06);
      --shadow-hover: 0 10px 30px rgba(15,23,42,0.10);
      --shadow-modal: 0 24px 80px rgba(15,23,42,0.22);
      --t: 180ms ease;
    }

    html { scroll-behavior: smooth; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: radial-gradient(circle at top left, rgba(16,185,129,0.08), transparent 30%),
                  linear-gradient(180deg, #f0fdf4 0%, #e6f4ea 100%);
      color: var(--text-primary);
      min-height: 100vh;
      padding: 2rem 1.5rem;
      -webkit-font-smoothing: antialiased;
    }

    /* PAGE HEADER */
    .page-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; margin-bottom: 1.75rem; flex-wrap: wrap; }
    .page-title  { font-size: 1.5rem; font-weight: 700; letter-spacing: -0.03em; line-height: 1.15; }
    .page-subtitle { font-size: 0.95rem; color: var(--text-secondary); margin-top: 0.35rem; }

    .btn-primary {
      display: inline-flex; align-items: center; gap: 0.5rem;
      padding: 0.72rem 1rem;
      background: linear-gradient(180deg, #10b981 0%, #047857 100%);
      color: #fff; border: 1px solid rgba(255,255,255,0.08);
      border-radius: var(--radius-md);
      font: inherit; font-size: 0.9rem; font-weight: 600;
      cursor: pointer; box-shadow: var(--shadow-card);
      transition: transform var(--t), box-shadow var(--t), opacity var(--t);
    }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: var(--shadow-hover); opacity: 0.95; }

    /* STATS */
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px,1fr)); gap: 14px; margin-bottom: 1.5rem; }
    .stat-card {
      background: rgba(255,255,255,0.95); border: 1px solid var(--border);
      border-radius: var(--radius-xl); padding: 1rem 1.15rem;
      box-shadow: var(--shadow-card); backdrop-filter: blur(10px);
      transition: transform var(--t), box-shadow var(--t), border-color var(--t);
    }
    .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-hover); border-color: rgba(16,185,129,0.25); }
    .stat-label { font-size: 0.72rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.45rem; }
    .stat-value { font-size: 2rem; font-weight: 700; letter-spacing: -0.05em; line-height: 1; }
    .stat-value.total  { color: var(--text-primary); }
    .stat-value.ok     { color: var(--green-text); }
    .stat-value.warn   { color: var(--amber-text); }
    .stat-value.danger { color: var(--red-text); }

    /* TOOLBAR */
    .toolbar { display: flex; gap: 10px; margin-bottom: 1rem; flex-wrap: wrap; align-items: center; }
    .search-wrap { position: relative; flex: 1; min-width: 240px; }
    .search-wrap svg { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); pointer-events: none; color: var(--text-muted); opacity: 0.8; }
    .toolbar input[type="text"], .toolbar select {
      font: inherit; padding: 0.72rem 0.9rem;
      background: rgba(255,255,255,0.98); border: 1px solid var(--border-strong);
      border-radius: var(--radius-md); color: var(--text-primary); outline: none;
      transition: border-color var(--t), background var(--t);
    }
    .toolbar input[type="text"] { padding-left: 2.3rem; width: 100%; }
    .toolbar input[type="text"]:hover, .toolbar select:hover { background: #fff; border-color: rgba(16,185,129,0.3); }
    .btn-export {
      padding: 0.72rem 0.95rem; background: rgba(255,255,255,0.95);
      border: 1px solid var(--border-strong); border-radius: var(--radius-md);
      font: inherit; font-size: 0.9rem; font-weight: 500;
      color: var(--text-secondary); text-decoration: none; cursor: pointer;
      transition: background var(--t), transform var(--t);
    }
    .btn-export:hover { background: var(--bg-hover); transform: translateY(-1px); }
        /* TABLE */
    .table-card { background: rgba(255,255,255,0.97); border: 1px solid var(--border); border-radius: var(--radius-xl); box-shadow: var(--shadow-card); overflow: hidden; }
    table { width: 100%; border-collapse: collapse; font-size: 0.92rem; }
    thead { background: #ecfdf5; border-bottom: 1px solid var(--border-strong); }
    th { padding: 0.9rem 1rem; text-align: left; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--text-muted); white-space: nowrap; }
    td { padding: 0.85rem 1rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
    tbody tr { transition: background var(--t); }
    tbody tr:hover { background: rgba(16,185,129,0.06); }
    .col-id { font-family: 'DM Mono', monospace; color: var(--text-muted); font-size: 0.88rem; }
    .med-name { font-weight: 600; }
    .cat-pill { display: inline-flex; align-items: center; padding: 0.28rem 0.65rem; background: #f0fdf4; border: 1px solid rgba(15,23,42,0.06); border-radius: 999px; font-size: 0.78rem; color: var(--text-secondary); white-space: nowrap; }
    .qty.low  { color: var(--red-text); font-weight: 700; }
    .qty.zero { color: var(--text-muted); }
    .badge { display: inline-flex; align-items: center; gap: 0.45rem; padding: 0.35rem 0.7rem; border-radius: 999px; font-size: 0.78rem; font-weight: 700; white-space: nowrap; }
    .badge-dot { width: 6px; height: 6px; border-radius: 50%; flex: 0 0 auto; }
    .badge.ok     { background: var(--green-bg); color: var(--green-text); } .badge.ok     .badge-dot { background: var(--green-dot); }
    .badge.warn   { background: var(--amber-bg); color: var(--amber-text); } .badge.warn   .badge-dot { background: var(--amber-dot); }
    .badge.danger { background: var(--red-bg);   color: var(--red-text);   } .badge.danger .badge-dot { background: var(--red-dot);   }
    .accion-text { display: block; max-width: 200px; font-size: 0.82rem; color: var(--text-secondary); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .empty-row td { text-align: center; padding: 4rem 1rem; color: var(--text-muted); }
    .table-footer { padding: 0.9rem 1rem; background: #ecfdf5; font-size: 0.82rem; color: var(--text-muted); border-top: 1px solid var(--border); }

    /* ACTION BUTTONS */
    .row-actions { display: flex; gap: 6px; }
    .btn-icon {
      width: 30px; height: 30px;
      display: inline-flex; align-items: center; justify-content: center;
      border-radius: var(--radius-sm); border: 1px solid var(--border-strong);
      background: rgba(255,255,255,0.9); cursor: pointer; color: var(--text-muted);
      transition: background var(--t), color var(--t), border-color var(--t), transform var(--t);
    }
    .btn-icon:hover { transform: translateY(-1px); }
    .btn-icon.edit:hover   { background: #ecfeff; color: var(--blue-accent); border-color: rgba(14,165,233,0.35); }
    .btn-icon.delete:hover { background: var(--red-bg); color: var(--red-text); border-color: rgba(239,68,68,0.3); }

    /* TOAST */
    .toast {
      position: fixed; top: 1.5rem; right: 1.5rem; z-index: 9999;
      display: flex; align-items: center; gap: 0.75rem;
      padding: 0.9rem 1.2rem; background: #065f46; color: #ecfdf5;
      border-radius: var(--radius-md); font-size: 0.88rem; font-weight: 500;
      box-shadow: 0 8px 30px rgba(0,0,0,0.25);
      animation: toastIn 0.3s ease, toastOut 0.4s ease 3.2s forwards;
    }
    .toast-icon { width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex: 0 0 auto; }
    .toast-icon.success { background: #10b981; }
    .toast-icon.danger  { background: #ef4444; }
    @keyframes toastIn  { from { opacity:0; transform:translateY(-12px); } to { opacity:1; transform:translateY(0); } }
    @keyframes toastOut { from { opacity:1; transform:translateY(0); } to { opacity:0; transform:translateY(-12px); } }

    /* MODAL SHARED */
    .modal-overlay {
      position: fixed; inset: 0; z-index: 1000;
      background: rgba(15,23,42,0.45); backdrop-filter: blur(4px);
      display: flex; align-items: center; justify-content: center;
      padding: 1.5rem; opacity: 0; pointer-events: none;
      transition: opacity 240ms ease;
    }
    .modal-overlay.open { opacity: 1; pointer-events: all; }
    .modal {
      background: #ffffff; border-radius: var(--radius-xl); box-shadow: var(--shadow-modal);
      width: 100%; max-width: 620px; max-height: 90vh; overflow-y: auto;
      transform: translateY(20px) scale(0.97); opacity: 0;
      transition: transform 280ms cubic-bezier(0.34,1.4,0.64,1), opacity 260ms ease;
    }
    .modal-overlay.open .modal { transform: translateY(0) scale(1); opacity: 1; }
        .modal-header {
      display: flex; justify-content: space-between; align-items: flex-start;
      padding: 1.6rem 1.75rem 1.25rem;
      position: sticky; top: 0; background: #ffffff; z-index: 2;
      border-bottom: 1px solid var(--border);
    }
    .modal-title    { font-size: 1.1rem; font-weight: 700; letter-spacing: -0.02em; }
    .modal-subtitle { font-size: 0.83rem; color: var(--text-muted); margin-top: 0.2rem; }
    .modal-close {
      width: 30px; height: 30px; background: #f0fdf4;
      border: 1px solid var(--border-strong); border-radius: var(--radius-sm);
      cursor: pointer; display: flex; align-items: center; justify-content: center;
      color: var(--text-muted); font-size: 1rem;
      transition: background var(--t), color var(--t), transform var(--t); flex: 0 0 auto;
    }
    .modal-close:hover { background: var(--red-bg); color: var(--red-text); transform: rotate(90deg); }
    .modal-body   { padding: 1.4rem 1.75rem; }
    .modal-footer { display: flex; justify-content: flex-end; gap: 0.75rem; padding: 1.2rem 1.75rem 1.6rem; border-top: 1px solid var(--border); }

    /* FORM */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.1rem; }
    .form-group { display: flex; flex-direction: column; gap: 0.38rem; }
    .form-group.full { grid-column: 1 / -1; }
    label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--text-muted); }
    .form-input, .form-select, .form-textarea {
      font: inherit; padding: 0.72rem 0.9rem;
      background: #f0fdf4; border: 1px solid var(--border-strong);
      border-radius: var(--radius-md); color: var(--text-primary); outline: none; width: 100%;
      transition: border-color var(--t), box-shadow var(--t), background var(--t);
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus { border-color: var(--blue-accent); box-shadow: 0 0 0 3px rgba(14,165,233,0.15); background: #ffffff; }
    .form-input.is-error, .form-select.is-error { border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,0.12); }
    .form-textarea { resize: vertical; min-height: 84px; }
    .error-msg { font-size: 0.77rem; color: #b91c1c; }

    .estado-preview {
      display: flex; align-items: center; gap: 0.6rem;
      padding: 0.6rem 0.9rem; min-height: 44px;
      background: #ecfdf5; border: 1px solid var(--border-strong);
      border-radius: var(--radius-md); font-size: 0.82rem; color: var(--text-muted);
    }

    .btn-cancel {
      padding: 0.72rem 1.2rem; background: transparent;
      border: 1px solid var(--border-strong); border-radius: var(--radius-md);
      font: inherit; font-size: 0.9rem; font-weight: 500;
      color: var(--text-secondary); cursor: pointer;
      transition: background var(--t);
    }
    .btn-cancel:hover { background: var(--bg-hover); }
    .btn-save {
      display: inline-flex; align-items: center; gap: 0.5rem;
      padding: 0.72rem 1.4rem;
      background: linear-gradient(180deg, #10b981 0%, #047857 100%);
      color: #ffffff; border: 1px solid rgba(255,255,255,0.08);
      border-radius: var(--radius-md); font: inherit; font-size: 0.9rem; font-weight: 600;
      cursor: pointer; box-shadow: var(--shadow-card);
      transition: transform var(--t), box-shadow var(--t), opacity var(--t);
    }
    .btn-save:hover { transform: translateY(-1px); opacity: 0.92; }
    .btn-save:disabled { opacity: 0.55; cursor: not-allowed; transform: none; }
    .spinner { width: 14px; height: 14px; border: 2px solid rgba(255,255,255,0.3); border-top-color: #ffffff; border-radius: 50%; animation: spin 0.7s linear infinite; display: none; }
    .btn-save.loading .spinner, .btn-danger.loading .spinner { display: block; }
    .btn-save.loading .btn-label, .btn-danger.loading .btn-label { opacity: 0.6; }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* DELETE MODAL */
    .modal.modal-sm { max-width: 420px; }
    .delete-body { padding: 2rem 1.75rem 1.25rem; text-align: center; }
    .delete-icon {
      width: 52px; height: 52px; background: var(--red-bg);
      border-radius: 50%; display: flex; align-items: center; justify-content: center;
      margin: 0 auto 1.1rem;
    }
    .delete-title { font-size: 1.05rem; font-weight: 700; margin-bottom: 0.5rem; }
    .delete-msg   { font-size: 0.88rem; color: var(--text-secondary); line-height: 1.6; }
    .delete-name  { font-weight: 600; color: var(--text-primary); }
    .delete-footer { display: flex; justify-content: center; gap: 0.75rem; padding: 1rem 1.75rem 1.75rem; }
    .btn-danger {
      display: inline-flex; align-items: center; gap: 0.5rem;
      padding: 0.72rem 1.4rem;
      background: linear-gradient(180deg, #ef4444 0%, #b91c1c 100%);
      color: #ffffff; border: 1px solid rgba(255,255,255,0.1);
      border-radius: var(--radius-md); font: inherit; font-size: 0.9rem; font-weight: 600;
      cursor: pointer; box-shadow: var(--shadow-card);
      transition: transform var(--t), opacity var(--t);
    }
    .btn-danger:hover { transform: translateY(-1px); opacity: 0.9; }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      body { padding: 1rem; }
      .page-header { flex-direction: column; align-items: stretch; }
      .toolbar { flex-direction: column; align-items: stretch; }
      .search-wrap { min-width: 100%; }
      .toolbar input[type="text"], .toolbar select, .btn-export { width: 100%; }
      .stats-grid { grid-template-columns: repeat(auto-fit, minmax(150px,1fr)); }
      table { min-width: 800px; }
      .table-card { overflow-x: auto; }
      .modal { border-radius: var(--radius-lg); }
      .form-grid { grid-template-columns: 1fr; }
      .form-group.full { grid-column: 1; }
    }
    @media (prefers-reduced-motion: reduce) { *, *::before, *::after { transition: none !important; animation: none !important; } }
  </style>
</head>

<body>

  {{-- TOAST --}}
  @if(session('success'))
    <div class="toast" id="toast">
      <div class="toast-icon success">
        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M2 5l2 2 4-4" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </div>
      {{ session('success') }}
    </div>
  @endif
  @if(session('deleted'))
    <div class="toast" id="toast">
      <div class="toast-icon danger">
        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M2.5 7.5l5-5M7.5 7.5l-5-5" stroke="#fff" stroke-width="1.5" stroke-linecap="round"/></svg>
      </div>
      {{ session('deleted') }}
    </div>
  @endif

  {{-- PAGE HEADER --}}
  <div class="page-header">
    <div>
      <h1 class="page-title">Inventario de Medicamentos</h1>
      <p class="page-subtitle">Panel de control para la gestión del botiquín familiar</p>
    </div>
    <button class="btn-primary" id="btnNuevo" type="button">
      <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M7 1v12M1 7h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      Nuevo medicamento
    </button>
  </div>

  {{-- STATS --}}
  <div class="stats-grid">
    <div class="stat-card"><div class="stat-label">Total registros</div><div class="stat-value total">{{ $stats['total'] }}</div></div>
    <div class="stat-card"><div class="stat-label">Vigentes</div><div class="stat-value ok">{{ $stats['vigentes'] }}</div></div>
    <div class="stat-card"><div class="stat-label">Por caducar</div><div class="stat-value warn">{{ $stats['proximos'] }}</div></div>
    <div class="stat-card"><div class="stat-label">Caducados</div><div class="stat-value danger">{{ $stats['caducados'] }}</div></div>
  </div>

  {{-- TOOLBAR --}}
  <form action="{{ route('medicamentos.index') }}" method="GET" class="toolbar">
    <div class="search-wrap">
      <svg width="14" height="14" viewBox="0 0 16 16" fill="none"><circle cx="6.5" cy="6.5" r="4.5" stroke="currentColor" stroke-width="1.5"/><path d="M10 10L14 14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
      <input type="text" name="buscar" placeholder="Buscar por nombre..." value="{{ request('buscar') }}" onchange="this.form.submit()">
    </div>
    <select name="estado" onchange="this.form.submit()">
      <option value="">Todos los estados</option>
      <option value="Vigente"           {{ request('estado') == 'Vigente'           ? 'selected' : '' }}>Vigente</option>
      <option value="Próximo a caducar" {{ request('estado') == 'Próximo a caducar' ? 'selected' : '' }}>Próximo a caducar</option>
      <option value="Caducado"          {{ request('estado') == 'Caducado'          ? 'selected' : '' }}>Caducado</option>
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

  {{-- TABLE --}}
  <div class="table-card">
    <table>
      <thead>
        <tr>
          <th>ID</th><th>Nombre</th><th>Categoría</th><th>Cantidad</th>
          <th>Caducidad</th><th>Estado</th><th>Acción recomendada</th><th>Acciones</th>
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
            <td>{{ $m->fecha_caducidad->format('d/m/Y') }}</td>
            <td>
              @php $clase = ['Vigente'=>'ok','Próximo a caducar'=>'warn','Caducado'=>'danger'][$m->estado] ?? 'ok'; @endphp
              <span class="badge {{ $clase }}"><span class="badge-dot"></span>{{ $m->estado }}</span>
            </td>
            <td><span class="accion-text" title="{{ $m->accion_recomendada }}">{{ $m->accion_recomendada }}</span></td>
            <td>
              <div class="row-actions">
                <button type="button" class="btn-icon edit" title="Editar"
                  data-id="{{ $m->id }}"
                  data-nombre="{{ $m->nombre }}"
                  data-cantidad="{{ $m->cantidad }}"
                  data-fecha="{{ $m->fecha_caducidad->format('Y-m-d') }}"
                  data-categoria="{{ $m->id_categoria }}"
                  data-accion="{{ $m->accion_recomendada }}"
                  onclick="abrirEditar(this)">
                  <svg width="13" height="13" viewBox="0 0 16 16" fill="none">
                    <path d="M11.5 2.5a2.121 2.121 0 013 3L5 15H2v-3L11.5 2.5z" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </button>
                <button type="button" class="btn-icon delete" title="Eliminar"
                  data-id="{{ $m->id }}"
                  data-nombre="{{ $m->nombre }}"
                  onclick="abrirEliminar(this)">
                  <svg width="13" height="13" viewBox="0 0 16 16" fill="none">
                    <path d="M2 4h12M5 4V2h6v2M6 7v5M10 7v5M3 4l1 9h8l1-9" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </button>
              </div>
            </td>
          </tr>
        @empty
          <tr class="empty-row">
            <td colspan="8">
              <span style="font-size:24px;display:block;margin-bottom:10px;">📦</span>
              No se encontraron medicamentos registrados.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div class="table-footer">Mostrando {{ $medicamentos->count() }} de {{ $stats['total'] }} registros encontrados</div>
  </div>


  {{-- ════════════════════════════
       MODAL — NUEVO MEDICAMENTO
  ════════════════════════════ --}}
  <div class="modal-overlay" id="modalCrear">
    <div class="modal">
      <div class="modal-header">
        <div>
          <div class="modal-title">Nuevo medicamento</div>
          <div class="modal-subtitle">El estado se calcula automáticamente según la caducidad</div>
        </div>
        <button class="modal-close" type="button" onclick="cerrar('modalCrear')">✕</button>
      </div>
      <form action="{{ route('medicamentos.store') }}" method="POST" onsubmit="loading(this)">
        @csrf
        <div class="modal-body">
          <div class="form-grid">
            <div class="form-group full">
              <label for="c_nombre">Nombre del medicamento <span style="color:#ef4444">*</span></label>
              <input type="text" id="c_nombre" name="nombre"
                     class="form-input {{ $errors->has('nombre') && !session('editing') ? 'is-error' : '' }}"
                     placeholder="Ej. Paracetamol 500mg"
                     value="{{ !session('editing') ? old('nombre') : '' }}" autocomplete="off">
              @if(!session('editing')) @error('nombre') <span class="error-msg">{{ $message }}</span> @enderror @endif
            </div>
            <div class="form-group">
              <label for="c_categoria">Categoría <span style="color:#ef4444">*</span></label>
              <select id="c_categoria" name="id_categoria"
                      class="form-select {{ $errors->has('id_categoria') && !session('editing') ? 'is-error' : '' }}">
                <option value="">Seleccionar...</option>
                @foreach($categorias as $cat)
                  <option value="{{ $cat->id_categoria }}"
                    {{ (!session('editing') && old('id_categoria') == $cat->id_categoria) ? 'selected' : '' }}>
                    {{ $cat->nombre_categoria }}
                  </option>
                @endforeach
              </select>
              @if(!session('editing')) @error('id_categoria') <span class="error-msg">{{ $message }}</span> @enderror @endif
            </div>
            <div class="form-group">
              <label for="c_cantidad">Cantidad <span style="color:#ef4444">*</span></label>
              <input type="number" id="c_cantidad" name="cantidad"
                     class="form-input {{ $errors->has('cantidad') && !session('editing') ? 'is-error' : '' }}"
                     placeholder="0" min="0" value="{{ !session('editing') ? old('cantidad') : '' }}">
              @if(!session('editing')) @error('cantidad') <span class="error-msg">{{ $message }}</span> @enderror @endif
            </div>
            <div class="form-group">
              <label for="c_fecha">Fecha de caducidad <span style="color:#ef4444">*</span></label>
              <input type="date" id="c_fecha" name="fecha_caducidad"
                     class="form-input {{ $errors->has('fecha_caducidad') && !session('editing') ? 'is-error' : '' }}"
                     value="{{ !session('editing') ? old('fecha_caducidad') : '' }}">
              @if(!session('editing')) @error('fecha_caducidad') <span class="error-msg">{{ $message }}</span> @enderror @endif
            </div>
            <div class="form-group full">
              <label>Estado (calculado automáticamente)</label>
              <div class="estado-preview" id="c_estadoPreview">
                <span style="color:var(--text-muted);font-size:0.82rem;">Selecciona una fecha…</span>
              </div>
            </div>
            <div class="form-group full">
              <label for="c_accion">Acción recomendada</label>
              <textarea id="c_accion" name="accion_recomendada" class="form-textarea"
                        placeholder="Ej. Mantener en lugar fresco y seco...">{{ !session('editing') ? old('accion_recomendada') : '' }}</textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-cancel" onclick="cerrar('modalCrear')">Cancelar</button>
          <button type="submit" class="btn-save">
            <div class="spinner"></div><span class="btn-label">Guardar medicamento</span>
          </button>
        </div>
      </form>
    </div>
  </div>


  {{-- ════════════════════════════
       MODAL — EDITAR MEDICAMENTO
  ════════════════════════════ --}}
  <div class="modal-overlay" id="modalEditar">
    <div class="modal">
      <div class="modal-header">
        <div>
          <div class="modal-title">Editar medicamento</div>
          <div class="modal-subtitle">Modifica los datos y guarda los cambios</div>
        </div>
        <button class="modal-close" type="button" onclick="cerrar('modalEditar')">✕</button>
      </div>
      <form id="formEditar" action="" method="POST" onsubmit="loading(this)">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="form-grid">
            <div class="form-group full">
              <label for="e_nombre">Nombre del medicamento <span style="color:#ef4444">*</span></label>
              <input type="text" id="e_nombre" name="nombre"
                     class="form-input {{ $errors->has('nombre') && session('editing') ? 'is-error' : '' }}"
                     placeholder="Ej. Paracetamol 500mg"
                     value="{{ session('editing') ? old('nombre') : '' }}" autocomplete="off">
              @if(session('editing')) @error('nombre') <span class="error-msg">{{ $message }}</span> @enderror @endif
            </div>
            <div class="form-group">
              <label for="e_categoria">Categoría <span style="color:#ef4444">*</span></label>
              <select id="e_categoria" name="id_categoria"
                      class="form-select {{ $errors->has('id_categoria') && session('editing') ? 'is-error' : '' }}">
                <option value="">Seleccionar...</option>
                @foreach($categorias as $cat)
                  <option value="{{ $cat->id_categoria }}"
                    {{ (session('editing') && old('id_categoria') == $cat->id_categoria) ? 'selected' : '' }}>
                    {{ $cat->nombre_categoria }}
                  </option>
                @endforeach
              </select>
              @if(session('editing')) @error('id_categoria') <span class="error-msg">{{ $message }}</span> @enderror @endif
            </div>
            <div class="form-group">
              <label for="e_cantidad">Cantidad <span style="color:#ef4444">*</span></label>
              <input type="number" id="e_cantidad" name="cantidad"
                     class="form-input {{ $errors->has('cantidad') && session('editing') ? 'is-error' : '' }}"
                     placeholder="0" min="0" value="{{ session('editing') ? old('cantidad') : '' }}">
              @if(session('editing')) @error('cantidad') <span class="error-msg">{{ $message }}</span> @enderror @endif
            </div>
            <div class="form-group">
              <label for="e_fecha">Fecha de caducidad <span style="color:#ef4444">*</span></label>
              <input type="date" id="e_fecha" name="fecha_caducidad"
                     class="form-input {{ $errors->has('fecha_caducidad') && session('editing') ? 'is-error' : '' }}"
                     value="{{ session('editing') ? old('fecha_caducidad') : '' }}">
              @if(session('editing')) @error('fecha_caducidad') <span class="error-msg">{{ $message }}</span> @enderror @endif
            </div>
            <div class="form-group full">
              <label>Estado (calculado automáticamente)</label>
              <div class="estado-preview" id="e_estadoPreview">
                <span style="color:var(--text-muted);font-size:0.82rem;">Selecciona una fecha…</span>
              </div>
            </div>
            <div class="form-group full">
              <label for="e_accion">Acción recomendada</label>
              <textarea id="e_accion" name="accion_recomendada" class="form-textarea"
                        placeholder="Ej. Mantener en lugar fresco y seco...">{{ session('editing') ? old('accion_recomendada') : '' }}</textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-cancel" onclick="cerrar('modalEditar')">Cancelar</button>
          <button type="submit" class="btn-save">
            <div class="spinner"></div><span class="btn-label">Guardar cambios</span>
          </button>
        </div>
      </form>
    </div>
  </div>


  {{-- ══════════════════════════════════
       MODAL — CONFIRMAR ELIMINACIÓN
  ══════════════════════════════════ --}}
  <div class="modal-overlay" id="modalEliminar">
    <div class="modal modal-sm">
      <div class="delete-body">
        <div class="delete-icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
            <path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6M10 11v6M14 11v6" stroke="#ef4444" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        <div class="delete-title">¿Eliminar medicamento?</div>
        <p class="delete-msg">
          Estás a punto de eliminar <span class="delete-name" id="deleteNombre"></span>.<br>
          Esta acción no se puede deshacer.
        </p>
      </div>
      <div class="delete-footer">
        <button type="button" class="btn-cancel" onclick="cerrar('modalEliminar')">Cancelar</button>
        <form id="formEliminar" action="" method="POST" onsubmit="loading(this)">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn-danger">
            <div class="spinner"></div><span class="btn-label">Sí, eliminar</span>
          </button>
        </form>
      </div>
    </div>
  </div>


  <script>
    /* ─── Abrir / cerrar ─── */
    function abrir(id) {
      document.getElementById(id).classList.add('open');
      document.body.style.overflow = 'hidden';
    }
    function cerrar(id) {
      document.getElementById(id).classList.remove('open');
      document.body.style.overflow = '';
    }
    function loading(form) {
      const btn = form.querySelector('.btn-save, .btn-danger');
      if (btn) { btn.classList.add('loading'); btn.disabled = true; }
    }

    /* Cerrar al click fuera o Escape */
    document.querySelectorAll('.modal-overlay').forEach(o => {
      o.addEventListener('click', e => { if (e.target === o) cerrar(o.id); });
    });
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape')
        document.querySelectorAll('.modal-overlay.open').forEach(o => cerrar(o.id));
    });

    /* ─── Botón Nuevo ─── */
    document.getElementById('btnNuevo').addEventListener('click', () => {
      abrir('modalCrear');
      setTimeout(() => document.getElementById('c_nombre').focus(), 280);
    });

    /* ─── Reabrir modales si hay errores de validación ─── */
    @if($errors->any() && !session('editing'))
      document.addEventListener('DOMContentLoaded', () => abrir('modalCrear'));
    @endif
    @if($errors->any() && session('editing'))
      document.addEventListener('DOMContentLoaded', () => {
        abrir('modalEditar');
        const f = document.getElementById('e_fecha');
        if (f.value) actualizarEstado(f, document.getElementById('e_estadoPreview'));
      });
    @endif

    /* ─── Abrir modal editar ─── */
    function abrirEditar(btn) {
      const id = btn.dataset.id;

      // Actualizar action dinámicamente
      document.getElementById('formEditar').action = `/medicamentos/${id}`;

      // Rellenar campos con los datos actuales del registro
      document.getElementById('e_nombre').value   = btn.dataset.nombre;
      document.getElementById('e_cantidad').value = btn.dataset.cantidad;
      document.getElementById('e_fecha').value    = btn.dataset.fecha;
      document.getElementById('e_accion').value   = btn.dataset.accion;

      // Seleccionar la categoría correcta
      const sel = document.getElementById('e_categoria');
      Array.from(sel.options).forEach(opt => {
        opt.selected = opt.value == btn.dataset.categoria;
      });

      // Mostrar preview del estado
      actualizarEstado(document.getElementById('e_fecha'), document.getElementById('e_estadoPreview'));

      abrir('modalEditar');
      setTimeout(() => document.getElementById('e_nombre').focus(), 280);
    }

    /* ─── Abrir modal eliminar ─── */
    function abrirEliminar(btn) {
      document.getElementById('deleteNombre').textContent = `"${btn.dataset.nombre}"`;
      document.getElementById('formEliminar').action = `/medicamentos/${btn.dataset.id}`;
      abrir('modalEliminar');
    }

    /* ─── Preview de estado según fecha ─── */
    function actualizarEstado(input, preview) {
      if (!input.value) {
        preview.innerHTML = '<span style="color:var(--text-muted);font-size:0.82rem;">Selecciona una fecha…</span>';
        return;
      }
      const fecha = new Date(input.value + 'T00:00:00');
      const hoy   = new Date(); hoy.setHours(0,0,0,0);
      const diff  = Math.ceil((fecha - hoy) / 86400000);

      let badge, texto;
      if      (diff < 0)   { badge = 'danger'; texto = 'Caducado'; }
      else if (diff <= 30) { badge = 'warn';   texto = 'Próximo a caducar'; }
      else                 { badge = 'ok';     texto = 'Vigente'; }

      const dot  = { ok:'var(--green-dot)', warn:'var(--amber-dot)', danger:'var(--red-dot)' }[badge];
      const info = diff < 0  ? `Venció hace ${Math.abs(diff)} día${Math.abs(diff)===1?'':'s'}`
                 : diff === 0 ? 'Caduca hoy'
                 : `Caduca en ${diff} día${diff===1?'':'s'}`;

      preview.innerHTML = `
        <span class="badge ${badge}">
          <span class="badge-dot" style="background:${dot}"></span>${texto}
        </span>
        <span style="font-size:0.78rem;color:var(--text-muted);">${info}</span>`;
    }

    /* Conectar inputs con preview */
    const cFecha = document.getElementById('c_fecha');
    const eFecha = document.getElementById('e_fecha');
    cFecha.addEventListener('input', () => actualizarEstado(cFecha, document.getElementById('c_estadoPreview')));
    eFecha.addEventListener('input', () => actualizarEstado(eFecha, document.getElementById('e_estadoPreview')));
    if (cFecha.value) actualizarEstado(cFecha, document.getElementById('c_estadoPreview'));
    if (eFecha.value) actualizarEstado(eFecha, document.getElementById('e_estadoPreview'));

    /* ─── Auto-dismiss toast ─── */
    const toast = document.getElementById('toast');
    if (toast) setTimeout(() => toast.remove(), 3600);
  </script>

</body>
</html>