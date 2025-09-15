<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    protected $fillable = [
        'email',
        'phone',
        'address',
        'google_map_embed',
        'company_name',
        'company_description',
        'company_logo',
        'info_email',
        'customer_support_email',
        'whatsapp',
        'whatsapp_qr',
        'whatsapp_link',
    ];
}
