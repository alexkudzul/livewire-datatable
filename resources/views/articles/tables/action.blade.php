<div class="flex space-x-1">
    <a class="btn btn-green" href="{{ route('dashboard', ['id' => $id]) }}">
        Ver
    </a>

    <a class="btn btn-blue" href="{{ route('dashboard', ['id' => $id]) }}">
        Editar
    </a>

    <form action="">
        @csrf
        <button class="btn btn-red">
            Eliminar
        </button>
    </form>
</div>
