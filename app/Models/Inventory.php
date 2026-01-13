<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'inventory';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'cloudapi_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cloudapi()
    {
        return $this->belongsTo(CloudApi::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
