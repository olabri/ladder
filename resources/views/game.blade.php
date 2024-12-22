<div>
    <!-- Simplicity is the consequence of refined emotions. - Jean D'Alembert -->

    <p>{{ $game['id'] }} {{ $game['name'] }} {{ $game['complexity'] }}</p>

    <p>Played:</p>

    @foreach ($game['gameplays'] as $gameplay)
     <p>{{ $gameplay['date_played'] }} 
     {{ $gameplay['location'] }} 
     {{ TODO view ($gameplay['results'] }})</p>  <!-- extract data and pass to view-->
    
    @endforeach
    

</div>
