<div>
    <!-- Simplicity is the consequence of refined emotions. - Jean D'Alembert -->


    @foreach ($games as $game)
    <p>{{ $game['id'] }} {{ $game['name'] }}</p>
@endforeach

</div>
