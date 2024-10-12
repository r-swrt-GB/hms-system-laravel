<?php

namespace App\Http\Controllers\Auth;

use App\Http\Classes\FileUploads\FileUploadService;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function createPendingUser(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:' . User::class,
            'role' => 'required|string|max:255',
        ]);

        $user = User::create([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => strtolower($request->get('email')),
            'password' => bcrypt(Str::random(20)),
        ]);

        $roleId = 3;

        $loggedInUser = Auth::user();

        if ($request->get('role') === 'admin' && $loggedInUser->hasRole('admin')) {
            // Get the 'Admin' role ID
            $roleId = DB::table('roles')->where('slug', 'admin')->value('id');
        } else if ($request->get('role') === 'lecturer' && $loggedInUser->hasRole('admin')) {
            $roleId = DB::table('roles')->where('slug', 'lecturer')->value('id');
        } else if ($request->get('role') === 'student' && $loggedInUser->hasRole('lecturer')) {
            $roleId = DB::table('roles')->where('slug', 'student')->value('id');
        }


        DB::table('user_role')->insert([
            'user_id' => $user->id,
            'role_id' => $roleId,
        ]);

        return response()->json([
            'message' => 'User created successfully',
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::where('email', $request['email'])->first();

        if ($user) {

            Auth::login($user);

            $user->first_name = $request['first_name'];
            $user->last_name = $request['last_name'];
            $user->email = strtolower($request['email']);
            $user->password = Hash::make($request['password']);
            $user->save();

            event(new Registered($user));

            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');

                $service = new FileUploadService();
                $service->uploadFile($file, 'avatars', $user->id);
            }

            $token = $user->createToken('authToken')->plainTextToken;

            session(['auth_token' => $token]);

            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        }

        return response()->json([
            'message' => 'Account credentials are invalid.',
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function editUser(Request $request, User $user): JsonResponse
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);


        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->email = strtolower($request['email']);
        $user->save();

        return response()->json([
            'message' => 'Successfully updated user.',
        ]);
    }

    public function deleteUser(Request $request, User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User soft deleted successfully.']);
    }
}
