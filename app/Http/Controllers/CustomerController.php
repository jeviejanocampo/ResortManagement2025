<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index()
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function insertUser(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:6',
            'address' => 'nullable|string',
        ]);

        if (Customer::where('email', $validated['email'])->exists()) {
            return response()->json([
                'message' => 'Email already exists'
            ], 409);
        }

        if (Customer::where('phone', $validated['phone'])->exists()) {
            return response()->json([
                'message' => 'Phone number already exists'
            ], 409);
        }

        $validated['password'] = bcrypt($validated['password']);
        $validated['status'] = 'active';

        $customer = Customer::create($validated);

        return response()->json([
            'message' => 'Customer inserted successfully',
            'customer' => $customer
        ], 201);
    }

    public function LoginCustomer(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'message' => 'Login successful',
            'customer' => $customer
        ], 200);
    }



}
