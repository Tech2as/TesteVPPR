@extends('layouts.app')
@section('title', 'Serviços')

@section('actions')
    <button class="btn btn-primary" id="btnNovoServico">+ Novo Serviço</button>
@endsection

@section('content')

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Valor</th>
                    <th>Descrição</th>
                    <th>Data de criação</th>
                    <th>Data de atualização</th>
                    <th>Ações</th>
                </tr>
            </thead>
       <tbody>
   @forelse ($services as $service)
    <tr>
        <td>{{ $service->nome }}</td>
        <td>R$ {{ number_format($service->valor, 2, ',', '.') }}</td>
        <td>{{ $service->descricao ?? '—' }}</td>
        <td>{{ $service->created_at->format('d/m/Y H:i') }}</td>
        <td>{{ $service->updated_at->format('d/m/Y H:i') }}</td>
     <td style="display:flex; gap:8px; align-items:center">
    <button class="btn btn-ghost"
        data-id="{{ $service->id }}"
        data-nome="{{ $service->nome }}"
        data-valor="{{ $service->valor }}"
        data-descricao="{{ $service->descricao }}"
        onclick="abrirEditar(this)">
        Editar
    </button>
    <form method="POST" action="{{ route('services.destroy', $service) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger"
            onclick="return confirm('Excluir este serviço?')">Excluir</button>
    </form>
</td>
    </tr>
@empty
        <tr>
            <td colspan="4" style="text-align:center; color:var(--muted); padding: 32px">
                Nenhum serviço cadastrado ainda.
            </td>
        </tr>
    @endforelse
</tbody>
        </table>
    </div>

    {{-- MODAL --}}
    <div class="modal-overlay {{ $errors->any() ? 'open' : '' }}" id="modalOverlay">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">Novo Serviço</h2>
                <button class="modal-close" id="modalClose" aria-label="Fechar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form method="POST" action=" {{ route('services.store') }} ">
                @csrf

                <div class="modal-body">
                    @if ($errors->any())
                        <div class="form-errors">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="nome" value="{{ old('nome') }}" placeholder="Ex: Consultoria" required>
                    </div>

                    <div class="form-group">
                        <label>Valor</label>
                        <input type="number" name="valor" value="{{ old('valor') }}" placeholder="0,00" step="0.01" min="0" required>
                    </div>

                    <div class="form-group">
                        <label>Descrição <span class="optional">— opcional</span></label>
                        <textarea name="descricao" placeholder="Descreva o serviço...">{{ old('descricao') }}</textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost" id="modalCancel">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar serviço</button>
                </div>
            </form>
        </div>
    </div>

{{-- MODAL EDITAR --}}
<div class="modal-overlay" id="modalEditarOverlay">
    <div class="modal">
        <div class="modal-header">
            <h2 class="modal-title">Editar Serviço</h2>
            <button class="modal-close" id="modalEditarClose" aria-label="Fechar">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form method="POST" id="formEditar">
            @csrf
            @method('PUT')

            <div class="modal-body">
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="nome" id="editNome" required>
                </div>

                <div class="form-group">
                    <label>Valor</label>
                    <input type="number" name="valor" id="editValor" step="0.01" min="0" required>
                </div>

                <div class="form-group">
                    <label>Descrição <span class="optional">— opcional</span></label>
                    <textarea name="descricao" id="editDescricao"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" id="modalEditarCancel">Cancelar</button>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </form>
    </div>
</div>

    <script>
        const overlay   = document.getElementById('modalOverlay');
        const btnOpen   = document.getElementById('btnNovoServico');
        const btnClose  = document.getElementById('modalClose');
        const btnCancel = document.getElementById('modalCancel');

        btnOpen?.addEventListener('click',  () => overlay.classList.add('open'));
        btnClose?.addEventListener('click', () => overlay.classList.remove('open'));
        btnCancel?.addEventListener('click',() => overlay.classList.remove('open'));

        overlay?.addEventListener('click', e => {
            if (e.target === overlay) overlay.classList.remove('open');
        });

        const overlayEditar    = document.getElementById('modalEditarOverlay');
const btnEditarClose   = document.getElementById('modalEditarClose');
const btnEditarCancel  = document.getElementById('modalEditarCancel');

btnEditarClose?.addEventListener('click',  () => overlayEditar.classList.remove('open'));
btnEditarCancel?.addEventListener('click', () => overlayEditar.classList.remove('open'));
overlayEditar?.addEventListener('click', e => {
    if (e.target === overlayEditar) overlayEditar.classList.remove('open');
});

function abrirEditar(btn) {
    const id        = btn.dataset.id;
    const nome      = btn.dataset.nome;
    const valor     = btn.dataset.valor;
    const descricao = btn.dataset.descricao;

    document.getElementById('editNome').value      = nome;
    document.getElementById('editValor').value     = valor;
    document.getElementById('editDescricao').value = descricao ?? '';
    document.getElementById('formEditar').action   = `/services/${id}`;
    overlayEditar.classList.add('open');
}
    </script>

@endsection