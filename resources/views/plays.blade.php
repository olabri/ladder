<div>
    <!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->
    
    <table>
    
    @foreach ($plays as $play)
        @if (isset($play['game']))
    
            <tr><th colspan = 5>{{ $play['game'] ?? ""}} ({{ $play['complexity_pretty'] ?? ""}})</th></tr>
            <tr><th colspan = 2>{{ $play['date_played'] ?? ""}} {{ $play['location'] ?? ""}}</th></tr>
            @foreach ($play['results'] as $result)
                <tr>
                    <td>{{ $result['user_name'] }}</td>
                    <td>{{ $result['points'] }}</td>
                </tr>

            @endforeach
        @endif 
    @endforeach
    </table>

     @dd($plays['ladder'])

</div>
