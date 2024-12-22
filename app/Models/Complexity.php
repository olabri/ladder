
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complexity extends Model
{
    const array level = [1=> 'easy', 2=> 'medium', 3=> 'complex']; 
    
    public function get ($id) {

        return $this->level[$id];
        
    }

}
