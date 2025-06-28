<?php
// ======================================================================
// الملف: app/Models/Category.php
// ======================================================================
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name_ar', 'slug', 'image'];

    /**
     * ** العلاقة الجديدة: كل قسم يحتوي على عدة منتجات **
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}