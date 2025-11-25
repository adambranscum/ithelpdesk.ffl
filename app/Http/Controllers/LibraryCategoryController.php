<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Library;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibraryCategoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') || !$user->library_uid) {
            abort(403, 'Unauthorized');
        }

        $library = Library::where('uid', $user->library_uid)->firstOrFail();
        $categories = Category::where('library_uid', $library->uid)
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        $categoryTypes = ['department', 'branch', 'network', 'website', 'security'];
        $groupedCategories = [];

        foreach ($categoryTypes as $type) {
            $groupedCategories[$type] = $categories->where('type', $type);
        }

        return view('library.admin.categories.index', [
            'library' => $library,
            'groupedCategories' => $groupedCategories,
            'categoryTypes' => $categoryTypes,
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') || !$user->library_uid) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'type' => ['required', 'in:department,branch,network,website,security'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        Category::create([
            'library_uid' => $user->library_uid,
            'type' => $validated['type'],
            'name' => $validated['name'],
            'is_active' => true,
        ]);

        return back()->with('success', ucfirst($validated['type']) . ' "' . $validated['name'] . '" has been added.');
    }

    public function toggleActive(Category $category)
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') || $user->library_uid !== $category->library_uid) {
            abort(403, 'Unauthorized');
        }

        $category->update(['is_active' => !$category->is_active]);

        $status = $category->is_active ? 'activated' : 'deactivated';
        return back()->with('success', ucfirst($category->type) . ' "' . $category->name . '" has been ' . $status . '.');
    }

    public function destroy(Category $category)
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') || $user->library_uid !== $category->library_uid) {
            abort(403, 'Unauthorized');
        }

        $name = $category->name;
        $type = $category->type;
        $category->delete();

        return back()->with('success', ucfirst($type) . ' "' . $name . '" has been deleted.');
    }
}
