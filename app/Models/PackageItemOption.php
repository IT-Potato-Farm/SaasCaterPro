<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageItemOption extends Model
{
    use HasFactory;
    protected $fillable = ['package_item_id', 'item_option_id'];

    public function packageItem()
    {
        return $this->belongsTo(PackageItem::class);
    }
    public function itemOption()
    {
        return $this->belongsTo(ItemOption::class);
    }
}
