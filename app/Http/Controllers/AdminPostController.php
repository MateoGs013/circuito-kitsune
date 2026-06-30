<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

/**
 * Class AdminPostController
 *
 * Controlador para la gestión (ABM) de las entradas del blog (Transmisiones) en el panel de administración.
 */
class AdminPostController extends Controller
{
    /**
     * Muestra el listado de transmisiones en el panel de administración.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.posts.index', [
            'posts' => Post::latest('published_at')->get(),
        ]);
    }

    /**
     * Muestra el formulario de creación de una nueva transmisión.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.posts.create');
    }

    /**
     * Almacena una nueva transmisión en la base de datos.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|min:3',
            'excerpt' => 'required|min:5',
            'body' => 'required|min:10',
            'category' => 'required',
            'author' => 'required',
            'reading_time' => 'required|numeric|min:1',
            'cover_tone' => 'required',
        ], [
            'title.required' => 'El título es obligatorio.',
            'title.min' => 'El título debe tener al menos :min caracteres.',
            'excerpt.required' => 'El resumen es obligatorio.',
            'body.required' => 'El contenido es obligatorio.',
            'category.required' => 'La categoría es obligatoria.',
            'author.required' => 'El autor es obligatorio.',
            'reading_time.required' => 'El tiempo de lectura es obligatorio.',
            'reading_time.numeric' => 'El tiempo de lectura debe ser un número.',
        ]);

        $input = $request->all();
        $input['slug'] = Str::slug($request->input('title')) . '-' . uniqid();
        $input['published_at'] = now();
        $input['is_featured'] = $request->has('is_featured');

        $post = Post::create($input);

        return redirect()
            ->route('admin.posts.index')
            ->with('feedback.message', 'La transmisión <b>' . e($post->title) . '</b> se publicó exitosamente en el circuito.')
            ->with('feedback.type', 'success');
    }

    /**
     * Muestra la pantalla de confirmación para eliminar una transmisión.
     *
     * @param int $id
     * @return View
     */
    public function delete(int $id): View
    {
        return view('admin.posts.delete', [
            'post' => Post::findOrFail($id),
        ]);
    }

    /**
     * Elimina una transmisión.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $post = Post::findOrFail($id);

        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('feedback.message', 'La transmisión <b>' . e($post->title) . '</b> fue eliminada del archivo.')
            ->with('feedback.type', 'success');
    }

    /**
     * Muestra el formulario de edición de una transmisión.
     *
     * @param Post $post
     * @return View
     */
    public function edit(Post $post): View
    {
        return view('admin.posts.edit', [
            'post' => $post,
        ]);
    }

    /**
     * Actualiza una transmisión en la base de datos.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required|min:3',
            'excerpt' => 'required|min:5',
            'body' => 'required|min:10',
            'category' => 'required',
            'author' => 'required',
            'reading_time' => 'required|numeric|min:1',
            'cover_tone' => 'required',
        ], [
            'title.required' => 'El título es obligatorio.',
            'title.min' => 'El título debe tener al menos :min caracteres.',
            'excerpt.required' => 'El resumen es obligatorio.',
            'body.required' => 'El contenido es obligatorio.',
            'category.required' => 'La categoría es obligatoria.',
            'author.required' => 'El autor es obligatorio.',
            'reading_time.required' => 'El tiempo de lectura es obligatorio.',
            'reading_time.numeric' => 'El tiempo de lectura debe ser un número.',
        ]);

        $post = Post::findOrFail($id);
        $input = $request->all();
        $input['is_featured'] = $request->has('is_featured');

        $post->update($input);

        return redirect()
            ->route('admin.posts.index')
            ->with('feedback.message', 'La transmisión <b>' . e($post->title) . '</b> se actualizó exitosamente.')
            ->with('feedback.type', 'success');
    }
}

