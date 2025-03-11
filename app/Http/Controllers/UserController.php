<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query pencarian dengan pagination
        $users = User::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('last_name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");

            // Pastikan hanya mencari role jika input cocok dengan salah satu enum
            if (in_array(strtolower($search), ['superadmin', 'admin'])) {
                $query->orWhere('role', strtolower($search));
            }
        })
            ->orderBy('role', 'asc')
            ->paginate(10);

        return view('user.user', compact('users', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:superadmin,admin,user',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = new User();
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $authUser = Auth::user();

        if ($user->name == 'Superadmin') {
            return redirect()->route('user.index')->with('error', 'Superadmin tidak bisa diedit.');
        }

        if ($user->id == $authUser->id) {
            return redirect()->route('user.index')->with('error', 'Anda tidak dapat mengedit akun Anda sendiri.');
        }

        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $authUser = Auth::user();

        if ($user->name == 'Superadmin') {
            return redirect()->route('user.index')->with('error', 'Superadmin tidak bisa diperbarui.');
        }

        if ($authUser->id == $id) {
            return redirect()->route('user.index')->with('error', 'Anda tidak dapat memperbarui akun Anda sendiri.');
        }

        $request->validate([
            'name' => 'required|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,user',
        ]);

        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $authUser = Auth::user();

        if ($user->name == 'Superadmin') {
            return redirect()->route('user.index')->with('error', 'Superadmin tidak bisa dihapus.');
        }

        if ($authUser->id == $id) {
            return redirect()->route('user.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
    }
}
