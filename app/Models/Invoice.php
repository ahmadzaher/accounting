<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'amount',
        'type',
        'description',
        'client_id'
    ];
    /**
     * Get the client that owns the invoice.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d', strtotime($value));
    }
}
