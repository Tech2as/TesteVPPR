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
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4" style="text-align:center; color:var(--muted); padding: 32px">
                        Nenhum serviço cadastrado ainda.
                    </td>
                </tr>
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

            <form method="POST" action="#">
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
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Ex: Consultoria" required>
                    </div>

                    <div class="form-group">
                        <label>Valor</label>
                        <input type="number" name="value" value="{{ old('value') }}" placeholder="0,00" step="0.01" min="0" required>
                    </div>

                    <div class="form-group">
                        <label>Descrição <span class="optional">— opcional</span></label>
                        <textarea name="description" placeholder="Descreva o serviço...">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost" id="modalCancel">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar serviço</button>
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
    </script>

@endsection