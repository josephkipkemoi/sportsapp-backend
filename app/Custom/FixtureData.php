<?

namespace App\Custom;
use Illuminate\Support\Facades\Http;

class FixtureData 
{
    public static function getFixture()
    {
        $response = Http::withHeaders([
            'X-RapidAPI-Host' => 'api-football-v1.p.rapidapi.com',
            'X-RapidAPI-Key' => 'b2c138608fmsh6567bc9b793b465p1a4945jsnb15afccb7248',
            'Content-Type' => 'application/json',
        ])->get('https://api-football-v1.p.rapidapi.com/v3/fixtures?next=50');

        return $response;
    }
}



