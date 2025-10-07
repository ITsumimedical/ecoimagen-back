<?php

namespace App\Http\Modules\FacturacionElectronica\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estructura_factura_electronica extends Model
{
    use HasFactory;

    protected $table = 'estructura_factura_electronicas';

    protected $fillable = [
        'number',
        'type_document_id',
        'date',
        'time',
        'resolution_number',
        'prefix',
        'notes',
        'disable_confirmation_text',
        'establishment_name',
        'establishment_address',
        'establishment_phone',
        'establishment_municipality',
        'establishment_email',
        'sendmail',
        'sendmailtome',
        'send_customer_credentials',
        'seze',
        'email_cc_list',
        'annexes',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i:s',
        'disable_confirmation_text' => 'boolean',
        'sendmail' => 'boolean',
        'sendmailtome' => 'boolean',
        'send_customer_credentials' => 'boolean',
        'email_cc_list' => 'array',
        'annexes' => 'array',
    ];
}
