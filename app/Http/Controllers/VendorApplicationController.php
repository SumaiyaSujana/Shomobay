<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendorApplication;
use Illuminate\Support\Facades\Auth;

class VendorApplicationController extends Controller
{
    public function showForm()
    {
        return view('vendor.register');
    }

    public function submitApplication(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'document' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $filePath = $request->file('document')->store('vendor_documents', 'public');

        VendorApplication::create([
            'user_id' => Auth::id(), 
            'business_name' => $request->business_name,
            'document_path' => $filePath,
            'status' => 'pending',
        ]);

        return redirect('/dashboard')->with('success', 'Application submitted successfully!');
    }

    public function approve($id)
    {
        $application = VendorApplication::findOrFail($id);
        $application->update(['status' => 'approved']);

        return redirect('/dashboard')->with('success', 'Vendor application approved!');
    }

    public function reject($id)
    {
        $application = VendorApplication::findOrFail($id);
        $application->update(['status' => 'rejected']);

        return redirect('/dashboard')->with('success', 'Vendor application rejected.');
    }
}