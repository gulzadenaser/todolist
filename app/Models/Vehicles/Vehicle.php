<?php

namespace App\Models\Vehicles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    /**
  * The table associated with the model.
  *
  * @var string
  */
  protected $table = 'vehicles';
  //set fillable fields
  protected $fillable = [ 
              'category_id', 
              'color', 
              'model', 
              'make', 
              'registration_no'
            ];

   protected $hidden = [
         'created_at',            
         'updated_at'            
   ];

   //set relation to parent category
   public function Category()
   {
       return $this->belongsTo('App\Models\Vehicles\Category','category_id', 'id');
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
