<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

/**
 * Class AdminProductController
 *
 * Controlador para la gestión (ABM) de las máscaras (Productos) en el panel de administración.
 */
class AdminProductController extends Controller
{
    /**
     * Muestra el listado de máscaras en el panel de administración.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.products.index', [
            'products' => Product::latest()->get(),
        ]);
    }

    /**
     * Muestra el formulario de creación de una nueva máscara.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.products.create');
    }

    /**
     * Almacena una nueva máscara en la base de datos, incluyendo subida de imagen.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|min:3',
            'code' => 'required',
            'category' => 'required',
            'rarity' => 'required',
            'district' => 'required',
            'price' => 'required|numeric|min:0',
            'short_description' => 'required|min:5',
            'long_description' => 'required|min:10',
            'dominant_color' => 'required',
            'status' => 'required',
            'signal_level' => 'required|numeric|min:0|max:99',
            'agility' => 'required|numeric|min:0|max:99',
            'spirit' => 'required|numeric|min:0|max:99',
            'ferocity' => 'required|numeric|min:0|max:99',
            'image' => 'nullable|image',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.min' => 'El nombre debe tener al menos :min caracteres.',
            'code.required' => 'El código es obligatorio.',
            'category.required' => 'La categoría es obligatoria.',
            'rarity.required' => 'La rareza es obligatoria.',
            'district.required' => 'El distrito es obligatorio.',
            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número.',
            'short_description.required' => 'La descripción corta es obligatoria.',
            'long_description.required' => 'La descripción larga es obligatoria.',
            'status.required' => 'El estado es obligatorio.',
            'signal_level.required' => 'El nivel de señal es obligatorio.',
            'signal_level.numeric' => 'El nivel de señal debe ser un número.',
            'agility.required' => 'La agilidad es obligatoria.',
            'agility.numeric' => 'La agilidad debe ser un número.',
            'spirit.required' => 'El espíritu es obligatorio.',
            'spirit.numeric' => 'El espíritu debe ser un número.',
            'ferocity.required' => 'La ferocidad es obligatoria.',
            'ferocity.numeric' => 'La ferocidad debe ser un número.',
            'image.image' => 'El archivo subido debe ser una imagen válida.',
        ]);

        $input = $request->except(['image']);
        $input['slug'] = Str::slug($request->input('name')) . '-' . uniqid();
        $input['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            $input['image_path'] = 'storage/' . $request->file('image')->store('products', 'public');
        }

        $product = Product::create($input);

        return redirect()
            ->route('admin.products.index')
            ->with('feedback.message', 'La máscara <b>' . e($product->name) . '</b> se registró exitosamente en el circuito.')
            ->with('feedback.type', 'success');
    }

    /**
     * Muestra la pantalla de confirmación para eliminar una máscara.
     *
     * @param int $id
     * @return View
     */
    public function delete(int $id): View
    {
        return view('admin.products.delete', [
            'product' => Product::findOrFail($id),
        ]);
    }

    /**
     * Elimina una máscara y su imagen asociada.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        if ($product->image_path && str_starts_with($product->image_path, 'storage/')) {
            Storage::disk('public')->delete(substr($product->image_path, 8));
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('feedback.message', 'La máscara <b>' . e($product->name) . '</b> fue eliminada del archivo.')
            ->with('feedback.type', 'success');
    }

    /**
     * Muestra el formulario de edición de una máscara.
     *
     * @param Product $product
     * @return View
     */
    public function edit(Product $product): View
    {
        return view('admin.products.edit', [
            'product' => $product,
        ]);
    }

    /**
     * Actualiza una máscara en la base de datos, con soporte para cambio de imagen.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|min:3',
            'code' => 'required',
            'category' => 'required',
            'rarity' => 'required',
            'district' => 'required',
            'price' => 'required|numeric|min:0',
            'short_description' => 'required|min:5',
            'long_description' => 'required|min:10',
            'dominant_color' => 'required',
            'status' => 'required',
            'signal_level' => 'required|numeric|min:0|max:99',
            'agility' => 'required|numeric|min:0|max:99',
            'spirit' => 'required|numeric|min:0|max:99',
            'ferocity' => 'required|numeric|min:0|max:99',
            'image' => 'nullable|image',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.min' => 'El nombre debe tener al menos :min caracteres.',
            'code.required' => 'El código es obligatorio.',
            'category.required' => 'La categoría es obligatoria.',
            'rarity.required' => 'La rareza es obligatoria.',
            'district.required' => 'El distrito es obligatorio.',
            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número.',
            'short_description.required' => 'La descripción corta es obligatoria.',
            'long_description.required' => 'La descripción larga es obligatoria.',
            'status.required' => 'El estado es obligatorio.',
            'signal_level.required' => 'El nivel de señal es obligatorio.',
            'signal_level.numeric' => 'El nivel de señal debe ser un número.',
            'agility.required' => 'La agilidad es obligatoria.',
            'agility.numeric' => 'La agilidad debe ser un número.',
            'spirit.required' => 'El espíritu es obligatorio.',
            'spirit.numeric' => 'El espíritu debe ser un número.',
            'ferocity.required' => 'La ferocidad es obligatoria.',
            'ferocity.numeric' => 'La ferocidad debe ser un número.',
            'image.image' => 'El archivo subido debe ser una imagen válida.',
        ]);

        $product = Product::findOrFail($id);
        $input = $request->except(['image']);
        $input['is_featured'] = $request->has('is_featured');
        $oldImage = $product->image_path;

        if ($request->hasFile('image')) {
            $input['image_path'] = 'storage/' . $request->file('image')->store('products', 'public');
            if ($oldImage && str_starts_with($oldImage, 'storage/')) {
                Storage::disk('public')->delete(substr($oldImage, 8));
            }
        }

        $product->update($input);

        return redirect()
            ->route('admin.products.index')
            ->with('feedback.message', 'La máscara <b>' . e($product->name) . '</b> se actualizó exitosamente.')
            ->with('feedback.type', 'success');
    }
}
