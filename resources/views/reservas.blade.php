<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reservas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <h1>Lista de salas disponibles</h1>

  <table>
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Horas disponibles por día</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($Salas as $Sala)
        <tr>
          <td>{{ $Sala->name }}</td>
          <td>{{ $Sala->description }}</td>
          <td>{{ $Sala->horas_disponibles_por_dia }}</td>
          <td><a href="{{ route('reservations.create', $Sala) }}">Reservar</a></td>
        </tr>
      @endforeach
    </tbody>
  </table>
                
            </div>
        </div>
    </div>
</x-app-layout>
