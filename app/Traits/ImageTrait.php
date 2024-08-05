<?php
namespace App\Traits;
use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait ImageTrait
{
    /**
     * Define a polymorphic relation to images.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function storeImage($request,$model,$path)
    {
        $image = $request->file('image');
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/'.$path), $image_name);

        // Save the image URL in the database
        return $model->image()->create([
            'url' => '/images' . $path . '/' . $image_name
        ]);

}
}
