<?php

namespace App\Models\Vehicles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
     /**
  * The table associated with the model.
  *
  * @var string
  */
  protected $table = 'categories';
  //set fillable fields
  protected $fillable = [ 
              'name'
            ];

   protected $hidden = [
         'created_at',            
         'updated_at'            
   ];

   /**
     * set relation with vehicles
    */
    public function Vehicles()
    {
        return $this->hasMany('App\Models\Vehicles\Vehicle','category_id','id');
    }

    /** 
     * return fillable fields
     * @return fillable Array
    */
    public function getFillables(): Array
    {
        return $this->fillable;
    }
}
