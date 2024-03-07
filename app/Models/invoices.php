<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class invoices extends Model
{
    use HasFactory;
    protected $guarded =[];
    protected $casts = [
        //هنا بقدر اغير صيفة اى حقل من الحقول
        'attach' => 'json'
    ];

    /**
     * Get the user that owns the invoices
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function details(): BelongsTo
    {
        return $this->belongsTo(invoice_details::class, 'invoice_id', 'id');
    }

    /**
     * Get the user that owns the invoices
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(section::class, 'section_id', 'id');
    }

}
