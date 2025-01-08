<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complexity extends Model
{
    const array level = [1=> 'easy', 2=> 'medium', 3=> 'complex']; 
    const array easy = [4=> 0, 3=> 1, 2=> 1, 1=>2]; 
    const array medium = [4=> 1, 3=> 1, 2=> 2, 1=>3]; 
    const array complex = [5=>1,  4=> 1, 3=> 2, 2=> 3, 1=>5]; 
    
    public static function get ($id) {
        return self::level[$id];
    }

    public static function points ($place, $level) {
        return self::{self::level[$level]}[$place];
    }

}
