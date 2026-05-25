<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResourceRequest;
use App\Http\Requests\UpdateResourceRequest;
use App\Models\Category;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ResourceController extends Controller
{
    /**
     * Display paginated list of all active resources (public).
     */
    public function index(Request $request)
    {
        $query = Resource::with(['user', 'category'])
            ->active()
            ->latest();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by type (share / request)
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        $resources  = $query->paginate(12)->withQueryString();
        $categories = $this->cachedCategories();

        return view('resources.index', compact('resources', 'categories'));
    }

    /**
     * Show form to create a new resource (auth required).
     */
    public function create()
    {
        Gate::authorize('create', Resource::class);
        $categories = $this->cachedCategories();
        return view('resources.create', compact('categories'));
    }

    /**
     * Store a new resource in the database.
     */
    public function store(StoreResourceRequest $request)
    {
        $data            = $request->validated();
        $data['user_id'] = Auth::id();

        // Handle optional attachment upload
        if ($request->hasFile('attachment_file')) {
            $data['cover_image'] = $request->file('attachment_file')
                ->store('resources/attachments', 'public');
        }

        unset($data['attachment_file']);

        $resource = Resource::create($data);

        return redirect()
            ->route('resources.show', $resource)
            ->with('success', 'Resource created successfully!');
    }

    /**
     * Display a single resource detail (public).
     */
    public function show(Resource $resource)
    {
        $resource->load(['user', 'category']);
        return view('resources.show', compact('resource'));
    }

    /**
     * Show the edit form (owner only).
     */
    public function edit(Resource $resource)
    {
        Gate::authorize('update', $resource);
        $categories = $this->cachedCategories();
        return view('resources.edit', compact('resource', 'categories'));
    }

    /**
     * Update an existing resource.
     */
    public function update(UpdateResourceRequest $request, Resource $resource)
    {
        Gate::authorize('update', $resource);
        $data = $request->validated();

        if ($request->hasFile('attachment_file')) {
            // Delete old attachment if it exists
            if ($resource->cover_image) {
                Storage::disk('public')->delete($resource->cover_image);
            }
            $data['cover_image'] = $request->file('attachment_file')
                ->store('resources/attachments', 'public');
        }

        unset($data['attachment_file']);

        $resource->update($data);

        return redirect()
            ->route('resources.show', $resource)
            ->with('success', 'Resource updated successfully!');
    }

    /**
     * Soft-delete a resource (owner only).
     */
    public function destroy(Resource $resource)
    {
        Gate::authorize('delete', $resource);

        if ($resource->cover_image) {
            Storage::disk('public')->delete($resource->cover_image);
        }

        $resource->delete();

        return redirect()
            ->route('resources.index')
            ->with('success', 'Resource deleted.');
    }

    /**
     * List the authenticated user's own resources.
     */
    public function myResources()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $resources = $user
            ->resources()
            ->with(['user', 'category'])
            ->latest()
            ->paginate(10);

        return view('resources.my', compact('resources'));
    }

    /**
     * Cache the category list so we do not hit the database repeatedly.
     */
    protected function cachedCategories()
    {
        return cache()->remember('resource.categories', now()->addHour(), function () {
            return Category::orderBy('name')->get();
        });
    }
}
