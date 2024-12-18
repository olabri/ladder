<div>
    <!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->

    @foreach ($players as $player)
        <p>{{ $player['id'] }} {{ $player['name'] }}</p>
    @endforeach

</div>
