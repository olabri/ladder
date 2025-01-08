<div>
@dump($game)
    <!-- Simplicity is the consequence of refined emotions. - Jean D'Alembert -->
    <p>
    @isset($game['id'])
    {{ $game['id'] }} {{ $game['name'] }} {{ $game['complexity'] }}
    @else
      Game not found
    @endisset
    </p>
    <p>Played:</p>
    <!--
      
      @dump($users)
    -->

    @foreach ($game['gameplays'] as $gameplay)
    *
      {{ $gameplay['date_played'] }} 
      {{ $gameplay['location'] }} 
      
      @foreach ($gameplay['results'] as $key=>$result) 
        <p>* {{ $users[$key]['name'] ?? 'Unknown' }} 
        {{ $result }} </p> <!-- extract data and pass to view-->
      @endforeach
    @endforeach
</div>
