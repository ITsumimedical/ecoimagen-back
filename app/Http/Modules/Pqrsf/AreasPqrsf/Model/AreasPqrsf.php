<?php

namespace App\Http\Modules\Pqrsf\AreasPqrsf\Model;

use App\Http\Modules\Areas\Models\Area;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreasPqrsf extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'areas_pqrsf';

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
