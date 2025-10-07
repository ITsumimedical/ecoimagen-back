<?php

namespace App\Http\Modules\Pqrsf\IpsPqrsf\Model;

use App\Http\Modules\Reps\Models\Rep;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ipsPqrsf extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'ips_pqrsf';

    public function rep()
    {
        return $this->belongsTo(Rep::class);
    }
}
