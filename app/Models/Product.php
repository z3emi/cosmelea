<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', // ** تم إضافة هذا السطر **
        'name_ar',
        'name_en',
        'name_ku',
        'description_ar',
        'description_en',
        'description_ku',
        'price',
        'cost_price',
        'image_url',
        'stock_quantity',
    ];

    /**
     * ** العلاقة الجديدة: كل منتج يتبع لقسم واحد **
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}